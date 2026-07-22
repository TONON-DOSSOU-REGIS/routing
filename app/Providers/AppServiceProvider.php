<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\Authenticate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force a real, existing public path (important on shared hosting/public_html).
        $publicPath = $this->resolvePublicPath();
        $this->app->usePublicPath($publicPath);
        $this->app['config']->set('dompdf.public_path', $publicPath);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->environment('local', 'testing')) {
            URL::forceScheme('https');
        }

        // Configure the Authenticate middleware to redirect to login with locale
        Authenticate::redirectUsing(function ($request) {
            $locale = session('locale', config('app.locale', 'fr'));
            return route('login', ['locale' => $locale]);
        });

        ResetPassword::createUrlUsing(function ($user, string $token) {
            $locale = request()?->route('locale')
                ?? $user->locale
                ?? session('locale', config('app.locale', 'fr'));

            return url(route('password.reset', [
                'locale' => $locale,
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));
        });

        Transaction::observe(TransactionObserver::class);
    }

    /**
     * Resolve a valid public path for both Laravel and DomPDF.
     */
    private function resolvePublicPath(): string
    {
        $candidates = array_filter([
            env('APP_PUBLIC_PATH'),
            public_path(),
            base_path('public'),
            base_path('public_html'),
            $_SERVER['DOCUMENT_ROOT'] ?? null,
        ]);

        foreach ($candidates as $candidate) {
            if (! is_string($candidate) || $candidate === '' || ! is_dir($candidate)) {
                continue;
            }

            $resolved = realpath($candidate);
            if ($resolved !== false) {
                return $resolved;
            }
        }

        // Last-resort fallback to keep app booting even if hosting is misconfigured.
        return public_path();
    }
}
