<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user || !$user->two_factor_enabled) {
            return $next($request);
        }

        if ($request->session()->get('2fa_passed') === true) {
            return $next($request);
        }

        $routeName = optional($request->route())->getName();
        if ($routeName && str_starts_with($routeName, 'twofactor.')) {
            return $next($request);
        }

        if ($routeName === 'logout') {
            return $next($request);
        }

        return redirect()->route('twofactor.challenge', ['locale' => app()->getLocale()]);
    }
}
