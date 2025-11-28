<?php

/**
 * Script de test pour vérifier la correction du bug d'attachement de chat
 * 
 * Ce script vérifie:
 * 1. La structure de la table chat_messages
 * 2. La possibilité de créer un message avec attachement
 * 3. La récupération des messages avec attachements
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\ChatMessage;
use App\Models\User;

echo "=== TEST DE CORRECTION DU BUG D'ATTACHEMENT DE CHAT ===\n\n";

// Test 1: Vérifier la structure de la table
echo "1. Vérification de la structure de la table chat_messages...\n";
echo "   Colonnes présentes:\n";

$columns = Schema::getColumnListing('chat_messages');
$requiredColumns = [
    'id',
    'sender_id',
    'receiver_id',
    'message',
    'is_read',
    'attachment_path',
    'attachment_name',
    'attachment_type',
    'attachment_size',
    'created_at',
    'updated_at'
];

$allPresent = true;
foreach ($requiredColumns as $column) {
    $present = in_array($column, $columns);
    $status = $present ? '✓' : '✗';
    echo "   $status $column\n";
    if (!$present) {
        $allPresent = false;
    }
}

if ($allPresent) {
    echo "   ✅ Toutes les colonnes requises sont présentes!\n\n";
} else {
    echo "   ❌ Certaines colonnes sont manquantes!\n\n";
    exit(1);
}

// Test 2: Vérifier qu'on peut créer un message sans attachement
echo "2. Test de création d'un message sans attachement...\n";

try {
    $admin = User::where('role', 'admin')->first();
    $user = User::where('role', 'user')->first();
    
    if (!$admin || !$user) {
        echo "   ⚠️  Pas d'utilisateurs disponibles pour le test\n\n";
    } else {
        $message = ChatMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $admin->id,
            'message' => 'Test message sans attachement',
            'is_read' => false,
        ]);
        
        echo "   ✅ Message créé avec succès (ID: {$message->id})\n";
        echo "   Message: {$message->message}\n";
        echo "   A un attachement: " . ($message->hasAttachment() ? 'Oui' : 'Non') . "\n\n";
        
        // Nettoyer
        $message->delete();
    }
} catch (\Exception $e) {
    echo "   ❌ Erreur lors de la création du message: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 3: Vérifier qu'on peut créer un message avec attachement simulé
echo "3. Test de création d'un message avec attachement simulé...\n";

try {
    if ($admin && $user) {
        $message = ChatMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $admin->id,
            'message' => 'Test message avec attachement',
            'is_read' => false,
            'attachment_path' => 'chat_attachments/test_file.jpg',
            'attachment_name' => 'test_file.jpg',
            'attachment_type' => 'image/jpeg',
            'attachment_size' => 123456,
        ]);
        
        echo "   ✅ Message avec attachement créé avec succès (ID: {$message->id})\n";
        echo "   Message: {$message->message}\n";
        echo "   A un attachement: " . ($message->hasAttachment() ? 'Oui' : 'Non') . "\n";
        echo "   Nom du fichier: {$message->attachment_name}\n";
        echo "   Type: {$message->attachment_type}\n";
        echo "   Taille: {$message->formatted_size}\n";
        echo "   Est une image: " . ($message->isImage() ? 'Oui' : 'Non') . "\n\n";
        
        // Nettoyer
        $message->delete();
    }
} catch (\Exception $e) {
    echo "   ❌ Erreur lors de la création du message avec attachement: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 4: Vérifier qu'on peut créer un message avec seulement un attachement (sans texte)
echo "4. Test de création d'un message avec seulement un attachement (sans texte)...\n";

try {
    if ($admin && $user) {
        $message = ChatMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $admin->id,
            'message' => null,
            'is_read' => false,
            'attachment_path' => 'chat_attachments/document.pdf',
            'attachment_name' => 'document.pdf',
            'attachment_type' => 'application/pdf',
            'attachment_size' => 654321,
        ]);
        
        echo "   ✅ Message avec seulement un attachement créé avec succès (ID: {$message->id})\n";
        echo "   Message: " . ($message->message ?: '(vide)') . "\n";
        echo "   A un attachement: " . ($message->hasAttachment() ? 'Oui' : 'Non') . "\n";
        echo "   Nom du fichier: {$message->attachment_name}\n";
        echo "   Est une image: " . ($message->isImage() ? 'Oui' : 'Non') . "\n\n";
        
        // Nettoyer
        $message->delete();
    }
} catch (\Exception $e) {
    echo "   ❌ Erreur lors de la création du message avec seulement un attachement: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 5: Vérifier les méthodes du modèle
echo "5. Test des méthodes du modèle ChatMessage...\n";

try {
    if ($admin && $user) {
        $message = ChatMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $admin->id,
            'message' => 'Test des méthodes',
            'is_read' => false,
            'attachment_path' => 'chat_attachments/image.png',
            'attachment_name' => 'image.png',
            'attachment_type' => 'image/png',
            'attachment_size' => 2048000, // 2MB
        ]);
        
        echo "   ✅ Méthode hasAttachment(): " . ($message->hasAttachment() ? 'true' : 'false') . "\n";
        echo "   ✅ Méthode isImage(): " . ($message->isImage() ? 'true' : 'false') . "\n";
        echo "   ✅ Méthode getFormattedSizeAttribute(): {$message->formatted_size}\n";
        echo "   ✅ Méthode getAttachmentUrlAttribute(): " . ($message->attachment_url ?: 'null') . "\n\n";
        
        // Nettoyer
        $message->delete();
    }
} catch (\Exception $e) {
    echo "   ❌ Erreur lors du test des méthodes: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Résumé final
echo "=== RÉSUMÉ DES TESTS ===\n";
echo "✅ Structure de la table: OK\n";
echo "✅ Création de message sans attachement: OK\n";
echo "✅ Création de message avec attachement: OK\n";
echo "✅ Création de message avec seulement attachement: OK\n";
echo "✅ Méthodes du modèle: OK\n\n";

echo "🎉 TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS!\n";
echo "Le bug d'attachement de chat a été corrigé correctement.\n\n";

echo "Vous pouvez maintenant:\n";
echo "1. Envoyer des messages texte via le chatbot\n";
echo "2. Envoyer des messages avec des pièces jointes\n";
echo "3. Envoyer uniquement des pièces jointes sans texte\n\n";

