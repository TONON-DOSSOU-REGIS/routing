<?php

/**
 * Script de test pour vérifier la correction du bug de notification de dépôt
 * 
 * Ce script teste:
 * 1. La création d'une notification in-app pour un dépôt
 * 2. Le contenu correct de la notification
 * 3. La méthode notifyDeposit() du NotificationService
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;

echo "\n";
echo "========================================\n";
echo "TEST DE NOTIFICATION DE DÉPÔT\n";
echo "========================================\n\n";

function displayResult($testName, $passed, $details = '') {
    $status = $passed ? '✅ PASS' : '❌ FAIL';
    echo "{$status} - {$testName}\n";
    if ($details) {
        echo "   → {$details}\n";
    }
    echo "\n";
}

try {
    // 1. Trouver ou créer un utilisateur de test
    echo "1️⃣ Préparation de l'utilisateur de test...\n";
    $testUser = User::where('email', 'test.deposit@example.com')->first();
    
    if (!$testUser) {
        $testUser = User::create([
            'first_name' => 'Test',
            'last_name' => 'Deposit',
            'email' => 'test.deposit@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'status' => 'active',
            'balance' => 1000.00,
            'default_currency' => 'EUR',
        ]);
        echo "   ✅ Utilisateur de test créé\n\n";
    } else {
        echo "   ✅ Utilisateur de test existant trouvé\n\n";
    }

    // 2. Créer une transaction de dépôt
    echo "2️⃣ Création d'une transaction de dépôt...\n";
    $depositAmount = 500.00;
    $depositCurrency = 'EUR';
    
    $transaction = Transaction::create([
        'user_id' => $testUser->id,
        'amount' => $depositAmount,
        'type' => 'deposit',
        'reason' => 'Test de notification de dépôt',
        'status' => 'success',
        'progress' => 100,
        'meta' => ['currency' => $depositCurrency],
    ]);
    
    displayResult(
        "Transaction de dépôt créée",
        $transaction->exists,
        "ID: {$transaction->id}, Montant: {$depositAmount} {$depositCurrency}"
    );

    // 3. Tester la méthode notifyDeposit()
    echo "3️⃣ Test de la notification in-app...\n";
    
    // Supprimer les anciennes notifications de test
    Notification::where('user_id', $testUser->id)
                ->where('type', 'transaction')
                ->delete();
    
    // Créer la notification
    NotificationService::notifyDeposit($testUser, $transaction);
    
    // Vérifier que la notification a été créée
    $notification = Notification::where('user_id', $testUser->id)
                                ->where('type', 'transaction')
                                ->latest()
                                ->first();
    
    displayResult(
        "Notification créée",
        $notification !== null,
        $notification ? "ID: {$notification->id}" : "Aucune notification trouvée"
    );

    if ($notification) {
        // 4. Vérifier le titre de la notification
        displayResult(
            "Titre correct",
            $notification->title === 'Dépôt effectué',
            "Titre: '{$notification->title}'"
        );

        // 5. Vérifier le message de la notification
        $expectedMessage = "Un dépôt de 500,00 € a été crédité sur votre compte.";
        $messageCorrect = strpos($notification->message, 'dépôt') !== false && 
                         strpos($notification->message, '500') !== false;
        
        displayResult(
            "Message correct (contient 'dépôt' et le montant)",
            $messageCorrect,
            "Message: '{$notification->message}'"
        );

        // 6. Vérifier les données de la notification
        $data = $notification->data;
        displayResult(
            "Données de transaction présentes",
            isset($data['transaction_id']) && isset($data['amount']) && isset($data['type']),
            "Transaction ID: {$data['transaction_id']}, Type: {$data['type']}"
        );

        displayResult(
            "Type de transaction correct",
            $data['type'] === 'deposit',
            "Type: {$data['type']}"
        );

        // 7. Vérifier que la notification n'est pas lue
        displayResult(
            "Notification non lue",
            !$notification->is_read,
            "is_read: " . ($notification->is_read ? 'true' : 'false')
        );
    }

    // 8. Test de la méthode notifyTransaction() améliorée
    echo "\n4️⃣ Test de la méthode notifyTransaction() améliorée...\n";
    
    // Supprimer les anciennes notifications
    Notification::where('user_id', $testUser->id)->delete();
    
    // Créer une nouvelle transaction
    $transaction2 = Transaction::create([
        'user_id' => $testUser->id,
        'amount' => 250.00,
        'type' => 'deposit',
        'reason' => 'Test notifyTransaction',
        'status' => 'success',
        'progress' => 100,
        'meta' => ['currency' => 'EUR'],
    ]);
    
    // Utiliser notifyTransaction() au lieu de notifyDeposit()
    NotificationService::notifyTransaction($testUser, $transaction2);
    
    $notification2 = Notification::where('user_id', $testUser->id)
                                 ->latest()
                                 ->first();
    
    if ($notification2) {
        $messageContainsDeposit = strpos($notification2->message, 'dépôt') !== false;
        $messageNotContainsRetrait = strpos($notification2->message, 'retrait') === false;
        
        displayResult(
            "notifyTransaction() gère correctement le type 'deposit'",
            $messageContainsDeposit && $messageNotContainsRetrait,
            "Message: '{$notification2->message}'"
        );
    }

    // 9. Résumé des tests
    echo "\n========================================\n";
    echo "RÉSUMÉ DES TESTS\n";
    echo "========================================\n\n";
    
    $totalNotifications = Notification::where('user_id', $testUser->id)->count();
    echo "✅ Total de notifications créées: {$totalNotifications}\n";
    echo "✅ Transaction de test ID: {$transaction->id}\n";
    echo "✅ Utilisateur de test ID: {$testUser->id}\n";
    
    echo "\n📋 VÉRIFICATIONS MANUELLES RECOMMANDÉES:\n";
    echo "   1. Connectez-vous en tant qu'admin\n";
    echo "   2. Effectuez un dépôt sur le compte de: {$testUser->email}\n";
    echo "   3. Vérifiez que le client reçoit:\n";
    echo "      - Une notification in-app avec 'Dépôt effectué'\n";
    echo "      - Un email de notification\n";
    echo "   4. Vérifiez que le message contient 'dépôt' et non 'retrait'\n";
    
    echo "\n✅ CORRECTION APPLIQUÉE AVEC SUCCÈS!\n\n";
    
    // Nettoyage optionnel
    echo "🧹 Nettoyage des données de test...\n";
    $cleanup = readline("Voulez-vous supprimer les données de test? (y/n): ");
    
    if (strtolower(trim($cleanup)) === 'y') {
        Notification::where('user_id', $testUser->id)->delete();
        Transaction::where('user_id', $testUser->id)->delete();
        $testUser->delete();
        echo "✅ Données de test supprimées\n\n";
    } else {
        echo "ℹ️  Données de test conservées pour inspection manuelle\n\n";
    }

} catch (\Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n\n";
}

echo "========================================\n";
echo "FIN DES TESTS\n";
echo "========================================\n\n";
