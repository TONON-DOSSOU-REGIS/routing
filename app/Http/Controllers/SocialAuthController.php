<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to the provider authentication page.
     */
    public function redirect(Request $request, string $locale, string $provider): RedirectResponse
    {
        if (!in_array($provider, ['google', 'apple'], true)) {
            return redirect('/' . $locale . '/login')
                ->with('error', __('auth.social_invalid_provider'));
        }

        $callbackUrl = url('/' . $locale . '/auth/' . $provider . '/callback');

        return Socialite::driver($provider)
            ->redirectUrl($callbackUrl)
            ->redirect();
    }

    /**
     * Handle the provider callback.
     */
    public function callback(Request $request, string $locale, string $provider): RedirectResponse
    {
        if (!in_array($provider, ['google', 'apple'], true)) {
            return redirect('/' . $locale . '/login')
                ->with('error', __('auth.social_invalid_provider'));
        }

        try {
            $callbackUrl = url('/' . $locale . '/auth/' . $provider . '/callback');
            $socialUser = Socialite::driver($provider)
                ->redirectUrl($callbackUrl)
                ->user();
        } catch (\Throwable $e) {
            return redirect('/' . $locale . '/login')
                ->with('error', __('auth.social_login_error'));
        }

        $email = $socialUser->getEmail();
        if (empty($email)) {
            return redirect('/' . $locale . '/login')
                ->with('error', __('auth.social_missing_email'));
        }

        $user = User::where('oauth_provider', $provider)
            ->where('oauth_id', $socialUser->getId())
            ->first();

        if (!$user) {
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            [$firstName, $lastName] = $this->splitName($socialUser->getName(), $email);

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => null,
                'address' => null,
                'country' => null,
                'city' => null,
                'date_of_birth' => null,
                'id_type' => 'Passport',
                'id_number' => null,
                'iban' => null,
                'bic' => null,
                'role' => 'user',
                'balance' => 0.00,
                'default_currency' => 'EUR',
                'status' => 'pending',
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
                'locale' => $locale,
                'oauth_provider' => $provider,
                'oauth_id' => $socialUser->getId(),
            ]);
        } else {
            $dirty = false;
            if (!$user->oauth_provider) {
                $user->oauth_provider = $provider;
                $dirty = true;
            }
            if (!$user->oauth_id) {
                $user->oauth_id = $socialUser->getId();
                $dirty = true;
            }
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $dirty = true;
            }
            if ($dirty) {
                $user->save();
            }
        }

        Auth::login($user, true);

        if ($user->status === 'pending') {
            Auth::logout();
            return redirect('/' . $locale . '/pending-approval');
        }

        return redirect('/' . $locale . '/dashboard');
    }

    private function splitName(?string $name, string $email): array
    {
        $name = trim((string) $name);
        if ($name !== '') {
            $parts = preg_split('/\s+/', $name);
            $first = array_shift($parts);
            $last = $parts ? implode(' ', $parts) : 'User';
            return [$first, $last];
        }

        $fallback = explode('@', $email)[0] ?? 'User';
        return [$fallback, 'User'];
    }
}
