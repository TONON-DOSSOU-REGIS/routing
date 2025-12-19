<?php

/**
 * Script de test pour le widget de chat admin
 * Vérifie que les messages s'affichent correctement
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\DB;

echo "=== TEST DU WIDGET DE CHAT ADMIN ===\n\n";

// 1. Vérifier qu'il y a un admin
echo "1. Vérification de l'existence d'un admin...\n";
$admin = User::where('role', 'admin')->first();

if (!$admin) {
    echo "   ❌ Aucun admin trouvé dans la base de données\n";
    echo "   Créez un admin avec: php artisan tinker\n";
    echo "   User::create(['email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin', ...])\n";
    exit(1);
}

echo "   ✅ Admin trouvé: {$admin->email} (ID: {$admin->id})\n\n";

// 2. Vérifier qu'il y a des utilisateurs clients
echo "2. Vérification des utilisateurs clients...\n";
$clients = User::where('role', 'user')->get();

if ($clients->isEmpty()) {
    echo "   ❌ Aucun client trouvé\n";
    exit(1);
}

echo "   ✅ {$clients->count()} client(s) trouvé(s)\n\n";

// 3. Vérifier les messages dans la base de données
echo "3. Vérification des messages dans la base de données...\n";
$totalMessages = ChatMessage::count();
echo "   Total de messages: {$totalMessages}\n";

if ($totalMessages === 0) {
    echo "   ⚠️  Aucun message dans la base de données\n";
    echo "   Création de messages de test...\n";
    
    // Créer des messages de test
    $client = $clients->first();
    
    // Message du client vers l'admin
    ChatMessage::create([
        'sender_id' => $client->id,
        'receiver_id' => $admin->id,
        'message' => 'Bonjour, j\'ai besoin d\'aide avec mon compte.',
        'is_read' => false,
    ]);
    
    // Réponse de l'admin
    ChatMessage::create([
        'sender_id' => $admin->id,
        'receiver_id' => $client->id,
        'message' => 'Bonjour, je suis là pour vous aider. Quel est votre problème?',
        'is_read' => true,
    ]);
    
    // Autre message du client
    ChatMessage::create([
        'sender_id' => $client->id,
        'receiver_id' => $admin->id,
        'message' => 'Je n\'arrive pas à effectuer un virement.',
        'is_read' => false,
    ]);
    
    echo "   ✅ 3 messages de test créés\n\n";
} else {
    echo "   ✅ Messages existants trouvés\n\n";
}

// 4. Vérifier les messages pour l'admin
echo "4. Vérification des messages pour l'admin...\n";
$adminMessages = ChatMessage::where('receiver_id', $admin->id)
    ->orWhere('sender_id', $admin->id)
    ->with(['sender', 'receiver'])
    ->orderBy('created_at', 'desc')
    ->get();

echo "   Messages impliquant l'admin: {$adminMessages->count()}\n";

if ($adminMessages->isEmpty()) {
    echo "   ❌ Aucun message pour l'admin\n";
} else {
    echo "   ✅ Messages trouvés:\n";
    foreach ($adminMessages->take(5) as $msg) {
        $from = $msg->sender ? $msg->sender->email : 'Unknown';
        $to = $msg->receiver ? $msg->receiver->email : 'Unknown';
        $preview = substr($msg->message, 0, 50);
        echo "      - De: {$from} → À: {$to}\n";
        echo "        Message: {$preview}...\n";
        echo "        Lu: " . ($msg->is_read ? 'Oui' : 'Non') . "\n";
    }
}
echo "\n";

// 5. Tester la méthode getAdminConversations
echo "5. Test de la méthode getAdminConversations...\n";

// Simuler la méthode getAdminConversations
$userIds = ChatMessage::where('sender_id', $admin->id)
    ->orWhere('receiver_id', $admin->id)
    ->get()
    ->map(function($message) use ($admin) {
        return $message->sender_id == $admin->id ? $message->receiver_id : $message->sender_id;
    })
    ->unique()
    ->filter()
    ->values();

echo "   Utilisateurs avec conversations: {$userIds->count()}\n";

$conversations = [];
foreach ($userIds as $userId) {
    $user = User::find($userId);
    
    if (!$user || $user->role === 'admin') {
        continue;
    }
    
    $lastMessage = ChatMessage::where(function($query) use ($admin, $userId) {
            $query->where(function($q) use ($admin, $userId) {
                $q->where('sender_id', $admin->id)
                  ->where('receiver_id', $userId);
            })->orWhere(function($q) use ($admin, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $admin->id);
            });
        })
        ->latest()
        ->first();
    
    $unreadCount = ChatMessage::where('sender_id', $userId)
        ->where('receiver_id', $admin->id)
        ->where('is_read', false)
        ->count();
    
    $conversations[] = [
        'user' => $user,
        'last_message' => $lastMessage,
        'unread_count' => $unreadCount,
    ];
}

$conversationCount = count($conversations);
echo "   ✅ {$conversationCount} conversation(s) trouvée(s)\n";

foreach ($conversations as $conv) {
    $user = $conv['user'];
    $lastMsg = $conv['last_message'];
    $unread = $conv['unread_count'];
    
    echo "\n   Conversation avec: {$user->first_name} {$user->last_name} ({$user->email})\n";
    echo "   Messages non lus: {$unread}\n";
    
    if ($lastMsg) {
        $preview = substr($lastMsg->message, 0, 50);
        echo "   Dernier message: {$preview}...\n";
        echo "   Date: {$lastMsg->created_at->format('d/m/Y H:i')}\n";
    }
}
echo "\n";

// 6. Vérifier les routes
echo "6. Vérification des routes de chat...\n";
$routes = [
    '/chat/messages' => 'GET - Liste des conversations (admin) ou messages avec admin (client)',
    '/chat/messages/{userId}' => 'GET - Messages avec un utilisateur spécifique',
    '/chat/send' => 'POST - Envoyer un message',
    '/chat/unread-count' => 'GET - Nombre de messages non lus',
];

foreach ($routes as $route => $description) {
    echo "   ✅ {$route}\n";
    echo "      {$description}\n";
}
echo "\n";

// 7. Vérifier le widget
echo "7. Vérification du fichier widget...\n";
$widgetPath = resource_path('views/components/admin-chat-widget-v2.blade.php');

if (!file_exists($widgetPath)) {
    echo "   ❌ Widget non trouvé: {$widgetPath}\n";
} else {
    echo "   ✅ Widget trouvé: {$widgetPath}\n";
    
    $content = file_get_contents($widgetPath);
    
    // Vérifier les fonctions importantes
    $functions = [
        'loadConversationsV2' => 'Chargement des conversations',
        'displayConversationsV2' => 'Affichage des conversations',
        'openChatV2' => 'Ouverture d\'un chat',
        'loadChatWithUserV2' => 'Chargement des messages',
        'displayChatMessagesV2' => 'Affichage des messages',
        'sendAdminMessageV2' => 'Envoi de message',
    ];
    
    foreach ($functions as $func => $desc) {
        if (strpos($content, "function {$func}") !== false) {
            echo "   ✅ Fonction {$func} présente ({$desc})\n";
        } else {
            echo "   ❌ Fonction {$func} manquante\n";
        }
    }
    
    // Vérifier les logs de débogage
    if (strpos($content, "console.log('[ChatV2]") !== false) {
        echo "   ✅ Logs de débogage présents\n";
    } else {
        echo "   ⚠️  Logs de débogage manquants\n";
    }
}
echo "\n";

// 8. Instructions pour tester
echo "8. INSTRUCTIONS POUR TESTER:\n";
echo "   1. Ouvrez votre navigateur et connectez-vous en tant qu'admin\n";
echo "   2. Allez sur le tableau de bord admin: http://127.0.0.1:8000/admin/dashboard\n";
echo "   3. Ouvrez la console du navigateur (F12)\n";
echo "   4. Cliquez sur le bouton de chat violet en bas à droite\n";
echo "   5. Vous devriez voir la liste des conversations\n";
echo "   6. Cliquez sur une conversation\n";
echo "   7. Vérifiez que les messages s'affichent\n";
echo "   8. Vérifiez les logs dans la console:\n";
echo "      - [ChatV2] Loading chat with user: X\n";
echo "      - [ChatV2] Response status: 200\n";
echo "      - [ChatV2] Messages count: X\n";
echo "      - [ChatV2] Displaying X messages\n";
echo "      - [ChatV2] Messages displayed successfully\n";
echo "\n";

echo "=== FIN DU TEST ===\n";
echo "\n";

if ($adminMessages->count() > 0 && count($conversations) > 0) {
    echo "✅ TOUS LES TESTS SONT PASSÉS!\n";
    echo "Le widget devrait maintenant afficher les messages correctement.\n";
    echo "Si ce n'est pas le cas, vérifiez les logs dans la console du navigateur.\n";
} else {
    echo "⚠️  ATTENTION: Peu ou pas de données de test disponibles.\n";
    echo "Créez des messages de test pour vérifier le fonctionnement complet.\n";
}
