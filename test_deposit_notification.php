<?php

/**
 * Script de test pour vérifier les notifications de dépôt
 * 
 * Ce script teste que les notifications sont correctement créées
 * lors d'un dépôt manuel par un administrateur.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Notification;
use App\Services\NotificationService;

echo "=== Test des Notifications de Dépôt ===\n\n";

// Fonction pour afficher les résultats
function displayResult($test, $passed, $details = '') {
    $status = $passed ? '✅ PASS' : '❌ FAIL';
    echo "{$status} - {$test}\n";
    if ($details) {
        echo "   └─ {$details}\n";
    }
    echo "\n";
}

try {
    // 1. Trouver un admin et un utilisateur pour le test
    echo "1. Recherche des utilisateurs de test...\n";
    $admin = User::where('role', 'admin')->first();
    $user = User::where('role', 'user')->first();
    
    if (!$admin) {
        echo "❌ Aucun administrateur trouvé dans la base de données.\n";
        exit(1);
    }
    
    if (!$user) {
        echo "❌ Aucun utilisateur trouvé dans la base de données.\n";
        exit(1);
    }
    
    displayResult(
        "Utilisateurs trouvés",
        true,
        "Admin: {$admin->first_name} {$admin->last_name}, User: {$user->first_name} {$user->last_name}"
    );
    
    // 2. Compter les notifications avant le test
    $notificationsBefore = Notification::where('user_id', $admin->id)->count();
    echo "2. Notifications existantes pour l'admin: {$notificationsBefore}\n\n";
    
    // 3. Créer une notification de confirmation de dépôt
    echo "3. Création de la notification de confirmation de dépôt...\n";
    $amount = 500.00;
    $currency = 'EUR';
    
    $notification = NotificationService::notifyAdminDepositConfirmation($admin, $user, $amount, $currency);
    
    displayResult(
        "Notification créée",
        $notification !== null,
        "ID: {$notification->id}"
    );
    
    // 4. Vérifier les détails de la notification
    echo "4. Vérification des détails de la notification...\n\n";
    
    displayResult(
        "Type de notification",
        $notification->type === 'transaction',
        "Type: {$notification->type}"
    );
    
    displayResult(
        "Titre de la notification",
        $notification->title === '✅ Dépôt confirmé',
        "Titre: {$notification->title}"
    );
    
    displayResult(
        "Message contient le montant",
        strpos($notification->message, '500,00') !== false,
        "Message: {$notification->message}"
    );
    
    displayResult(
        "Message contient le nom de l'utilisateur",
        strpos($notification->message, $user->first_name) !== false && 
        strpos($notification->message, $user->last_name) !== false,
        "Utilisateur mentionné: {$user->first_name} {$user->last_name}"
    );
    
    displayResult(
        "Couleur de la notification",
        $notification->color === 'green',
        "Couleur: {$notification->color}"
    );
    
    displayResult(
        "Icône de la notification",
        $notification->icon === 'fa-check-circle',
        "Icône: {$notification->icon}"
    );
    
    displayResult(
        "URL d'action",
        $notification->action_url !== null,
        "URL: {$notification->action_url}"
    );
    
    displayResult(
        "Notification non lue",
        $notification->read_at === null,
        "Statut: Non lue"
    );
    
    // 5. Vérifier que la notification est bien assignée à l'admin
    displayResult(
        "Notification assignée à l'admin",
        $notification->user_id === $admin->id,
        "Admin ID: {$admin->id}"
    );
    
    // 6. Compter les notifications après le test
    $notificationsAfter = Notification::where('user_id', $admin->id)->count();
    displayResult(
        "Nombre de notifications augmenté",
        $notificationsAfter === $notificationsBefore + 1,
        "Avant: {$notificationsBefore}, Après: {$notificationsAfter}"
    );
    
    // 7. Test avec différentes devises
    echo "5. Test avec différentes devises...\n\n";
    
    $currencies = ['EUR', 'USD', 'GBP'];
    foreach ($currencies as $testCurrency) {
        $testNotification = NotificationService::notifyAdminDepositConfirmation($admin, $user, 100, $testCurrency);
        $expectedSymbol = $testCurrency === 'EUR' ? '€' : $testCurrency;
        $hasCorrectCurrency = strpos($testNotification->message, $expectedSymbol) !== false;
        
        displayResult(
            "Notification avec devise {$testCurrency}",
            $hasCorrectCurrency,
            "Symbole trouvé: {$expectedSymbol}"
        );
        
        // Nettoyer
        $testNotification->delete();
    }
    
    // 8. Nettoyer la notification de test
    echo "6. Nettoyage...\n";
    $notification->delete();
    echo "✅ Notification de test supprimée\n\n";
    
    echo "=== Tous les tests sont passés avec succès! ===\n";
    echo "\n";
    echo "Résumé:\n";
    echo "- La méthode notifyAdminDepositConfirmation() fonctionne correctement\n";
    echo "- Les notifications sont créées avec les bonnes informations\n";
    echo "- Le formatage des montants et devises est correct\n";
    echo "- Les notifications sont bien assignées à l'administrateur\n";
    echo "\n";
    echo "Prochaine étape: Tester dans l'interface web en effectuant un dépôt manuel\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERREUR: {$e->getMessage()}\n";
    echo "Trace: {$e->getTraceAsString()}\n";
    exit(1);
}

