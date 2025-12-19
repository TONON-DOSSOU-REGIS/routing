<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Locales supportées par l'application
     */
    protected $supportedLocales = [
        'en' => 'English',
        'fr' => 'Français',
        'de' => 'Deutsch',
        'nl' => 'Nederlands',
        'es' => 'Español',
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
        // Vérifier si la locale est supportée
        if (!array_key_exists($locale, $this->supportedLocales)) {
            return redirect()->back()->with('error', 'Langue non supportée.');
        }

        // Définir la locale pour la session en cours
        App::setLocale($locale);
        
        // Sauvegarder la locale en session
        Session::put('locale', $locale);

        // Si l'utilisateur est authentifié, sauvegarder sa préférence en base de données
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }

        // Récupérer l'URL précédente
        $previousUrl = url()->previous();
        $currentPath = parse_url($previousUrl, PHP_URL_PATH);
        
        // Supprimer l'ancien préfixe de langue s'il existe
        $pathWithoutLocale = preg_replace('#^/(' . implode('|', array_keys($this->supportedLocales)) . ')(/|$)#', '/', $currentPath);
        
        // Construire la nouvelle URL avec le préfixe de langue
        $newPath = '/' . $locale . $pathWithoutLocale;
        
        // Nettoyer les doubles slashes
        $newPath = preg_replace('#/+#', '/', $newPath);
        
        return redirect($newPath)->with('success', __('common.language_changed'));
    }

    /**
     * Obtenir la liste des locales supportées
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
