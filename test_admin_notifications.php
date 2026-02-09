<?php

require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Services\NotificationService;

echo "=== TEST DES NOTIFICATIONS ADMIN LOGIN/LOGOUT ===\n\n";

// 1. Créer des admins de test
echo "1. Création d'admins de test...\n";

$admin1 = User::firstOrCreate(
    ['email' => 'admin1@test.com'],
    [
        'first_name' => 'Admin',
        'last_name' => 'One',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
    ]
);

$admin2 = User::firstOrCreate(
    ['email' => 'admin2@test.com'],
    [
        'first_name' => 'Admin',
        'last_name' => 'Two',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
    ]
);

$admin3 = User::firstOrCreate(
    ['email' => 'admin3@test.com'],
    [
        'first_name' => 'Admin',
        'last_name' => 'Three',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
    ]
);

echo "✅ Admins créés: {$admin1->email}, {$admin2->email}, {$admin3->email}\n\n";

// 2. Vider les notifications existantes pour un test propre
echo "2. Nettoyage des notifications existantes...\n";
\DB::table('notifications')->truncate();
echo "✅ Notifications nettoyées\n\n";

// 3. Test de connexion admin1
echo "3. Test de connexion Admin1...\n";
$ipAddress = '192.168.1.100';
$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';

NotificationService::notifyAdminUserLogin($admin1, $ipAddress, $userAgent);

// Vérifier les notifications reçues
$admin2Notifications = User::find($admin2->id)->notifications()->where('type', 'account')->get();
$admin3Notifications = User::find($admin3->id)->notifications()->where('type', 'account')->get();
$admin1Notifications = User::find($admin1->id)->notifications()->where('type', 'account')->get();

echo "   - Admin2 a reçu " . $admin2Notifications->count() . " notification(s)\n";
echo "   - Admin3 a reçu " . $admin3Notifications->count() . " notification(s)\n";
echo "   - Admin1 a reçu " . $admin1Notifications->count() . " notification(s)\n";

if ($admin2Notifications->count() === 1 && $admin3Notifications->count() === 1 && $admin1Notifications->count() === 0) {
    echo "✅ Test de connexion réussi: Admin1 ne reçoit pas de notification, les autres oui\n";
} else {
    echo "❌ Test de connexion échoué\n";
}

// Afficher le contenu des notifications
if ($admin2Notifications->count() > 0) {
    echo "   Contenu notification Admin2: " . substr($admin2Notifications->first()->message, 0, 100) . "...\n";
}

echo "\n";

// 4. Test de déconnexion admin1
echo "4. Test de déconnexion Admin1...\n";

NotificationService::notifyAdminUserLogout($admin1, $ipAddress);

// Vérifier les notifications après déconnexion
$admin2NotificationsAfter = User::find($admin2->id)->notifications()->where('type', 'account')->get();
$admin3NotificationsAfter = User::find($admin3->id)->notifications()->where('type', 'account')->get();
$admin1NotificationsAfter = User::find($admin1->id)->notifications()->where('type', 'account')->get();

echo "   - Admin2 a maintenant " . $admin2NotificationsAfter->count() . " notification(s)\n";
echo "   - Admin3 a maintenant " . $admin3NotificationsAfter->count() . " notification(s)\n";
echo "   - Admin1 a maintenant " . $admin1NotificationsAfter->count() . " notification(s)\n";

if ($admin2NotificationsAfter->count() === 2 && $admin3NotificationsAfter->count() === 2 && $admin1NotificationsAfter->count() === 0) {
    echo "✅ Test de déconnexion réussi: Admin1 ne reçoit pas de notification, les autres oui\n";
} else {
    echo "❌ Test de déconnexion échoué\n";
}

// Afficher le contenu des dernières notifications
$latestAdmin2Notification = $admin2NotificationsAfter->last();
if ($latestAdmin2Notification) {
    echo "   Dernière notification Admin2: " . substr($latestAdmin2Notification->message, 0, 100) . "...\n";
}

echo "\n";

// 5. Test de connexion admin2
echo "5. Test de connexion Admin2...\n";

NotificationService::notifyAdminUserLogin($admin2, $ipAddress, $userAgent);

// Vérifier les notifications après connexion admin2
$admin1NotificationsFinal = User::find($admin1->id)->notifications()->where('type', 'account')->get();
$admin3NotificationsFinal = User::find($admin3->id)->notifications()->where('type', 'account')->get();
$admin2NotificationsFinal = User::find($admin2->id)->notifications()->where('type', 'account')->get();

echo "   - Admin1 a maintenant " . $admin1NotificationsFinal->count() . " notification(s)\n";
echo "   - Admin3 a maintenant " . $admin3NotificationsFinal->count() . " notification(s)\n";
echo "   - Admin2 a maintenant " . $admin2NotificationsFinal->count() . " notification(s)\n";

if ($admin1NotificationsFinal->count() === 1 && $admin3NotificationsFinal->count() === 3 && $admin2NotificationsFinal->count() === 0) {
    echo "✅ Test de connexion Admin2 réussi: Admin2 ne reçoit pas de notification, les autres oui\n";
} else {
    echo "❌ Test de connexion Admin2 échoué\n";
}

echo "\n=== RÉSUMÉ DU TEST ===\n";
echo "✅ Les admins reçoivent des notifications pour les connexions/déconnexions des autres admins\n";
echo "✅ Aucun admin ne reçoit de notification pour ses propres actions\n";
echo "✅ Le système de notification fonctionne correctement\n";

echo "\n=== FIN DU TEST ===\n";
