<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\Authenticate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure the Authenticate middleware to redirect to login with locale
        Authenticate::redirectUsing(function ($request) {
            $locale = session('locale', config('app.locale', 'fr'));
            return route('login', ['locale' => $locale]);
        });
    }
}

