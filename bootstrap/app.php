<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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

        // Allow logout even when the previous CSRF token has expired,
        // so users can always leave their session without seeing a 419 page.
        $middleware->validateCsrfTokens(except: [
            'logout',
            '*/logout',
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
        $handleExpiredSession = function ($request) {
            $supportedLocales = ['en', 'fr', 'de', 'nl', 'es', 'pl', 'it'];
            $routeLocale = (string) $request->route('locale', '');
            $sessionLocale = $request->hasSession()
                ? (string) $request->session()->get('locale', '')
                : '';

            $locale = in_array($routeLocale, $supportedLocales, true)
                ? $routeLocale
                : (in_array($sessionLocale, $supportedLocales, true) ? $sessionLocale : config('app.locale', 'fr'));

            if ($request->hasSession()) {
                $request->session()->regenerateToken();
            }

            $input = $request->except([
                '_token',
                'password',
                'password_confirmation',
            ]);

            if ($request->is('login') || $request->is('*/login')) {
                return redirect('/' . $locale . '/login')
                    ->withInput($input)
                    ->withErrors([
                        'email' => __('chat.security_session_expired'),
                    ]);
            }

            return redirect()->back()
                ->withInput($input)
                ->withErrors([
                    'session' => __('chat.security_session_expired'),
                ]);
        };

        $exceptions->render(function (TokenMismatchException $exception, $request) use ($handleExpiredSession) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('chat.security_session_expired'),
                ], 419);
            }

            return $handleExpiredSession($request);
        });

        $exceptions->render(function (HttpExceptionInterface $exception, $request) use ($handleExpiredSession) {
            if ((int) $exception->getStatusCode() !== 419) {
                return null;
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('chat.security_session_expired'),
                ], 419);
            }

            return $handleExpiredSession($request);
        });
    })->create();
