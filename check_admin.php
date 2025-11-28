<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== Vérification de l'admin ===\n\n";

// Chercher l'admin
$admin = User::where('role', 'admin')->first();

if ($admin) {
    echo "✅ Admin trouvé:\n";
    echo "   ID: {$admin->id}\n";
    echo "   Email: {$admin->email}\n";
    echo "   Nom: {$admin->first_name} {$admin->last_name}\n";
    echo "   Rôle: {$admin->role}\n";
    echo "   Statut: {$admin->status}\n";
    echo "   Créé le: {$admin->created_at}\n\n";
    
    // Vérifier si le statut est 'active'
    if ($admin->status !== 'active') {
        echo "⚠️  PROBLÈME DÉTECTÉ: Le statut de l'admin n'est pas 'active'!\n";
        echo "   Statut actuel: {$admin->status}\n\n";
        
        echo "Correction du statut...\n";
        $admin->update(['status' => 'active']);
        echo "✅ Statut mis à jour en 'active'\n\n";
    } else {
        echo "✅ Le statut de l'admin est correct (active)\n\n";
    }
    
    // Tester la connexion
    echo "Test de connexion avec le mot de passe...\n";
    echo "Note: Si vous ne connaissez pas le mot de passe, il faudra le réinitialiser\n\n";
    
} else {
    echo "❌ Aucun admin trouvé dans la base de données!\n\n";
    echo "Liste de tous les utilisateurs:\n";
    $users = User::all();
    foreach ($users as $user) {
        echo "   - {$user->email} (rôle: {$user->role}, statut: {$user->status})\n";
    }
}

