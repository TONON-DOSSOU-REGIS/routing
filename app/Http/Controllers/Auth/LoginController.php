<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Display the login form with no-cache headers and a fresh CSRF token.
     */
    public function showLoginForm(Request $request): Response
    {
        if ($request->hasSession()) {
            $request->session()->regenerateToken();
        }

        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Remove polluted intended URLs (AJAX/API endpoints) to avoid bad post-login redirects.
     */
    private function clearInvalidIntendedUrl(Request $request): void
    {
        $intended = (string) $request->session()->get('url.intended', '');
        if ($intended === '') {
            return;
        }

        $path = parse_url($intended, PHP_URL_PATH) ?: '';
        if ($path === '') {
            return;
        }

        $invalidSegments = [
            '/notification/',
            '/notifications/unread-count',
            '/notifications/recent',
            '/notifications/data',
            '/chat/unread-count',
            '/chat/messages',
            '/api/',
        ];

        foreach ($invalidSegments as $segment) {
            if (str_contains($path, $segment)) {
                $request->session()->forget('url.intended');
                return;
            }
        }
    }

    /**
     * Get the post-login redirect path with locale.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $locale = app()->getLocale();

        if (auth()->user()->isAdmin()) {
            return '/' . $locale . '/admin/dashboard';
        }

        return '/' . $locale . '/dashboard';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $this->clearInvalidIntendedUrl($request);

        if ($user->status !== 'active') {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $locale = app()->getLocale();

            if ($user->status === 'pending') {
                return redirect('/' . $locale . '/pending-approval')
                    ->with('status', __('auth_ui.account_pending'));
            }

            return redirect('/' . $locale . '/login')->withErrors([
                'email' => __('auth_ui.account_suspended'),
            ]);
        }

        if ($user->two_factor_enabled) {
            $request->session()->put('2fa_passed', false);
            $request->session()->put('2fa_user_id', $user->id);
            $request->session()->put('2fa_login_notification_pending', true);

            $locale = app()->getLocale();
            return redirect('/' . $locale . '/two-factor/challenge');
        }

        NotificationService::notifyAdminUserLogin($user, $request->ip(), $request->userAgent());

        if ($user->isAdmin()) {
            return redirect()
                ->route('twofactor.setup', ['locale' => app()->getLocale()])
                ->with('status', __('auth.2fa_admin_setup_required'));
        }

        // Always land on role dashboard right after login.
        return redirect($this->redirectPath());
    }

    /**
     * Log the current user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            NotificationService::notifyAdminUserLogout($user, $request->ip());
            try {
                Cache::forget("chat:user:presence:{$user->id}");
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->forget('2fa_passed');
        $request->session()->forget('2fa_login_notification_pending');
        $request->session()->regenerateToken();

        $locale = app()->getLocale();

        return $this->loggedOut($request) ?: redirect('/' . $locale);
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
