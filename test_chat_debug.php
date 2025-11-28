<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ChatMessage;

echo "=== TEST CHAT DEBUG ===\n\n";

// 1. Vérifier les utilisateurs
echo "1. UTILISATEURS:\n";
$users = User::all();
foreach ($users as $user) {
    echo "  - ID: {$user->id}, Nom: {$user->first_name} {$user->last_name}, Email: {$user->email}, Role: {$user->role}\n";
}
echo "\n";

// 2. Vérifier les messages
echo "2. MESSAGES CHAT:\n";
$messages = ChatMessage::with(['sender', 'receiver'])->get();
if ($messages->count() === 0) {
    echo "  ⚠️ AUCUN MESSAGE TROUVÉ!\n";
} else {
    foreach ($messages as $msg) {
        $senderName = $msg->sender ? "{$msg->sender->first_name} {$msg->sender->last_name}" : "N/A";
        $receiverName = $msg->receiver ? "{$msg->receiver->first_name} {$msg->receiver->last_name}" : "N/A";
        echo "  - ID: {$msg->id}\n";
        echo "    De: {$senderName} (ID: {$msg->sender_id})\n";
        echo "    À: {$receiverName} (ID: {$msg->receiver_id})\n";
        echo "    Message: " . substr($msg->message, 0, 50) . "...\n";
        echo "    Lu: " . ($msg->is_read ? 'Oui' : 'Non') . "\n";
        echo "    Date: {$msg->created_at}\n\n";
    }
}

// 3. Trouver l'admin
echo "3. ADMIN:\n";
$admin = User::where('role', 'admin')->first();
if ($admin) {
    echo "  ✅ Admin trouvé: {$admin->first_name} {$admin->last_name} (ID: {$admin->id})\n";
    
    // 4. Messages pour l'admin
    echo "\n4. MESSAGES POUR L'ADMIN:\n";
    $adminMessages = ChatMessage::where('receiver_id', $admin->id)
        ->orWhere('sender_id', $admin->id)
        ->with(['sender', 'receiver'])
        ->get();
    
    if ($adminMessages->count() === 0) {
        echo "  ⚠️ AUCUN MESSAGE POUR L'ADMIN!\n";
    } else {
        echo "  ✅ {$adminMessages->count()} message(s) trouvé(s)\n";
        foreach ($adminMessages as $msg) {
            $senderName = $msg->sender ? "{$msg->sender->first_name} {$msg->sender->last_name}" : "N/A";
            $receiverName = $msg->receiver ? "{$msg->receiver->first_name} {$msg->receiver->last_name}" : "N/A";
            echo "    - De: {$senderName} → À: {$receiverName}\n";
            echo "      Message: " . substr($msg->message, 0, 50) . "\n";
        }
    }
    
    // 5. Test de la méthode getAdminConversations
    echo "\n5. TEST MÉTHODE getAdminConversations:\n";
    $userIds = ChatMessage::where('sender_id', $admin->id)
        ->orWhere('receiver_id', $admin->id)
        ->get()
        ->map(function($message) use ($admin) {
            return $message->sender_id == $admin->id ? $message->receiver_id : $message->sender_id;
        })
        ->unique()
        ->filter()
        ->values();
    
    echo "  User IDs trouvés: " . $userIds->implode(', ') . "\n";
    
    foreach ($userIds as $userId) {
        $user = User::find($userId);
        if ($user && !$user->isAdmin()) {
            echo "  - Conversation avec: {$user->first_name} {$user->last_name} (ID: {$userId})\n";
            
            // Dernier message
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
            
            if ($lastMessage) {
                echo "    Dernier message: " . substr($lastMessage->message, 0, 30) . "...\n";
            } else {
                echo "    ⚠️ Aucun dernier message trouvé!\n";
            }
        }
    }
} else {
    echo "  ❌ AUCUN ADMIN TROUVÉ!\n";
}

echo "\n=== FIN DU TEST ===\n";

