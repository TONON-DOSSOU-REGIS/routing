<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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
        if ($user->status !== 'active') {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $locale = app()->getLocale();

            if ($user->status === 'pending') {
                return redirect('/' . $locale . '/pending-approval')
                    ->with('status', 'Votre compte n\'est pas encore approuvé. Veuillez patienter.');
            }

            return redirect('/' . $locale . '/login')->withErrors([
                'email' => 'Votre compte est suspendu. Veuillez contacter l\'administrateur.',
            ]);
        }

        if ($user->two_factor_enabled) {
            $request->session()->put('2fa_passed', false);
            $request->session()->put('2fa_user_id', $user->id);

            $locale = app()->getLocale();
            return redirect('/' . $locale . '/two-factor/challenge');
        }

        NotificationService::notifyAdminUserLogin($user, $request->ip(), $request->userAgent());
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
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->forget('2fa_passed');

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
