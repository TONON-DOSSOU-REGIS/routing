<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DES NOTIFICATIONS ===\n";

echo "1. Recherche d'un utilisateur...\n";
$user = \App\Models\User::first();
if ($user) {
    echo "✅ Utilisateur trouvé: {$user->name}\n";
} else {
    echo "❌ Aucun utilisateur trouvé\n";
}

echo "\n2. Test des méthodes NotificationService...\n";
$methods = ['notifyAdminUserLogin', 'notifyUserLogin', 'notifyAdminUserRegistration', 'notifyAdminUserLogout', 'notifyAdminTransfer', 'notifyAdminTransferFailed', 'notifyAdminDeposit'];
foreach($methods as $method) {
    if (method_exists(\App\Services\NotificationService::class, $method)) {
        echo "✅ {$method}\n";
    } else {
        echo "❌ {$method}\n";
    }
}

echo "\n3. Test des routes de notifications...\n";
$routes = [
    'notifications.index' => 'GET',
    'notifications.recent' => 'GET',
    'notifications.unread-count' => 'GET',
    'notifications.markAsRead' => 'POST',
    'notifications.markAllAsRead' => 'POST'
];

foreach($routes as $routeName => $method) {
    try {
        $url = route($routeName, ['locale' => 'fr']);
        echo "✅ {$routeName}: {$url}\n";
    } catch (Exception $e) {
        echo "❌ {$routeName}: Erreur - {$e->getMessage()}\n";
    }
}

echo "\n=== FIN DU TEST ===\n";
