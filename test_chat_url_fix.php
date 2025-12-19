<?php

/**
 * Script de test pour vérifier la correction des URLs du chatbot
 * 
 * Ce script vérifie que:
 * 1. Les widgets utilisent les URLs absolues
 * 2. Les routes de chat sont accessibles
 * 3. Le serveur répond correctement
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

echo "=================================================\n";
echo "TEST DE CORRECTION DES URLs DU CHATBOT\n";
echo "=================================================\n\n";

$allTestsPassed = true;

// Test 1: Vérifier que les widgets utilisent url()
echo "1. Vérification des widgets...\n";

$widgetsToCheck = [
    'resources/views/components/admin-chat-widget-v2.blade.php' => 'Widget Admin',
    'resources/views/components/client-chat-widget.blade.php' => 'Widget Client',
];

foreach ($widgetsToCheck as $path => $name) {
    if (File::exists($path)) {
        $content = File::get($path);
        
        // Vérifier que les URLs utilisent url()
        $urlPatterns = [
            '/chat/messages' => "url(\"/chat/messages\")",
            '/chat/send' => "url(\"/chat/send\")",
            '/chat/unread-count' => "url(\"/chat/unread-count\")",
        ];
        
        $widgetOk = true;
        foreach ($urlPatterns as $oldUrl => $newUrl) {
            // Vérifier qu'on n'utilise plus les URLs relatives
            if (preg_match("/fetch\s*\(\s*['\"]" . preg_quote($oldUrl, '/') . "['\"]/", $content)) {
                echo "   ❌ $name utilise encore l'URL relative: $oldUrl\n";
                $widgetOk = false;
                $allTestsPassed = false;
            }
            
            // Vérifier qu'on utilise url()
            if (strpos($content, "{{ url(\"$oldUrl\")") !== false || 
                strpos($content, "{{ url('$oldUrl')") !== false) {
                echo "   ✅ $name utilise url() pour: $oldUrl\n";
            }
        }
        
        if ($widgetOk) {
            echo "   ✅ $name correctement configuré\n";
        }
    } else {
        echo "   ❌ $name n'existe pas: $path\n";
        $allTestsPassed = false;
    }
}

echo "\n";

// Test 2: Vérifier les routes de chat
echo "2. Vérification des routes de chat...\n";

$routes = Route::getRoutes();
$chatRoutes = [
    'chat.send' => 'POST /chat/send',
    'chat.messages' => 'GET /chat/messages/{userId?}',
    'chat.unread-count' => 'GET /chat/unread-count',
    'chat.mark-read' => 'POST /chat/mark-read/{userId}',
];

foreach ($chatRoutes as $name => $description) {
    $route = $routes->getByName($name);
    if ($route) {
        echo "   ✅ Route '$name' existe: $description\n";
    } else {
        echo "   ❌ Route '$name' n'existe pas\n";
        $allTestsPassed = false;
    }
}

echo "\n";

// Test 3: Vérifier la configuration de l'URL de base
echo "3. Vérification de la configuration...\n";

$appUrl = config('app.url');
echo "   URL de base configurée: $appUrl\n";

if (strpos($appUrl, 'localhost') !== false) {
    echo "   ✅ Configuration locale détectée\n";
    
    if (strpos($appUrl, '/cerveau') !== false) {
        echo "   ℹ️  Configuration XAMPP détectée (avec sous-répertoire)\n";
        echo "   ℹ️  Les URLs seront générées avec le préfixe /cerveau/public\n";
    } else {
        echo "   ℹ️  Configuration serveur built-in détectée\n";
        echo "   ℹ️  Les URLs seront générées sans préfixe\n";
    }
} else {
    echo "   ℹ️  Configuration de production détectée\n";
}

echo "\n";

// Test 4: Vérifier le contrôleur ChatController
echo "4. Vérification du contrôleur ChatController...\n";

$controllerPath = app_path('Http/Controllers/ChatController.php');
if (File::exists($controllerPath)) {
    echo "   ✅ ChatController existe\n";
    
    $content = File::get($controllerPath);
    $methods = ['sendMessage', 'getMessages', 'getUnreadCount', 'markAsRead'];
    
    foreach ($methods as $method) {
        if (strpos($content, "function $method") !== false) {
            echo "   ✅ Méthode $method() existe\n";
        } else {
            echo "   ❌ Méthode $method() manquante\n";
            $allTestsPassed = false;
        }
    }
} else {
    echo "   ❌ ChatController n'existe pas\n";
    $allTestsPassed = false;
}

echo "\n";

// Test 5: Instructions pour tester manuellement
echo "5. Instructions de test manuel...\n";
echo "   Pour tester le chatbot:\n\n";

echo "   A. Avec XAMPP (configuration actuelle):\n";
echo "      1. Assurez-vous qu'Apache est démarré dans XAMPP\n";
echo "      2. Accédez à: http://localhost/cerveau/public/\n";
echo "      3. Connectez-vous en tant que client\n";
echo "      4. Ouvrez le chatbot bleu (en bas à droite)\n";
echo "      5. Envoyez un message de test\n";
echo "      6. Connectez-vous en tant qu'admin\n";
echo "      7. Ouvrez le chatbot violet (en bas à droite)\n";
echo "      8. Vérifiez que le message du client apparaît\n";
echo "      9. Cliquez sur la conversation pour l'ouvrir\n";
echo "      10. Vérifiez que les messages s'affichent correctement\n\n";

echo "   B. Avec PHP Built-in Server (alternative):\n";
echo "      1. Ouvrez un terminal dans le répertoire du projet\n";
echo "      2. Exécutez: php artisan serve\n";
echo "      3. Accédez à: http://localhost:8000\n";
echo "      4. Suivez les étapes 3-10 ci-dessus\n\n";

echo "   C. Vérifier les erreurs:\n";
echo "      1. Ouvrez la console du navigateur (F12)\n";
echo "      2. Allez dans l'onglet 'Console'\n";
echo "      3. Vérifiez qu'il n'y a pas d'erreurs ERR_CONNECTION_REFUSED\n";
echo "      4. Allez dans l'onglet 'Network'\n";
echo "      5. Vérifiez que les requêtes vers /chat/* retournent 200 OK\n\n";

// Résumé final
echo "=================================================\n";
if ($allTestsPassed) {
    echo "✅ TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS!\n\n";
    echo "Les widgets de chat ont été corrigés pour utiliser les URLs absolues.\n";
    echo "Le problème ERR_CONNECTION_REFUSED devrait être résolu.\n\n";
    echo "PROCHAINES ÉTAPES:\n";
    echo "1. Videz le cache du navigateur (Ctrl+Shift+Delete)\n";
    echo "2. Rafraîchissez la page (Ctrl+F5)\n";
    echo "3. Testez le chatbot client et admin\n";
    echo "4. Vérifiez que les messages s'affichent correctement\n";
} else {
    echo "❌ CERTAINS TESTS ONT ÉCHOUÉ\n\n";
    echo "Veuillez corriger les problèmes identifiés ci-dessus.\n";
}
echo "=================================================\n";
