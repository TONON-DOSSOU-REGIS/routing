<?php

/**
 * TEST COMPLET DU SYSTÈME DE TRADUCTION
 * Ce script teste tous les aspects du système de traduction
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║     TEST COMPLET DU SYSTÈME DE TRADUCTION - DIAGNOSTIC        ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$errors = [];
$warnings = [];
$success = [];

// ============================================================================
// TEST 1: Configuration de Base
// ============================================================================
echo "📋 TEST 1: Configuration de Base\n";
echo str_repeat("─", 70) . "\n";

$defaultLocale = config('app.locale');
$fallbackLocale = config('app.fallback_locale');
$currentLocale = app()->getLocale();

echo "   Locale par défaut (config): {$defaultLocale}\n";
echo "   Locale de secours: {$fallbackLocale}\n";
echo "   Locale actuelle: {$currentLocale}\n";

if ($defaultLocale === 'en') {
    $success[] = "Configuration locale correcte";
} else {
    $warnings[] = "Locale par défaut n'est pas 'en' mais '{$defaultLocale}'";
}

echo "\n";

// ============================================================================
// TEST 2: Fichiers de Traduction
// ============================================================================
echo "📁 TEST 2: Fichiers de Traduction\n";
echo str_repeat("─", 70) . "\n";

$locales = ['en', 'fr', 'de', 'nl', 'es', 'pl', 'it'];
$requiredFiles = ['home.php', 'common.php'];
$missingFiles = [];

foreach ($locales as $locale) {
    $allExist = true;
    foreach ($requiredFiles as $file) {
        $path = base_path("lang/{$locale}/{$file}");
        if (!file_exists($path)) {
            $missingFiles[] = "lang/{$locale}/{$file}";
            $allExist = false;
        }
    }
    
    $status = $allExist ? '✅' : '❌';
    echo "   {$status} {$locale}: ";
    foreach ($requiredFiles as $file) {
        $path = base_path("lang/{$locale}/{$file}");
        echo file_exists($path) ? "✓ {$file} " : "✗ {$file} ";
    }
    echo "\n";
}

if (empty($missingFiles)) {
    $success[] = "Tous les fichiers de traduction présents";
} else {
    $errors[] = "Fichiers manquants: " . implode(', ', $missingFiles);
}

echo "\n";

// ============================================================================
// TEST 3: Middleware SetLocale
// ============================================================================
echo "⚙️  TEST 3: Middleware SetLocale\n";
echo str_repeat("─", 70) . "\n";

// Vérifier si le fichier middleware existe
$middlewarePath = app_path('Http/Middleware/SetLocale.php');
$middlewareExists = file_exists($middlewarePath);

echo "   Fichier middleware: " . ($middlewareExists ? '✅ Existe' : '❌ Manquant') . "\n";

// Vérifier l'enregistrement dans bootstrap/app.php
$bootstrapPath = base_path('bootstrap/app.php');
$bootstrapContent = file_get_contents($bootstrapPath);
$middlewareRegistered = strpos($bootstrapContent, 'SetLocale::class') !== false;

echo "   Enregistré dans bootstrap/app.php: " . ($middlewareRegistered ? '✅ Oui' : '❌ Non') . "\n";

if ($middlewareExists && $middlewareRegistered) {
    $success[] = "Middleware SetLocale correctement configuré";
} else {
    $errors[] = "Middleware SetLocale non configuré correctement";
}

echo "\n";

// ============================================================================
// TEST 4: Table Sessions
// ============================================================================
echo "💾 TEST 4: Table Sessions (Base de Données)\n";
echo str_repeat("─", 70) . "\n";

try {
    $sessionDriver = config('session.driver');
    echo "   Driver de session: {$sessionDriver}\n";
    
    if ($sessionDriver === 'database') {
        $sessionsCount = DB::table('sessions')->count();
        echo "   Table sessions: ✅ Existe ({$sessionsCount} entrées)\n";
        $success[] = "Table sessions opérationnelle";
    } else {
        echo "   Driver: {$sessionDriver} (pas de table nécessaire)\n";
        $warnings[] = "Driver de session n'est pas 'database'";
    }
} catch (\Exception $e) {
    echo "   Table sessions: ❌ Erreur - " . $e->getMessage() . "\n";
    $errors[] = "Problème avec la table sessions";
}

echo "\n";

// ============================================================================
// TEST 5: Routes de Changement de Langue
// ============================================================================
echo "🛣️  TEST 5: Routes de Changement de Langue\n";
echo str_repeat("─", 70) . "\n";

try {
    $routes = app('router')->getRoutes();
    $languageRouteExists = false;
    
    foreach ($routes as $route) {
        if ($route->getName() === 'language.switch') {
            $languageRouteExists = true;
            echo "   Route 'language.switch': ✅ Existe\n";
            echo "   URI: " . $route->uri() . "\n";
            echo "   Méthodes: " . implode(', ', $route->methods()) . "\n";
            break;
        }
    }
    
    if (!$languageRouteExists) {
        echo "   Route 'language.switch': ❌ Manquante\n";
        $errors[] = "Route de changement de langue manquante";
    } else {
        $success[] = "Route de changement de langue configurée";
    }
} catch (\Exception $e) {
    echo "   Erreur lors de la vérification des routes: " . $e->getMessage() . "\n";
    $errors[] = "Impossible de vérifier les routes";
}

echo "\n";

// ============================================================================
// TEST 6: Traductions Fonctionnelles
// ============================================================================
echo "🌍 TEST 6: Traductions Fonctionnelles\n";
echo str_repeat("─", 70) . "\n";

$testKey = 'home.hero_title_1';
$translationWorks = true;

foreach ($locales as $locale) {
    app()->setLocale($locale);
    $translation = __($testKey);
    
    // Vérifier si la traduction n'est pas la clé elle-même
    $works = $translation !== $testKey;
    $status = $works ? '✅' : '❌';
    
    echo "   {$status} {$locale}: {$translation}\n";
    
    if (!$works) {
        $translationWorks = false;
    }
}

if ($translationWorks) {
    $success[] = "Toutes les traductions fonctionnent";
} else {
    $errors[] = "Certaines traductions ne fonctionnent pas";
}

echo "\n";

// ============================================================================
// TEST 7: Simulation de Changement de Langue
// ============================================================================
echo "🔄 TEST 7: Simulation de Changement de Langue\n";
echo str_repeat("─", 70) . "\n";

// Test avec session
try {
    // Démarrer une session
    if (!session()->isStarted()) {
        session()->start();
    }
    
    // Tester le changement vers DE
    session()->put('locale', 'de');
    app()->setLocale('de');
    
    $sessionLocale = session()->get('locale');
    $appLocale = app()->getLocale();
    $translation = __('home.hero_title_1');
    
    echo "   Session locale: {$sessionLocale}\n";
    echo "   App locale: {$appLocale}\n";
    echo "   Traduction: {$translation}\n";
    
    if ($sessionLocale === 'de' && $appLocale === 'de' && $translation !== 'home.hero_title_1') {
        echo "   Résultat: ✅ Changement de langue fonctionne\n";
        $success[] = "Changement de langue opérationnel";
    } else {
        echo "   Résultat: ❌ Problème détecté\n";
        $errors[] = "Changement de langue ne fonctionne pas correctement";
    }
} catch (\Exception $e) {
    echo "   Erreur: " . $e->getMessage() . "\n";
    $errors[] = "Erreur lors du test de changement de langue";
}

echo "\n";

// ============================================================================
// TEST 8: Vérification du Sélecteur de Langue
// ============================================================================
echo "🎨 TEST 8: Sélecteur de Langue dans home.blade.php\n";
echo str_repeat("─", 70) . "\n";

$homePath = resource_path('views/home.blade.php');
if (file_exists($homePath)) {
    $homeContent = file_get_contents($homePath);
    
    // Vérifier la présence du sélecteur
    $hasSelector = strpos($homeContent, '<x-language-selector') !== false || 
                   strpos($homeContent, '@include(\'components.language-selector\')') !== false;
    
    // Vérifier l'attribut lang dynamique
    $hasDynamicLang = strpos($homeContent, 'lang="{{ app()->getLocale() }}"') !== false ||
                      strpos($homeContent, 'lang="{{app()->getLocale()}}"') !== false;
    
    echo "   Sélecteur de langue: " . ($hasSelector ? '✅ Présent' : '❌ Manquant') . "\n";
    echo "   Attribut lang dynamique: " . ($hasDynamicLang ? '✅ Présent' : '❌ Manquant') . "\n";
    
    if ($hasSelector && $hasDynamicLang) {
        $success[] = "home.blade.php correctement configuré";
    } else {
        if (!$hasSelector) $errors[] = "Sélecteur de langue manquant dans home.blade.php";
        if (!$hasDynamicLang) $errors[] = "Attribut lang non dynamique dans home.blade.php";
    }
} else {
    echo "   ❌ Fichier home.blade.php introuvable\n";
    $errors[] = "Fichier home.blade.php manquant";
}

echo "\n";

// ============================================================================
// RÉSUMÉ FINAL
// ============================================================================
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                        RÉSUMÉ FINAL                            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "✅ SUCCÈS (" . count($success) . "):\n";
foreach ($success as $item) {
    echo "   • {$item}\n";
}
echo "\n";

if (!empty($warnings)) {
    echo "⚠️  AVERTISSEMENTS (" . count($warnings) . "):\n";
    foreach ($warnings as $item) {
        echo "   • {$item}\n";
    }
    echo "\n";
}

if (!empty($errors)) {
    echo "❌ ERREURS (" . count($errors) . "):\n";
    foreach ($errors as $item) {
        echo "   • {$item}\n";
    }
    echo "\n";
}

// ============================================================================
// DIAGNOSTIC ET RECOMMANDATIONS
// ============================================================================
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                  DIAGNOSTIC ET RECOMMANDATIONS                 ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

if (empty($errors)) {
    echo "🎉 EXCELLENT! Le système de traduction est correctement configuré.\n\n";
    echo "📝 ÉTAPES SUIVANTES POUR TESTER SUR LE NAVIGATEUR:\n\n";
    echo "1. Redémarrez votre serveur web:\n";
    echo "   - Si XAMPP: Arrêter et redémarrer Apache\n";
    echo "   - Si 'php artisan serve': Ctrl+C puis relancer\n\n";
    echo "2. Videz le cache Laravel:\n";
    echo "   php artisan optimize:clear\n\n";
    echo "3. Ouvrez votre navigateur en MODE PRIVÉ:\n";
    echo "   - Chrome: Ctrl+Shift+N\n";
    echo "   - Firefox: Ctrl+Shift+P\n\n";
    echo "4. Testez le changement de langue sur votre site\n\n";
} else {
    echo "⚠️  DES PROBLÈMES ONT ÉTÉ DÉTECTÉS!\n\n";
    echo "🔧 ACTIONS CORRECTIVES NÉCESSAIRES:\n\n";
    
    foreach ($errors as $i => $error) {
        echo ($i + 1) . ". {$error}\n";
    }
    
    echo "\n📖 Consultez GUIDE_DEPANNAGE_TRADUCTION.md pour plus de détails.\n\n";
}

echo "═══════════════════════════════════════════════════════════════════\n";
echo "Test terminé à " . date('Y-m-d H:i:s') . "\n";
echo "═══════════════════════════════════════════════════════════════════\n\n";
