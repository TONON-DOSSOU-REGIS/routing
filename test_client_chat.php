<?php

/**
 * Script de test pour le widget de chat client
 * 
 * Ce script vérifie:
 * 1. L'existence du widget client
 * 2. L'intégration dans le dashboard
 * 3. Les routes de chat
 * 4. La structure de la base de données
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

echo "=================================================\n";
echo "TEST DU WIDGET DE CHAT CLIENT\n";
echo "=================================================\n\n";

$allTestsPassed = true;

// Test 1: Vérifier l'existence du widget client
echo "1. Vérification de l'existence du widget client...\n";
$widgetPath = resource_path('views/components/client-chat-widget.blade.php');
if (File::exists($widgetPath)) {
    echo "   ✅ Widget client existe: $widgetPath\n";
    
    // Vérifier le contenu du widget
    $content = File::get($widgetPath);
    $checks = [
        'client-chat-widget' => 'ID du widget',
        'toggleClientChat' => 'Fonction toggle',
        'sendClientMessage' => 'Fonction envoi message',
        'client-chat-input' => 'Input de message',
        'client-chat-file' => 'Input de fichier',
    ];
    
    foreach ($checks as $needle => $description) {
        if (strpos($content, $needle) !== false) {
            echo "   ✅ $description trouvé\n";
        } else {
            echo "   ❌ $description manquant\n";
            $allTestsPassed = false;
        }
    }
} else {
    echo "   ❌ Widget client n'existe pas\n";
    $allTestsPassed = false;
}

echo "\n";

// Test 2: Vérifier l'intégration dans le dashboard
echo "2. Vérification de l'intégration dans le dashboard...\n";
$dashboardPath = resource_path('views/dashboard/index.blade.php');
if (File::exists($dashboardPath)) {
    echo "   ✅ Dashboard existe: $dashboardPath\n";
    
    $content = File::get($dashboardPath);
    if (strpos($content, "client-chat-widget") !== false || 
        strpos($content, "@include('components.client-chat-widget')") !== false) {
        echo "   ✅ Widget client intégré dans le dashboard\n";
    } else {
        echo "   ❌ Widget client non intégré dans le dashboard\n";
        $allTestsPassed = false;
    }
} else {
    echo "   ❌ Dashboard n'existe pas\n";
    $allTestsPassed = false;
}

echo "\n";

// Test 3: Vérifier les routes de chat
echo "3. Vérification des routes de chat...\n";
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
        echo "   ❌ Route '$name' manquante\n";
        $allTestsPassed = false;
    }
}

echo "\n";

// Test 4: Vérifier la table chat_messages
echo "4. Vérification de la structure de la base de données...\n";
if (Schema::hasTable('chat_messages')) {
    echo "   ✅ Table 'chat_messages' existe\n";
    
    $columns = Schema::getColumnListing('chat_messages');
    $requiredColumns = [
        'id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'attachment_path',
        'attachment_name',
        'created_at',
        'updated_at',
    ];
    
    foreach ($requiredColumns as $column) {
        if (in_array($column, $columns)) {
            echo "   ✅ Colonne '$column' existe\n";
        } else {
            echo "   ❌ Colonne '$column' manquante\n";
            $allTestsPassed = false;
        }
    }
} else {
    echo "   ❌ Table 'chat_messages' n'existe pas\n";
    $allTestsPassed = false;
}

echo "\n";

// Test 5: Vérifier le ChatController
echo "5. Vérification du ChatController...\n";
$controllerPath = app_path('Http/Controllers/ChatController.php');
if (File::exists($controllerPath)) {
    echo "   ✅ ChatController existe: $controllerPath\n";
    
    $content = File::get($controllerPath);
    $methods = [
        'sendMessage' => 'Méthode sendMessage',
        'getMessages' => 'Méthode getMessages',
        'getUnreadCount' => 'Méthode getUnreadCount',
        'markAsRead' => 'Méthode markAsRead',
    ];
    
    foreach ($methods as $method => $description) {
        if (strpos($content, "function $method") !== false) {
            echo "   ✅ $description existe\n";
        } else {
            echo "   ❌ $description manquante\n";
            $allTestsPassed = false;
        }
    }
} else {
    echo "   ❌ ChatController n'existe pas\n";
    $allTestsPassed = false;
}

echo "\n";

// Test 6: Vérifier le modèle ChatMessage
echo "6. Vérification du modèle ChatMessage...\n";
$modelPath = app_path('Models/ChatMessage.php');
if (File::exists($modelPath)) {
    echo "   ✅ Modèle ChatMessage existe: $modelPath\n";
    
    $content = File::get($modelPath);
    if (strpos($content, 'class ChatMessage') !== false) {
        echo "   ✅ Classe ChatMessage définie\n";
    } else {
        echo "   ❌ Classe ChatMessage non définie\n";
        $allTestsPassed = false;
    }
} else {
    echo "   ❌ Modèle ChatMessage n'existe pas\n";
    $allTestsPassed = false;
}

echo "\n";

// Test 7: Vérifier le dossier de stockage des pièces jointes
echo "7. Vérification du dossier de stockage...\n";
$storagePath = storage_path('app/public/chat_attachments');
if (File::isDirectory($storagePath)) {
    echo "   ✅ Dossier de stockage existe: $storagePath\n";
    
    if (File::isWritable($storagePath)) {
        echo "   ✅ Dossier de stockage est accessible en écriture\n";
    } else {
        echo "   ⚠️  Dossier de stockage n'est pas accessible en écriture\n";
        echo "      Exécutez: chmod -R 775 $storagePath\n";
    }
} else {
    echo "   ⚠️  Dossier de stockage n'existe pas (sera créé automatiquement)\n";
    echo "      Vous pouvez le créer manuellement: mkdir -p $storagePath\n";
}

// Vérifier le lien symbolique
$publicLink = public_path('storage');
if (File::exists($publicLink)) {
    echo "   ✅ Lien symbolique 'public/storage' existe\n";
} else {
    echo "   ⚠️  Lien symbolique 'public/storage' n'existe pas\n";
    echo "      Exécutez: php artisan storage:link\n";
}

echo "\n";

// Résumé final
echo "=================================================\n";
if ($allTestsPassed) {
    echo "✅ TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS!\n";
    echo "=================================================\n\n";
    
    echo "Le widget de chat client est correctement installé.\n\n";
    
    echo "PROCHAINES ÉTAPES:\n";
    echo "1. Connectez-vous en tant que client\n";
    echo "2. Accédez au dashboard (/dashboard)\n";
    echo "3. Cliquez sur le bouton de chat bleu en bas à droite\n";
    echo "4. Envoyez un message de test\n";
    echo "5. Connectez-vous en tant qu'admin pour voir le message\n";
    echo "6. Répondez depuis l'espace admin\n";
    echo "7. Vérifiez que la réponse apparaît côté client\n\n";
    
    echo "COMMANDES UTILES:\n";
    echo "- Voir les routes: php artisan route:list | grep chat\n";
    echo "- Créer le lien symbolique: php artisan storage:link\n";
    echo "- Voir les logs: tail -f storage/logs/laravel.log\n";
} else {
    echo "❌ CERTAINS TESTS ONT ÉCHOUÉ\n";
    echo "=================================================\n\n";
    
    echo "Veuillez corriger les erreurs ci-dessus avant de continuer.\n";
    echo "Consultez le fichier CLIENT_CHAT_IMPLEMENTATION.md pour plus de détails.\n";
}

echo "\n";
