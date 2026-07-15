<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Support\Totp;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    /**
     * Remove polluted intended URLs (AJAX/API endpoints) before post-2FA redirect.
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

    public function setup(Request $request)
    {
        $user = $request->user();
        $isAdminTwoFactorMandatory = (bool) ($user?->isAdmin() ?? false);

        if (!$user->two_factor_secret) {
            $user->two_factor_secret = Totp::generateSecret();
            $user->two_factor_enabled = false;
            $user->two_factor_confirmed_at = null;
            $user->two_factor_backup_codes = null;
            $user->save();
        }

        $issuer = config('app.name', 'Zuider Bank S.A');
        $otpauth = Totp::getOtpAuthUrl($issuer, $user->email, $user->two_factor_secret);
        $qrSvg = $this->generateTwoFactorQrSvg($otpauth);

        return view('auth.two-factor-setup', [
            'user' => $user,
            'otpauth' => $otpauth,
            'qrSvg' => $qrSvg,
            'backupCodes' => session()->get('two_factor_backup_codes'),
            'isAdminTwoFactorMandatory' => $isAdminTwoFactorMandatory,
            'dashboardUrl' => $this->getRoleDashboardPath($user),
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
        $user = $request->user();
        if ($user && $user->isAdmin()) {
            return redirect()->back()->withErrors([
                'password' => __('auth.2fa_admin_disable_forbidden'),
            ]);
        }

        $request->validate([
            'password' => ['required'],
        ]);

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
            return $this->redirectToRoleDashboard($user);
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
            return $this->redirectToRoleDashboard($user);
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
        if ($request->session()->pull('2fa_login_notification_pending', false)) {
            try {
                NotificationService::notifyAdminUserLogin($user, $request->ip(), (string) $request->userAgent());
            } catch (\Throwable $e) {
                report($e);
            }
        }
        $this->clearInvalidIntendedUrl($request);

        $defaultRedirect = $this->getRoleDashboardPath($user);

        return redirect($defaultRedirect);
    }

    private function redirectToRoleDashboard($user)
    {
        $locale = app()->getLocale();

        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard', ['locale' => $locale]);
        }

        return redirect()->route('dashboard', ['locale' => $locale]);
    }

    private function getRoleDashboardPath($user): string
    {
        $locale = app()->getLocale();

        if ($user && $user->isAdmin()) {
            return '/' . $locale . '/admin/dashboard';
        }

        return '/' . $locale . '/dashboard';
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

    private function generateTwoFactorQrSvg(string $otpauth): ?string
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(
                    280,
                    2,
                    null,
                    null,
                    Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(15, 23, 42))
                ),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $svg = $writer->writeString($otpauth);
            $svg = preg_replace('/<\?xml.*?\?>\s*/', '', $svg) ?: $svg;

            return str_replace('<svg ', '<svg class="twofactor-qr-svg" ', $svg);
        } catch (\Throwable $exception) {
            report($exception);

            return null;
        }
    }
}
