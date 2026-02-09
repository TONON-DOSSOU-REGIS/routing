<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DU COMPTEUR DE NOTIFICATIONS ===\n";

echo "1. Recherche d'un utilisateur admin...\n";
$admin = \App\Models\User::where('role', 'admin')->first();
if ($admin) {
    echo "✅ Admin trouvé: {$admin->name} (ID: {$admin->id})\n";

    echo "\n2. Vérification des notifications de l'admin...\n";
    $totalNotifications = $admin->notifications()->count();
    $unreadNotifications = $admin->unreadNotifications()->count();

    echo "Total des notifications: {$totalNotifications}\n";
    echo "Notifications non lues: {$unreadNotifications}\n";

    if ($unreadNotifications == 0) {
        echo "❌ Aucune notification non lue - c'est pourquoi le compteur n'apparaît pas!\n";

        echo "\n3. Création de notifications de test...\n";
        $notifications = [
            [
                'user_id' => $admin->id,
                'type' => 'system',
                'title' => 'Test Notification 1',
                'message' => 'Ceci est une notification de test numéro 1',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $admin->id,
                'type' => 'system',
                'title' => 'Test Notification 2',
                'message' => 'Ceci est une notification de test numéro 2',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($notifications as $notification) {
            \App\Models\Notification::create($notification);
        }

        echo "✅ 2 notifications de test créées\n";

        // Vérifier à nouveau
        $unreadAfter = $admin->unreadNotifications()->count();
        echo "Nouvelles notifications non lues: {$unreadAfter}\n";
    }

} else {
    echo "❌ Aucun admin trouvé\n";
}

echo "\n4. Test de l'endpoint unread-count...\n";
if ($admin) {
    // Simuler une requête pour tester l'endpoint
    $count = $admin->unreadNotifications()->count();
    echo "Endpoint unread-count retournerait: {$count}\n";
}

echo "\n=== FIN DU TEST ===\n";
