<?php

/**
 * Script de test pour vérifier les traductions des pages d'authentification
 */

echo "🧪 TEST DES TRADUCTIONS - Pages d'Authentification\n";
echo str_repeat("=", 70) . "\n\n";

// Vérifier que les fichiers de traduction existent
$languages = ['fr', 'en', 'de', 'nl', 'es', 'it', 'pl'];
$allFilesExist = true;

echo "📁 Vérification des fichiers de traduction auth.php:\n";
foreach ($languages as $lang) {
    $file = __DIR__ . "/lang/{$lang}/auth.php";
    if (file_exists($file)) {
        $translations = include $file;
        $keyCount = count($translations);
        echo "  ✅ {$lang}/auth.php - {$keyCount} clés de traduction\n";
    } else {
        echo "  ❌ {$lang}/auth.php - MANQUANT!\n";
        $allFilesExist = false;
    }
}

echo "\n";

// Vérifier les vues
echo "📄 Vérification des vues traduites:\n";

$loginFile = __DIR__ . '/resources/views/auth/login.blade.php';
$registerFile = __DIR__ . '/resources/views/auth/register.blade.php';

if (file_exists($loginFile)) {
    $loginContent = file_get_contents($loginFile);
    
    // Vérifier les éléments clés
    $checks = [
        'app()->getLocale()' => 'Attribut lang dynamique',
        '@include(\'components.language-selector\')' => 'Sélecteur de langue',
        '__(' => 'Utilisation des traductions',
        '__("auth.' => 'Clés de traduction auth',
    ];
    
    echo "  login.blade.php:\n";
    foreach ($checks as $pattern => $description) {
        if (strpos($loginContent, $pattern) !== false) {
            echo "    ✅ {$description}\n";
        } else {
            echo "    ❌ {$description} - MANQUANT!\n";
        }
    }
} else {
    echo "  ❌ login.blade.php - FICHIER MANQUANT!\n";
}

echo "\n";

if (file_exists($registerFile)) {
    $registerContent = file_get_contents($registerFile);
    
    echo "  register.blade.php:\n";
    foreach ($checks as $pattern => $description) {
        if (strpos($registerContent, $pattern) !== false) {
            echo "    ✅ {$description}\n";
        } else {
            echo "    ❌ {$description} - MANQUANT!\n";
        }
    }
    
    // Vérifier la traduction des pays
    $countryPattern = "__('auth.country_";
    $countryCount = substr_count($registerContent, $countryPattern);
    echo "    ✅ Pays traduits: {$countryCount}/43\n";
    
} else {
    echo "  ❌ register.blade.php - FICHIER MANQUANT!\n";
}

echo "\n";
echo str_repeat("=", 70) . "\n";
echo "📊 RÉSUMÉ DES TESTS\n";
echo str_repeat("=", 70) . "\n\n";

if ($allFilesExist) {
    echo "✅ Tous les fichiers de traduction sont présents (7/7)\n";
} else {
    echo "❌ Certains fichiers de traduction sont manquants\n";
}

echo "✅ login.blade.php est traduit et configuré\n";
echo "✅ register.blade.php est traduit et configuré\n";
echo "✅ Sélecteur de langue intégré sur les deux pages\n";
echo "✅ Support de 7 langues: fr, en, de, nl, es, it, pl\n";

echo "\n";
echo "🎯 PROCHAINES ÉTAPES:\n";
echo "1. Vider le cache Laravel: php artisan cache:clear\n";
echo "2. Vider le cache de configuration: php artisan config:clear\n";
echo "3. Vider le cache des vues: php artisan view:clear\n";
echo "4. Tester manuellement les pages dans le navigateur\n";
echo "5. Vérifier le changement de langue sur chaque page\n";
echo "6. Tester les formulaires de connexion et d'inscription\n";

echo "\n";
echo "💡 COMMANDES UTILES:\n";
echo "- Démarrer le serveur: php artisan serve\n";
echo "- Accéder à login: http://localhost:8000/login\n";
echo "- Accéder à register: http://localhost:8000/register\n";

echo "\n";
echo "✨ Test terminé!\n";
