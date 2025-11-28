<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Création d'un compte administrateur ===\n\n";

// Données de l'admin
$adminData = [
    'first_name' => 'Admin',
    'last_name' => 'SG BANK',
    'email' => 'admin@sgbank.com',
    'password' => 'admin123', // Mot de passe par défaut
    'role' => 'admin',
    'status' => 'active',
    'balance' => 0,
];

// Vérifier si l'admin existe déjà
$existingAdmin = User::where('email', $adminData['email'])->first();

if ($existingAdmin) {
    echo "⚠️  Un utilisateur avec l'email {$adminData['email']} existe déjà!\n";
    echo "   Mise à jour du rôle et du statut...\n\n";
    
    $existingAdmin->update([
        'role' => 'admin',
        'status' => 'active',
        'password' => Hash::make($adminData['password']),
    ]);
    
    echo "✅ Utilisateur mis à jour en admin:\n";
    echo "   Email: {$existingAdmin->email}\n";
    echo "   Mot de passe: {$adminData['password']}\n";
    echo "   Rôle: {$existingAdmin->role}\n";
    echo "   Statut: {$existingAdmin->status}\n\n";
} else {
    // Créer le nouvel admin
    $admin = User::create([
        'first_name' => $adminData['first_name'],
        'last_name' => $adminData['last_name'],
        'email' => $adminData['email'],
        'password' => Hash::make($adminData['password']),
        'role' => $adminData['role'],
        'status' => $adminData['status'],
        'balance' => $adminData['balance'],
    ]);
    
    echo "✅ Compte administrateur créé avec succès!\n\n";
    echo "📧 Email: {$admin->email}\n";
    echo "🔑 Mot de passe: {$adminData['password']}\n";
    echo "👤 Rôle: {$admin->role}\n";
    echo "✔️  Statut: {$admin->status}\n\n";
}

echo "=== Vous pouvez maintenant vous connecter ===\n";
echo "URL: http://127.0.0.1:8000/login\n";
echo "Email: {$adminData['email']}\n";
echo "Mot de passe: {$adminData['password']}\n\n";

echo "⚠️  IMPORTANT: Changez le mot de passe après la première connexion!\n";

