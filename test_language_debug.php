<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST DE DÉBOGAGE DU SYSTÈME DE TRADUCTION ===\n\n";

// 1. Vérifier la locale par défaut
echo "1. Locale par défaut (config): " . config('app.locale') . "\n";
echo "2. Locale actuelle (app): " . app()->getLocale() . "\n\n";

// 2. Vérifier si les fichiers de traduction existent
$locales = ['en', 'fr', 'de', 'nl', 'es', 'pl', 'it'];
echo "3. Vérification des fichiers de traduction:\n";
foreach ($locales as $locale) {
    $homeFile = base_path("lang/{$locale}/home.php");
    $commonFile = base_path("lang/{$locale}/common.php");
    echo "   - {$locale}: home.php " . (file_exists($homeFile) ? '✅' : '❌') . 
         ", common.php " . (file_exists($commonFile) ? '✅' : '❌') . "\n";
}
echo "\n";

// 3. Tester la traduction pour chaque langue
echo "4. Test des traductions pour 'home.hero_title_1':\n";
foreach ($locales as $locale) {
    app()->setLocale($locale);
    $translation = __('home.hero_title_1');
    echo "   - {$locale}: {$translation}\n";
}
echo "\n";

// 4. Vérifier la session
echo "5. Configuration de session:\n";
echo "   - Driver: " . config('session.driver') . "\n";
echo "   - Table: " . config('session.table') . "\n";
echo "   - Lifetime: " . config('session.lifetime') . " minutes\n\n";

// 5. Vérifier si la table sessions existe
try {
    $sessionsCount = DB::table('sessions')->count();
    echo "6. Table sessions: ✅ Existe ({$sessionsCount} entrées)\n\n";
} catch (\Exception $e) {
    echo "6. Table sessions: ❌ N'existe pas ou erreur: " . $e->getMessage() . "\n\n";
}

// 6. Vérifier le middleware
echo "7. Middleware SetLocale:\n";
$middlewareGroups = config('app.middleware_groups', []);
$webMiddleware = app(\App\Http\Kernel::class)->getMiddlewareGroups()['web'] ?? [];
$hasSetLocale = false;
foreach ($webMiddleware as $middleware) {
    if (str_contains($middleware, 'SetLocale')) {
        $hasSetLocale = true;
        break;
    }
}
echo "   - Enregistré dans 'web': " . ($hasSetLocale ? '✅' : '❌') . "\n\n";

// 7. Tester manuellement le changement de langue
echo "8. Test manuel du changement de langue:\n";
Session::put('locale', 'de');
app()->setLocale('de');
echo "   - Session locale définie sur: " . Session::get('locale') . "\n";
echo "   - App locale: " . app()->getLocale() . "\n";
echo "   - Traduction 'home.hero_title_1': " . __('home.hero_title_1') . "\n\n";

echo "=== FIN DU TEST ===\n";
