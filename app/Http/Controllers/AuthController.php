<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private function adminEmail(): string
    {
        return (string) config('mail.admin_address', 'admin@valtrixbank.com');
    }

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

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $this->clearInvalidIntendedUrl($request);

            $user = Auth::user();

            // Prevent login if user status is not 'active'
            if ($user->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $locale = app()->getLocale();

                if ($user->status === 'pending') {
                    return redirect('/' . $locale . '/pending-approval')
                        ->with('status', 'Votre compte n\'est pas encore approuvé. Veuillez patienter.');
                }

                return back()->withErrors([
                    'email' => 'Votre compte est suspendu. Veuillez contacter l\'administrateur.',
                ]);
            }

                // Send login notification to admin if user is not admin
            if (!$user->isAdmin()) {
                try {
                    $admin = User::where('email', $this->adminEmail())->first();
                    if ($admin) {
                        \Mail::to($admin->email)->send(new \App\Mail\UserLoginNotification(
                            $user,
                            now(),
                            $request->ip(),
                            $request->userAgent()
                        ));
                    }
                } catch (\Exception $e) {
                    // Log error but don't interrupt login
                    \Log::error('Failed to send login notification: ' . $e->getMessage());
                }

                // Send in-app notification to all admins
                try {
                    \App\Services\NotificationService::notifyAdminUserLogin(
                        $user,
                        $request->ip(),
                        $request->userAgent()
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send in-app login notification to admins: ' . $e->getMessage());
                }

                // Send in-app notification to user
                try {
                    \App\Services\NotificationService::notifyUserLogin(
                        $user,
                        $request->ip(),
                        $request->userAgent()
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send in-app login notification to user: ' . $e->getMessage());
                }
            }

            $locale = app()->getLocale();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard', ['locale' => $locale]);
            }

            return redirect('/' . $locale . '/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'id_type' => 'nullable|in:CNI,Passport,Permis',
            'id_number' => 'nullable|string|max:50|unique:users',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'date_of_birth' => $request->date_of_birth,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'password' => Hash::make($request->password),
            'activation_code' => $request->activation_code ?? null,
            'status' => 'pending',
        ]);

        // Notify admin of new pending user registration
        try {
            $admin = User::where('email', $this->adminEmail())->first();
            if ($admin) {
                Mail::to($admin->email)->send(new \App\Mail\UserRegistrationNotification(
                    $user,
                    now(),
                    $request->ip()
                ));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send new user registration notification to admin: ' . $e->getMessage());
        }

        // Send in-app notification to all admins
        try {
            \App\Services\NotificationService::notifyAdminUserRegistration($user, $request->ip());
        } catch (\Exception $e) {
            Log::error('Failed to send in-app registration notification to admins: ' . $e->getMessage());
        }

        $locale = app()->getLocale();
        return redirect('/' . $locale . '/login')->with('success', 'Inscription réussie ! Votre compte est en attente de validation par un administrateur. Vous recevrez un email une fois votre compte validé.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Send logout notification to admins if user is not admin
        if ($user && !$user->isAdmin()) {
            try {
                \App\Services\NotificationService::notifyAdminUserLogout($user, $request->ip());
            } catch (\Exception $e) {
                \Log::error('Failed to send logout notification to admins: ' . $e->getMessage());
            }
        }

        if ($user) {
            try {
                Cache::forget("chat:user:presence:{$user->id}");
            } catch (\Throwable $e) {
                \Log::warning('Failed to clear chat presence key during logout: ' . $e->getMessage());
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

