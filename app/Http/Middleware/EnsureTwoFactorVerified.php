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
        $routeName = optional($request->route())->getName();

        if (!$user) {
            return $next($request);
        }

        if ($routeName && str_starts_with($routeName, 'twofactor.')) {
            return $next($request);
        }

        if ($routeName === 'logout') {
            return $next($request);
        }

        if ($user->isAdmin() && !$user->two_factor_enabled) {
            return redirect()
                ->route('twofactor.setup', ['locale' => app()->getLocale()])
                ->with('status', __('auth.2fa_admin_setup_required'));
        }

        if (!$user->two_factor_enabled) {
            return $next($request);
        }

        if ($request->session()->get('2fa_passed') === true) {
            return $next($request);
        }

        return redirect()->route('twofactor.challenge', ['locale' => app()->getLocale()]);
    }
}
