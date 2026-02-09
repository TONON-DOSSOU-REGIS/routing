<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Locales supportees par l'application
     */
    protected $supportedLocales = [
        'en' => 'English',
        'fr' => 'Fran?ais',
        'de' => 'Deutsch',
        'nl' => 'Nederlands',
        'es' => 'Espa?ol',
        'pl' => 'Polski',
        'it' => 'Italiano'
    ];

    /**
     * Changer la langue de l'application
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Verifier si la locale est supportee
        if (!array_key_exists($locale, $this->supportedLocales)) {
            return redirect()->back()->with('error', 'Langue non supportee.');
        }

        // Definir la locale pour la session en cours
        App::setLocale($locale);

        // Sauvegarder la locale en session
        Session::put('locale', $locale);

        // Si l'utilisateur est authentifie, sauvegarder sa preference en base de donnees
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }

        // Recuperer l'URL precedente
        $previousUrl = url()->previous();
        $currentPath = parse_url($previousUrl, PHP_URL_PATH) ?? '';

        // Si referer est vide ou on vient de /language/{locale}, rediriger vers la racine localisee
        if ($currentPath === '' || $currentPath === '/' || str_starts_with($currentPath, '/language/')) {
            return redirect('/' . $locale)->with('success', __('common.language_changed'));
        }

        // Supprimer l'ancien prefixe de langue s'il existe
        $pathWithoutLocale = preg_replace('#^/(' . implode('|', array_keys($this->supportedLocales)) . ')(/|$)#', '/', $currentPath);

        // Construire la nouvelle URL avec le prefixe de langue
        $newPath = '/' . $locale . $pathWithoutLocale;

        // Nettoyer les doubles slashes
        $newPath = preg_replace('#/+#', '/', $newPath);

        return redirect($newPath)->with('success', __('common.language_changed'));
    }

    /**
     * Obtenir la liste des locales supportees
     *
     * @return array
     */
    public function getSupportedLocales()
    {
        return $this->supportedLocales;
    }

    /**
     * Obtenir la locale courante
     *
     * @return string
     */
    public function getCurrentLocale()
    {
        return App::getLocale();
    }
}
