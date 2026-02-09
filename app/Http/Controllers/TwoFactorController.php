<?php

namespace App\Http\Controllers;

use App\Support\Totp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function setup(Request $request)
    {
        $user = $request->user();

        if (!$user->two_factor_secret) {
            $user->two_factor_secret = Totp::generateSecret();
            $user->two_factor_enabled = false;
            $user->two_factor_confirmed_at = null;
            $user->two_factor_backup_codes = null;
            $user->save();
        }

        $issuer = config('app.name', 'SG BANK');
        $otpauth = Totp::getOtpAuthUrl($issuer, $user->email, $user->two_factor_secret);

        return view('auth.two-factor-setup', [
            'user' => $user,
            'otpauth' => $otpauth,
            'backupCodes' => session()->get('two_factor_backup_codes'),
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $request->user();
        if (!$user->two_factor_secret) {
            return redirect()->back()->withErrors(['code' => __('auth.2fa_missing_secret')]);
        }

        if (!Totp::verifyCode($user->two_factor_secret, $request->input('code'))) {
            return redirect()->back()->withErrors(['code' => __('auth.2fa_invalid_code')]);
        }

        $backupCodes = $this->generateBackupCodes();
        $user->two_factor_backup_codes = array_map(fn ($code) => Hash::make($code), $backupCodes);
        $user->two_factor_enabled = true;
        $user->two_factor_confirmed_at = now();
        $user->save();

        $request->session()->put('two_factor_backup_codes', $backupCodes);
        $request->session()->put('2fa_passed', true);

        return redirect()->route('twofactor.setup', ['locale' => app()->getLocale()])
            ->with('status', __('auth.2fa_enabled'));
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();
        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->withErrors(['password' => __('auth.2fa_password_invalid')]);
        }

        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->two_factor_backup_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        $request->session()->forget('2fa_passed');

        return redirect()->route('twofactor.setup', ['locale' => app()->getLocale()])
            ->with('status', __('auth.2fa_disabled'));
    }

    public function challenge(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('dashboard', ['locale' => app()->getLocale()]);
        }

        return view('auth.two-factor-challenge', [
            'email' => $user->email,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['nullable', 'string'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        $user = $request->user();
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('dashboard', ['locale' => app()->getLocale()]);
        }

        $code = $request->input('code');
        $recoveryCode = $request->input('recovery_code');

        $verified = false;
        if ($code) {
            $verified = Totp::verifyCode($user->two_factor_secret, $code);
        } elseif ($recoveryCode) {
            $verified = $this->consumeBackupCode($user, $recoveryCode);
        }

        if (!$verified) {
            return redirect()->back()->withErrors(['code' => __('auth.2fa_invalid_code')]);
        }

        $request->session()->put('2fa_passed', true);

        return redirect()->intended('/' . app()->getLocale() . '/dashboard');
    }

    private function generateBackupCodes(int $count = 10): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = strtoupper(Str::random(10));
        }
        return $codes;
    }

    private function consumeBackupCode($user, string $plainCode): bool
    {
        $plainCode = strtoupper(trim($plainCode));
        $codes = $user->two_factor_backup_codes ?? [];
        $remaining = [];
        $matched = false;

        foreach ($codes as $hash) {
            if (!$matched && Hash::check($plainCode, $hash)) {
                $matched = true;
                continue;
            }
            $remaining[] = $hash;
        }

        if ($matched) {
            $user->two_factor_backup_codes = $remaining;
            $user->save();
        }

        return $matched;
    }
}
