<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;

// Simuler une requête de déconnexion
$request = new Request();
$request->setMethod('POST');

// Créer une instance du contrôleur
$controller = new LoginController();

// Tester la méthode logout
try {
    $response = $controller->logout($request);
    echo "✅ Logout method executed successfully\n";
    echo "Redirect URL: " . $response->getTargetUrl() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
