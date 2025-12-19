<?php

/**
 * Script pour ajouter les traductions manquantes dans tous les fichiers de langue
 */

echo "=== AJOUT DES TRADUCTIONS MANQUANTES ===\n\n";

// Traductions à ajouter dans common.php
$commonTranslations = [
    'welcome' => [
        'en' => 'Welcome',
        'fr' => 'Bienvenue',
        'de' => 'Willkommen',
        'nl' => 'Welkom',
        'es' => 'Bienvenido',
        'pl' => 'Witamy',
        'it' => 'Benvenuto',
    ],
    'home' => [
        'en' => 'Home',
        'fr' => 'Accueil',
        'de' => 'Startseite',
        'nl' => 'Home',
        'es' => 'Inicio',
        'pl' => 'Strona główna',
        'it' => 'Home',
    ],
    'about' => [
        'en' => 'About',
        'fr' => 'À propos',
        'de' => 'Über uns',
        'nl' => 'Over ons',
        'es' => 'Acerca de',
        'pl' => 'O nas',
        'it' => 'Chi siamo',
    ],
    'services' => [
        'en' => 'Services',
        'fr' => 'Services',
        'de' => 'Dienstleistungen',
        'nl' => 'Diensten',
        'es' => 'Servicios',
        'pl' => 'Usługi',
        'it' => 'Servizi',
    ],
    'contact' => [
        'en' => 'Contact',
        'fr' => 'Contact',
        'de' => 'Kontakt',
        'nl' => 'Contact',
        'es' => 'Contacto',
        'pl' => 'Kontakt',
        'it' => 'Contatto',
    ],
    'login' => [
        'en' => 'Login',
        'fr' => 'Connexion',
        'de' => 'Anmelden',
        'nl' => 'Inloggen',
        'es' => 'Iniciar sesión',
        'pl' => 'Zaloguj się',
        'it' => 'Accedi',
    ],
    'register' => [
        'en' => 'Register',
        'fr' => 'Inscription',
        'de' => 'Registrieren',
        'nl' => 'Registreren',
        'es' => 'Registrarse',
        'pl' => 'Zarejestruj się',
        'it' => 'Registrati',
    ],
    'logout' => [
        'en' => 'Logout',
        'fr' => 'Déconnexion',
        'de' => 'Abmelden',
        'nl' => 'Uitloggen',
        'es' => 'Cerrar sesión',
        'pl' => 'Wyloguj się',
        'it' => 'Esci',
    ],
    'dashboard' => [
        'en' => 'Dashboard',
        'fr' => 'Tableau de bord',
        'de' => 'Dashboard',
        'nl' => 'Dashboard',
        'es' => 'Panel',
        'pl' => 'Panel',
        'it' => 'Dashboard',
    ],
    'profile' => [
        'en' => 'Profile',
        'fr' => 'Profil',
        'de' => 'Profil',
        'nl' => 'Profiel',
        'es' => 'Perfil',
        'pl' => 'Profil',
        'it' => 'Profilo',
    ],
];

$languages = ['en', 'fr', 'de', 'nl', 'es', 'pl', 'it'];

foreach ($languages as $lang) {
    $filePath = "lang/$lang/common.php";
    
    echo "Traitement de $filePath...\n";
    
    if (!file_exists($filePath)) {
        echo "  ✗ Fichier non trouvé\n";
        continue;
    }
    
    // Charger le fichier existant
    $existingTranslations = include($filePath);
    
    // Compter les traductions ajoutées
    $added = 0;
    
    // Ajouter les nouvelles traductions
    foreach ($commonTranslations as $key => $translations) {
        if (!isset($existingTranslations[$key])) {
            $existingTranslations[$key] = $translations[$lang];
            $added++;
        }
    }
    
    if ($added > 0) {
        // Générer le nouveau contenu du fichier
        $content = "<?php\n\nreturn [\n";
        $content .= "    /*\n";
        $content .= "    |--------------------------------------------------------------------------\n";
        $content .= "    | Lignes de Langue Communes\n";
        $content .= "    |--------------------------------------------------------------------------\n";
        $content .= "    */\n\n";
        
        // Ajouter les nouvelles traductions en premier
        $content .= "    // Navigation\n";
        foreach ($commonTranslations as $key => $translations) {
            $value = str_replace("'", "\\'", $translations[$lang]);
            $content .= "    '$key' => '$value',\n";
        }
        $content .= "\n";
        
        // Ajouter les traductions existantes
        $content .= "    // Actions\n";
        foreach ($existingTranslations as $key => $value) {
            if (!isset($commonTranslations[$key])) {
                $value = str_replace("'", "\\'", $value);
                $content .= "    '$key' => '$value',\n";
            }
        }
        
        $content .= "];\n";
        
        // Sauvegarder le fichier
        file_put_contents($filePath, $content);
        echo "  ✓ $added traductions ajoutées\n";
    } else {
        echo "  ✓ Aucune traduction à ajouter\n";
    }
}

echo "\n=== TRADUCTIONS AJOUTÉES AVEC SUCCÈS ===\n";
echo "\nProchaines étapes:\n";
echo "1. Exécutez: php artisan config:clear\n";
echo "2. Exécutez: php artisan view:clear\n";
echo "3. Redémarrez Apache dans XAMPP\n";
echo "4. Testez le sélecteur de langue sur: http://localhost/cerveau\n";
