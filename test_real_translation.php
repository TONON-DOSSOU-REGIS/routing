<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simuler une requête HTTP
$request = Illuminate\Http\Request::create('/', 'GET');
$response = $kernel->handle($request);

echo "=== TEST DE TRADUCTION EN CONDITIONS RÉELLES ===\n\n";

// Test 1: Vérifier la locale par défaut
echo "1. Locale actuelle: " . app()->getLocale() . "\n\n";

// Test 2: Simuler un changement de langue vers DE
echo "2. Simulation changement vers DE:\n";
Session::start();
Session::put('locale', 'de');
app()->setLocale('de');
echo "   - Session locale: " . Session::get('locale') . "\n";
echo "   - App locale: " . app()->getLocale() . "\n";
echo "   - Traduction 'home.hero_title_1': " . __('home.hero_title_1') . "\n\n";

// Test 3: Simuler une nouvelle requête avec la session
echo "3. Simulation nouvelle requête (avec session DE):\n";
$request2 = Illuminate\Http\Request::create('/', 'GET');
$request2->setLaravelSession(Session::driver());

// Exécuter le middleware SetLocale manuellement
$middleware = new \App\Http\Middleware\SetLocale();
$middleware->handle($request2, function($req) {
    echo "   - Locale après middleware: " . app()->getLocale() . "\n";
    echo "   - Traduction 'home.hero_title_1': " . __('home.hero_title_1') . "\n";
});

echo "\n4. Test du contrôleur LanguageController:\n";
$controller = new \App\Http\Controllers\LanguageController();

// Simuler le changement vers NL
Session::put('locale', 'nl');
app()->setLocale('nl');
echo "   - Changement vers NL\n";
echo "   - Session locale: " . Session::get('locale') . "\n";
echo "   - App locale: " . app()->getLocale() . "\n";
echo "   - Traduction 'home.hero_title_1': " . __('home.hero_title_1') . "\n\n";

echo "5. Vérification des sessions en base:\n";
try {
    $sessions = DB::table('sessions')->get();
    echo "   - Nombre de sessions: " . $sessions->count() . "\n";
    foreach ($sessions as $session) {
        $payload = unserialize(base64_decode($session->payload));
        $locale = $payload['locale'] ?? 'non défini';
        echo "   - Session ID: " . substr($session->id, 0, 10) . "... | Locale: {$locale}\n";
    }
} catch (\Exception $e) {
    echo "   - Erreur: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DU TEST ===\n";
