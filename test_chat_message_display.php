<?php

/**
 * Script de test pour vérifier l'affichage des messages du chat
 * 
 * Ce script teste:
 * 1. La récupération des messages via l'API
 * 2. Le format des données retournées
 * 3. La structure des messages
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Log;

echo "=== TEST D'AFFICHAGE DES MESSAGES DU CHAT ===\n\n";

$allTestsPassed = true;

// Test 1: Vérifier qu'il y a des messages dans la base de données
echo "1. Vérification des messages dans la base de données...\n";
$messageCount = ChatMessage::count();
echo "   Messages trouvés: $messageCount\n";

if ($messageCount > 0) {
    echo "   ✅ Des messages existent dans la base de données\n";
    
    // Afficher les derniers messages
    $recentMessages = ChatMessage::with(['sender', 'receiver'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    echo "\n   Derniers messages:\n";
    foreach ($recentMessages as $msg) {
        $senderName = $msg->sender ? $msg->sender->first_name . ' ' . $msg->sender->last_name : 'Inconnu';
        $receiverName = $msg->receiver ? $msg->receiver->first_name . ' ' . $msg->receiver->last_name : 'Inconnu';
        echo "   - ID: {$msg->id} | De: $senderName (ID: {$msg->sender_id}) | À: $receiverName (ID: {$msg->receiver_id})\n";
        echo "     Message: " . substr($msg->message, 0, 50) . (strlen($msg->message) > 50 ? '...' : '') . "\n";
        echo "     Date: {$msg->created_at}\n";
    }
} else {
    echo "   ⚠️  Aucun message dans la base de données\n";
    echo "   Créons un message de test...\n";
    
    // Trouver un utilisateur et un admin
    $user = User::where('role', 'user')->first();
    $admin = User::where('role', 'admin')->first();
    
    if ($user && $admin) {
        $testMessage = ChatMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $admin->id,
            'message' => 'Message de test pour vérifier l\'affichage',
            'is_read' => false,
        ]);
        
        echo "   ✅ Message de test créé (ID: {$testMessage->id})\n";
    } else {
        echo "   ❌ Impossible de créer un message de test (utilisateur ou admin manquant)\n";
        $allTestsPassed = false;
    }
}

// Test 2: Simuler l'appel API getMessages
echo "\n2. Simulation de l'appel API getMessages...\n";

$testUser = User::where('role', 'user')->first();

if ($testUser) {
    echo "   Utilisateur de test: {$testUser->first_name} {$testUser->last_name} (ID: {$testUser->id})\n";
    
    // Simuler la récupération des messages
    $admin = User::where('role', 'admin')->first();
    
    if ($admin) {
        $messages = ChatMessage::where(function($query) use ($testUser, $admin) {
                $query->where(function($q) use ($testUser, $admin) {
                    $q->where('sender_id', $testUser->id)
                      ->where('receiver_id', $admin->id);
                })->orWhere(function($q) use ($testUser, $admin) {
                    $q->where('sender_id', $admin->id)
                      ->where('receiver_id', $testUser->id);
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        echo "   Messages récupérés: {$messages->count()}\n";
        
        if ($messages->count() > 0) {
            echo "   ✅ Messages trouvés pour cet utilisateur\n";
            
            // Test 3: Vérifier le format des données
            echo "\n3. Vérification du format des données...\n";
            
            $formattedMessages = $messages->map(function($message) {
                return [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message' => $message->message,
                    'is_read' => $message->is_read,
                    'attachment_path' => $message->attachment_path,
                    'attachment_name' => $message->attachment_name,
                    'attachment_type' => $message->attachment_type,
                    'attachment_size' => $message->attachment_size,
                    'created_at' => $message->created_at ? $message->created_at->toISOString() : null,
                    'updated_at' => $message->updated_at ? $message->updated_at->toISOString() : null,
                    'sender' => $message->sender ? [
                        'id' => $message->sender->id,
                        'first_name' => $message->sender->first_name,
                        'last_name' => $message->sender->last_name,
                        'email' => $message->sender->email,
                    ] : null,
                    'receiver' => $message->receiver ? [
                        'id' => $message->receiver->id,
                        'first_name' => $message->receiver->first_name,
                        'last_name' => $message->receiver->last_name,
                        'email' => $message->receiver->email,
                    ] : null,
                ];
            });
            
            echo "   Structure du premier message:\n";
            $firstMessage = $formattedMessages->first();
            echo "   " . json_encode($firstMessage, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
            
            // Vérifier les champs requis
            $requiredFields = ['id', 'sender_id', 'receiver_id', 'message', 'created_at', 'sender', 'receiver'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (!isset($firstMessage[$field])) {
                    $missingFields[] = $field;
                }
            }
            
            if (empty($missingFields)) {
                echo "   ✅ Tous les champs requis sont présents\n";
            } else {
                echo "   ❌ Champs manquants: " . implode(', ', $missingFields) . "\n";
                $allTestsPassed = false;
            }
            
            // Vérifier le format de la date
            if ($firstMessage['created_at']) {
                $dateTime = new DateTime($firstMessage['created_at']);
                echo "   ✅ Format de date valide: {$firstMessage['created_at']}\n";
            } else {
                echo "   ❌ Date invalide ou manquante\n";
                $allTestsPassed = false;
            }
            
        } else {
            echo "   ⚠️  Aucun message trouvé pour cet utilisateur\n";
        }
    } else {
        echo "   ❌ Aucun administrateur trouvé\n";
        $allTestsPassed = false;
    }
} else {
    echo "   ❌ Aucun utilisateur trouvé pour le test\n";
    $allTestsPassed = false;
}

// Test 4: Vérifier les logs
echo "\n4. Vérification des logs récents...\n";
$logFile = storage_path('logs/laravel.log');

if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    $recentLines = array_slice($lines, -50); // Dernières 50 lignes
    
    $chatLogs = array_filter($recentLines, function($line) {
        return strpos($line, 'ChatController') !== false || strpos($line, 'Chat message') !== false;
    });
    
    if (!empty($chatLogs)) {
        echo "   ✅ Logs du chat trouvés:\n";
        foreach (array_slice($chatLogs, -5) as $log) {
            echo "   " . substr($log, 0, 150) . "...\n";
        }
    } else {
        echo "   ⚠️  Aucun log récent du chat trouvé\n";
    }
} else {
    echo "   ⚠️  Fichier de log non trouvé\n";
}

// Résumé
echo "\n" . str_repeat("=", 60) . "\n";
if ($allTestsPassed) {
    echo "✅ TOUS LES TESTS SONT PASSÉS\n";
    echo "\nProchaines étapes:\n";
    echo "1. Connectez-vous en tant qu'utilisateur\n";
    echo "2. Ouvrez le widget de chat (bouton bleu en bas à droite)\n";
    echo "3. Ouvrez la console du navigateur (F12)\n";
    echo "4. Vérifiez les logs console:\n";
    echo "   - [ClientChat] Loading messages...\n";
    echo "   - [ClientChat] Response data:\n";
    echo "   - [ClientChat] Messages count: X\n";
    echo "   - [ClientChat] Displaying X messages\n";
    echo "5. Vérifiez que les messages s'affichent dans le widget\n";
} else {
    echo "❌ CERTAINS TESTS ONT ÉCHOUÉ\n";
    echo "\nVeuillez vérifier les erreurs ci-dessus.\n";
}
echo str_repeat("=", 60) . "\n";
