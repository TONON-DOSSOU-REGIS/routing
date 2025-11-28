<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

echo "=== TEST ENDPOINT CHAT ===\n\n";

// 1. Trouver l'admin
$admin = User::where('role', 'admin')->first();
if (!$admin) {
    echo "❌ AUCUN ADMIN TROUVÉ!\n";
    exit;
}

echo "✅ Admin trouvé: {$admin->first_name} {$admin->last_name} (ID: {$admin->id})\n\n";

// 2. Simuler l'authentification admin
Auth::login($admin);
echo "✅ Authentifié en tant qu'admin\n\n";

// 3. Créer une instance du contrôleur
$controller = new ChatController();

// 4. Créer une requête simulée
$request = Request::create('/chat/messages', 'GET');
$request->headers->set('X-Requested-With', 'XMLHttpRequest');
$request->headers->set('Accept', 'application/json');

echo "📡 Appel de getMessages() sans userId...\n\n";

try {
    // 5. Appeler la méthode
    $response = $controller->getMessages($request, null);
    
    // 6. Afficher la réponse
    $content = $response->getContent();
    $data = json_decode($content, true);
    
    echo "HTTP Status: " . $response->getStatusCode() . "\n";
    echo "Response:\n";
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    
    if (isset($data['success']) && $data['success']) {
        echo "✅ SUCCESS!\n";
        if (isset($data['conversations'])) {
            echo "Nombre de conversations: " . count($data['conversations']) . "\n\n";
            foreach ($data['conversations'] as $conv) {
                echo "Conversation avec: {$conv['user']['first_name']} {$conv['user']['last_name']}\n";
                echo "  Email: {$conv['user']['email']}\n";
                echo "  Messages non lus: {$conv['unread_count']}\n";
                if ($conv['last_message']) {
                    echo "  Dernier message: " . substr($conv['last_message']['message'], 0, 50) . "\n";
                }
                echo "\n";
            }
        }
    } else {
        echo "❌ ÉCHEC!\n";
        if (isset($data['message'])) {
            echo "Message: {$data['message']}\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== FIN DU TEST ===\n";

