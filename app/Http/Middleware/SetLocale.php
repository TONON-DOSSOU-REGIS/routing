<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Locales supportées par l'application
     */
    protected $supportedLocales = ['en', 'fr', 'de', 'nl', 'es', 'pl', 'it'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifier si une locale est présente dans l'URL (priorité maximale)
        $segments = $request->segments();
        if (!empty($segments) && in_array($segments[0], $this->supportedLocales)) {
            $locale = $segments[0];
            App::setLocale($locale);
            Session::put('locale', $locale);
            
            // Si l'utilisateur est authentifié, sauvegarder sa préférence
            if (auth()->check()) {
                auth()->user()->update(['locale' => $locale]);
            }
        }
        // 2. Vérifier si une locale est stockée en session
        elseif (Session::has('locale') && in_array(Session::get('locale'), $this->supportedLocales)) {
            App::setLocale(Session::get('locale'));
        }
        // 3. Vérifier si l'utilisateur est authentifié et a une préférence de langue
        elseif (auth()->check() && auth()->user()->locale && in_array(auth()->user()->locale, $this->supportedLocales)) {
            $locale = auth()->user()->locale;
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
        // 4. Détecter la langue depuis le navigateur (Accept-Language header)
        else {
            $locale = $request->getPreferredLanguage($this->supportedLocales);
            App::setLocale($locale ?? config('app.locale', 'fr'));
        }

        return $next($request);
    }
}
