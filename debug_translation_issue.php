<?php
/**
 * Script de diagnostic pour identifier pourquoi les traductions ne fonctionnent pas
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "🔍 DIAGNOSTIC DU PROBLÈME DE TRADUCTION\n";
echo str_repeat("=", 70) . "\n\n";

// 1. Vérifier la locale actuelle
echo "1️⃣  LOCALE ACTUELLE\n";
echo str_repeat("-", 70) . "\n";
$currentLocale = app()->getLocale();
echo "Locale active : $currentLocale\n";
echo "Locale attendue : fr (par défaut) ou en (après changement)\n\n";

// 2. Tester une traduction simple
echo "2️⃣  TEST DE TRADUCTION SIMPLE\n";
echo str_repeat("-", 70) . "\n";

// Forcer la locale en français
app()->setLocale('fr');
$testFr = __('home.hero_title_1');
echo "🇫🇷 FR - home.hero_title_1 : $testFr\n";

// Forcer la locale en anglais
app()->setLocale('en');
$testEn = __('home.hero_title_1');
echo "🇬🇧 EN - home.hero_title_1 : $testEn\n\n";

if ($testFr === 'home.hero_title_1' || $testEn === 'home.hero_title_1') {
    echo "❌ PROBLÈME : Les traductions retournent les clés au lieu des valeurs\n";
    echo "   Cela signifie que Laravel ne trouve pas les fichiers de traduction\n\n";
} else {
    echo "✅ Les traductions fonctionnent correctement\n\n";
}

// 3. Vérifier les chemins des fichiers
echo "3️⃣  CHEMINS DES FICHIERS DE TRADUCTION\n";
echo str_repeat("-", 70) . "\n";

$langPath = base_path('lang');
echo "Chemin lang/ : $langPath\n";
echo "Existe : " . (is_dir($langPath) ? "✅ OUI" : "❌ NON") . "\n\n";

// 4. Lister les fichiers de traduction
echo "4️⃣  FICHIERS DE TRADUCTION DISPONIBLES\n";
echo str_repeat("-", 70) . "\n";

if (is_dir($langPath)) {
    $locales = scandir($langPath);
    foreach ($locales as $locale) {
        if ($locale === '.' || $locale === '..') continue;
        
        $localePath = "$langPath/$locale";
        if (is_dir($localePath)) {
            echo "📁 $locale/\n";
            $files = scandir($localePath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                echo "   ✅ $file\n";
            }
        }
    }
} else {
    echo "❌ Le dossier lang/ n'existe pas !\n";
}

echo "\n";

// 5. Vérifier le contenu d'un fichier de traduction
echo "5️⃣  CONTENU DE lang/fr/home.php\n";
echo str_repeat("-", 70) . "\n";

if (file_exists("$langPath/fr/home.php")) {
    $homeFr = include "$langPath/fr/home.php";
    echo "Nombre de clés : " . count($homeFr) . "\n";
    echo "Premières clés :\n";
    $count = 0;
    foreach ($homeFr as $key => $value) {
        if ($count++ >= 5) break;
        echo "  - $key => " . substr($value, 0, 50) . "...\n";
    }
} else {
    echo "❌ Le fichier lang/fr/home.php n'existe pas !\n";
}

echo "\n";

// 6. Vérifier la session
echo "6️⃣  VÉRIFICATION SESSION\n";
echo str_repeat("-", 70) . "\n";
echo "⚠️  La session ne peut pas être testée via CLI\n";
echo "   Vous devez tester via le navigateur\n\n";

// 7. Vérifier le middleware
echo "7️⃣  VÉRIFICATION MIDDLEWARE\n";
echo str_repeat("-", 70) . "\n";

$kernelPath = app_path('Http/Kernel.php');
$kernelContent = file_get_contents($kernelPath);

if (strpos($kernelContent, 'SetLocale') !== false) {
    echo "✅ SetLocale trouvé dans Kernel.php\n";
} else {
    echo "❌ SetLocale NON trouvé dans Kernel.php\n";
}

echo "\n";

// 8. Diagnostic final
echo str_repeat("=", 70) . "\n";
echo "📊 DIAGNOSTIC FINAL\n";
echo str_repeat("=", 70) . "\n\n";

echo "CAUSES POSSIBLES DU PROBLÈME :\n\n";

echo "1. ❓ Le formulaire du sélecteur ne soumet pas correctement\n";
echo "   → Vérifier que le formulaire a un @csrf token\n";
echo "   → Vérifier que l'action pointe vers la bonne route\n\n";

echo "2. ❓ La route ne correspond pas\n";
echo "   → Route définie : POST /language/{locale}\n";
echo "   → Vérifier que le formulaire utilise POST\n\n";

echo "3. ❓ Le middleware ne s'exécute pas\n";
echo "   → Vérifier que SetLocale est dans le groupe 'web'\n";
echo "   → Vérifier l'ordre des middlewares\n\n";

echo "4. ❓ La session ne persiste pas\n";
echo "   → Vérifier la configuration de session\n";
echo "   → Vérifier que les cookies sont activés\n\n";

echo "PROCHAINE ÉTAPE :\n";
echo "→ Ouvrez la console du navigateur (F12)\n";
echo "→ Cliquez sur le sélecteur de langue\n";
echo "→ Regardez l'onglet Network pour voir la requête POST\n";
echo "→ Vérifiez s'il y a des erreurs 404, 405 ou 500\n\n";

echo "✅ Diagnostic terminé !\n";
