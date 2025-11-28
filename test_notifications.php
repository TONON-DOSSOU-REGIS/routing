<?php

/**
 * Script de Test des Notifications
 * 
 * Exécuter avec: php artisan tinker < test_notifications.php
 * Ou copier-coller dans tinker
 */

use App\Models\User;
use App\Models\Notification;
use App\Services\NotificationService;

echo "\n=== TEST DES NOTIFICATIONS ===\n\n";

// 1. Vérifier qu'un utilisateur existe
echo "1. Recherche d'un utilisateur...\n";
$user = User::first();

if (!$user) {
    echo "❌ Aucun utilisateur trouvé. Créez un utilisateur d'abord.\n";
    exit;
}

echo "✅ Utilisateur trouvé: {$user->first_name} {$user->last_name} (ID: {$user->id})\n\n";

// 2. Créer une notification de bienvenue
echo "2. Création d'une notification de bienvenue...\n";
try {
    $welcome = NotificationService::notifyWelcome($user);
    echo "✅ Notification de bienvenue créée (ID: {$welcome->id})\n\n";
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n\n";
}

// 3. Créer une notification système
echo "3. Création d'une notification système...\n";
try {
    $system = NotificationService::notifySystem($user, '🔔 Test Système', 'Ceci est une notification de test', 'blue');
    echo "✅ Notification système créée (ID: {$system->id})\n\n";
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n\n";
}

// 4. Créer une notification d'alerte
echo "4. Création d'une notification d'alerte...\n";
try {
    $alert = NotificationService::notifyLowBalance($user, 100);
    echo "✅ Notification d'alerte créée (ID: {$alert->id})\n\n";
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n\n";
}

// 5. Compter les notifications
echo "5. Comptage des notifications...\n";
$total = $user->notifications()->count();
$unread = $user->unreadNotifications()->count();
echo "✅ Total: {$total} notifications\n";
echo "✅ Non lues: {$unread} notifications\n\n";

// 6. Afficher les 5 dernières
echo "6. Affichage des 5 dernières notifications:\n";
$recent = $user->notifications()->latest()->take(5)->get();
foreach ($recent as $notif) {
    $status = $notif->is_read ? '✓' : '○';
    echo "  [{$status}] {$notif->title} - {$notif->message}\n";
}
echo "\n";

// 7. Marquer une comme lue
echo "7. Marquage d'une notification comme lue...\n";
$firstUnread = $user->unreadNotifications()->first();
if ($firstUnread) {
    $firstUnread->markAsRead();
    echo "✅ Notification marquée comme lue (ID: {$firstUnread->id})\n\n";
} else {
    echo "ℹ️  Aucune notification non lue\n\n";
}

// 8. Statistiques finales
echo "8. Statistiques finales:\n";
$finalTotal = $user->notifications()->count();
$finalUnread = $user->unreadNotifications()->count();
$finalRead = $user->notifications()->where('is_read', true)->count();
echo "  Total: {$finalTotal}\n";
echo "  Non lues: {$finalUnread}\n";
echo "  Lues: {$finalRead}\n\n";

echo "=== TEST TERMINÉ ===\n\n";

// Instructions pour les tests manuels
echo "Pour tester manuellement dans tinker:\n";
echo "  \$user = User::first();\n";
echo "  NotificationService::notifyWelcome(\$user);\n";
echo "  \$user->notifications;\n";
echo "  \$user->unreadNotifications();\n\n";

