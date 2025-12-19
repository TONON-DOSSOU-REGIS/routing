<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST DÉTAILLÉ DU SYSTÈME DE TRADUCTION ===\n\n";

// Test 1: Vérifier la locale actuelle
echo "1. Locale actuelle: " . app()->getLocale() . "\n";
echo "   Locale de fallback: " . config('app.fallback_locale') . "\n\n";

// Test 2: Vérifier si les fichiers de traduction sont chargés
echo "2. Test de chargement des fichiers de traduction:\n";
$translator = app('translator');
echo "   Translator class: " . get_class($translator) . "\n\n";

// Test 3: Tester différentes méthodes de traduction
echo "3. Test des différentes méthodes:\n";

// Méthode 1: __()
echo "   __('common.welcome'): " . __('common.welcome') . "\n";
echo "   __('home.hero.title'): " . __('home.hero.title') . "\n";

// Méthode 2: trans()
echo "   trans('common.welcome'): " . trans('common.welcome') . "\n";

// Méthode 3: Lang::get()
echo "   Lang::get('common.welcome'): " . \Illuminate\Support\Facades\Lang::get('common.welcome') . "\n\n";

// Test 4: Vérifier le contenu réel des fichiers
echo "4. Contenu du fichier lang/fr/common.php:\n";
$commonFr = include('lang/fr/common.php');
echo "   Type: " . gettype($commonFr) . "\n";
if (is_array($commonFr)) {
    echo "   Nombre de clés: " . count($commonFr) . "\n";
    echo "   Clé 'welcome' existe: " . (isset($commonFr['welcome']) ? 'Oui' : 'Non') . "\n";
    if (isset($commonFr['welcome'])) {
        echo "   Valeur de 'welcome': " . $commonFr['welcome'] . "\n";
    }
}
echo "\n";

// Test 5: Tester avec changement de locale
echo "5. Test avec changement de locale:\n";
foreach (['fr', 'en', 'de'] as $locale) {
    app()->setLocale($locale);
    echo "   Locale $locale: " . __('common.welcome') . "\n";
}
echo "\n";

// Test 6: Vérifier les chemins de traduction
echo "6. Chemins de traduction:\n";
echo "   Lang path: " . app()->langPath() . "\n";
echo "   Existe: " . (file_exists(app()->langPath()) ? 'Oui' : 'Non') . "\n\n";

// Test 7: Lister les fichiers de traduction disponibles
echo "7. Fichiers de traduction disponibles:\n";
$langPath = app()->langPath();
if (is_dir($langPath)) {
    $locales = array_filter(scandir($langPath), function($item) use ($langPath) {
        return is_dir($langPath . '/' . $item) && !in_array($item, ['.', '..']);
    });
    foreach ($locales as $locale) {
        echo "   - $locale: ";
        $files = glob($langPath . '/' . $locale . '/*.php');
        echo count($files) . " fichiers\n";
    }
}

echo "\n=== FIN DU TEST ===\n";
