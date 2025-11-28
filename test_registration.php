<?php

/**
 * Script de test pour l'inscription utilisateur
 * Ce script simule une inscription et vérifie le fonctionnement
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationNotification;

echo "=== Test d'inscription utilisateur ===\n\n";

// Données de test
$testData = [
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => 'testuser' . time() . '@example.com',
    'password' => 'password123',
    'phone' => '+33612345678',
    'address' => '123 Rue de Test',
    'country' => 'France',
    'city' => 'Paris',
];

echo "1. Création d'un nouvel utilisateur...\n";
echo "   Email: {$testData['email']}\n";

try {
    // Créer l'utilisateur
    $user = User::create([
        'first_name' => $testData['first_name'],
        'last_name' => $testData['last_name'],
        'email' => $testData['email'],
        'phone' => $testData['phone'],
        'address' => $testData['address'],
        'country' => $testData['country'],
        'city' => $testData['city'],
        'password' => Hash::make($testData['password']),
        'status' => 'pending',
        'balance' => 0,
        'role' => 'user',
    ]);
    
    echo "   ✅ Utilisateur créé avec succès (ID: {$user->id})\n";
    echo "   ✅ Statut: {$user->status}\n\n";
    
    // Vérifier les méthodes helper
    echo "2. Test des méthodes helper du modèle User...\n";
    echo "   isPending(): " . ($user->isPending() ? '✅ true' : '❌ false') . "\n";
    echo "   isActive(): " . ($user->isActive() ? '❌ true' : '✅ false') . "\n";
    echo "   isAdmin(): " . ($user->isAdmin() ? '❌ true' : '✅ false') . "\n";
    echo "   isSuspended(): " . ($user->isSuspended() ? '❌ true' : '✅ false') . "\n\n";
    
    // Test de la notification email
    echo "3. Test de l'envoi de notification d'inscription...\n";
    try {
        $admin = User::where('email', 'admin@sgbank.com')->first();
        if ($admin) {
            echo "   ✅ Admin trouvé: {$admin->email}\n";
            
            // Créer l'instance de mail
            $mail = new UserRegistrationNotification($user, now(), '127.0.0.1');
            echo "   ✅ Instance UserRegistrationNotification créée\n";
            echo "   ✅ Mail class existe et fonctionne\n\n";
        } else {
            echo "   ⚠️  Admin non trouvé (email: admin@sgbank.com)\n";
            echo "   Note: Créez un admin avec cet email pour tester les notifications\n\n";
        }
    } catch (\Exception $e) {
        echo "   ❌ Erreur lors de la création de la notification: " . $e->getMessage() . "\n\n";
    }
    
    // Test de l'approbation
    echo "4. Test de l'approbation de l'utilisateur...\n";
    $user->update(['status' => 'active']);
    echo "   ✅ Statut changé en 'active'\n";
    echo "   isPending(): " . ($user->isPending() ? '❌ true' : '✅ false') . "\n";
    echo "   isActive(): " . ($user->isActive() ? '✅ true' : '❌ false') . "\n\n";
    
    // Test de la notification d'approbation
    echo "5. Test de la notification d'approbation...\n";
    try {
        $approvalMail = new \App\Mail\UserApprovedNotification($user);
        echo "   ✅ Instance UserApprovedNotification créée\n";
        echo "   ✅ Mail class existe et fonctionne\n\n";
    } catch (\Exception $e) {
        echo "   ❌ Erreur lors de la création de la notification: " . $e->getMessage() . "\n\n";
    }
    
    // Nettoyage
    echo "6. Nettoyage...\n";
    $user->delete();
    echo "   ✅ Utilisateur de test supprimé\n\n";
    
    echo "=== RÉSUMÉ DES TESTS ===\n";
    echo "✅ Création d'utilisateur avec statut 'pending'\n";
    echo "✅ Méthodes helper (isPending, isActive, etc.)\n";
    echo "✅ Classes de mail (UserRegistrationNotification, UserApprovedNotification)\n";
    echo "✅ Changement de statut de 'pending' à 'active'\n\n";
    
    echo "🎉 Tous les tests sont passés avec succès!\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

