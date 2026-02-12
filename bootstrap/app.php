<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withBroadcasting(__DIR__.'/../routes/channels.php', [
        'middleware' => ['web', 'auth'],
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'notAdmin' => \App\Http\Middleware\EnsureNotAdmin::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'checkUserStatus' => \App\Http\Middleware\CheckUserStatus::class,
            'twofactor' => \App\Http\Middleware\EnsureTwoFactorVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
