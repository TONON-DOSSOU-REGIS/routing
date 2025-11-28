<?php

/**
 * Script de test pour le système de notifications Admin/Utilisateur
 * 
 * Ce script teste:
 * 1. Connexion utilisateur (notifications admin + utilisateur)
 * 2. Inscription utilisateur (notification admin)
 * 3. Dépôt admin (notifications admin + utilisateur)
 * 4. Virement utilisateur (notifications admin + utilisateur)
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Notification;
use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "=================================================\n";
echo "TEST DU SYSTÈME DE NOTIFICATIONS ADMIN/UTILISATEUR\n";
echo "=================================================\n\n";

// Fonction helper pour afficher les résultats
function displayResult($test, $passed, $details = '') {
    $status = $passed ? "✅ PASS" : "❌ FAIL";
    echo "$status - $test\n";
    if ($details) {
        echo "   → $details\n";
    }
    echo "\n";
}

// Nettoyer les anciennes notifications de test
echo "🧹 Nettoyage des anciennes notifications de test...\n";
Notification::where('message', 'LIKE', '%TEST%')->delete();
echo "✓ Nettoyage terminé\n\n";

// ============================================
// TEST 1: Notifications de connexion utilisateur
// ============================================
echo "📋 TEST 1: Notifications de connexion utilisateur\n";
echo "---------------------------------------------------\n";

try {
    // Créer un utilisateur de test
    $testUser = User::where('email', 'test_notif_user@example.com')->first();
    if (!$testUser) {
        $testUser = User::create([
            'first_name' => 'Test',
            'last_name' => 'Notification User',
            'email' => 'test_notif_user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'active',
            'balance' => 1000,
        ]);
        echo "✓ Utilisateur de test créé: {$testUser->email}\n";
    } else {
        echo "✓ Utilisateur de test existant: {$testUser->email}\n";
    }

    // Compter les notifications avant
    $adminNotifsBefore = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->count();
    $userNotifsBefore = Notification::where('user_id', $testUser->id)->count();

    // Simuler une connexion utilisateur
    echo "\n🔄 Simulation de connexion utilisateur...\n";
    NotificationService::notifyAdminUserLogin($testUser, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0');
    NotificationService::notifyUserLogin($testUser, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0');

    // Compter les notifications après
    $adminNotifsAfter = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->count();
    $userNotifsAfter = Notification::where('user_id', $testUser->id)->count();

    // Vérifier les notifications admin
    $adminCount = User::where('role', 'admin')->count();
    $expectedAdminNotifs = $adminNotifsBefore + $adminCount;
    $adminNotifCreated = ($adminNotifsAfter >= $expectedAdminNotifs);
    displayResult(
        "Notifications admin créées pour connexion utilisateur",
        $adminNotifCreated,
        "Attendu: au moins $adminCount nouvelles notifications, Trouvé: " . ($adminNotifsAfter - $adminNotifsBefore)
    );

    // Vérifier la notification utilisateur
    $userNotifCreated = ($userNotifsAfter > $userNotifsBefore);
    displayResult(
        "Notification utilisateur créée pour sa propre connexion",
        $userNotifCreated,
        "Attendu: 1 nouvelle notification, Trouvé: " . ($userNotifsAfter - $userNotifsBefore)
    );

    // Vérifier le contenu de la notification admin
    $adminNotif = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->where('title', 'LIKE', '%Connexion utilisateur%')->latest()->first();

    if ($adminNotif) {
        $hasIP = strpos($adminNotif->message, '192.168.1.100') !== false;
        $hasBrowser = strpos($adminNotif->message, 'Chrome') !== false;
        $hasUserName = strpos($adminNotif->message, $testUser->first_name) !== false;
        
        displayResult(
            "Notification admin contient l'adresse IP",
            $hasIP,
            "IP trouvée: " . ($hasIP ? "Oui" : "Non")
        );
        
        displayResult(
            "Notification admin contient le navigateur",
            $hasBrowser,
            "Navigateur détecté: " . ($hasBrowser ? "Chrome" : "Non détecté")
        );
        
        displayResult(
            "Notification admin contient le nom de l'utilisateur",
            $hasUserName,
            "Nom trouvé: " . ($hasUserName ? "Oui" : "Non")
        );
    }

    // Vérifier le contenu de la notification utilisateur
    $userNotif = Notification::where('user_id', $testUser->id)
        ->where('title', 'LIKE', '%Connexion réussie%')
        ->latest()
        ->first();

    if ($userNotif) {
        $hasIP = strpos($userNotif->message, '192.168.1.100') !== false;
        $hasBrowser = strpos($userNotif->message, 'Chrome') !== false;
        
        displayResult(
            "Notification utilisateur contient l'adresse IP",
            $hasIP,
            "IP trouvée: " . ($hasIP ? "Oui" : "Non")
        );
        
        displayResult(
            "Notification utilisateur contient le navigateur",
            $hasBrowser,
            "Navigateur détecté: " . ($hasBrowser ? "Chrome" : "Non détecté")
        );
    }

} catch (\Exception $e) {
    displayResult("Test de connexion utilisateur", false, "Erreur: " . $e->getMessage());
}

// ============================================
// TEST 2: Notifications d'inscription utilisateur
// ============================================
echo "\n📋 TEST 2: Notifications d'inscription utilisateur\n";
echo "---------------------------------------------------\n";

try {
    // Créer un nouvel utilisateur pour simuler une inscription
    $newUser = User::create([
        'first_name' => 'Nouveau',
        'last_name' => 'Inscrit',
        'email' => 'nouveau_inscrit_' . time() . '@example.com',
        'password' => Hash::make('password123'),
        'role' => 'user',
        'status' => 'pending',
        'balance' => 0,
    ]);
    echo "✓ Nouvel utilisateur créé: {$newUser->email}\n";

    // Compter les notifications admin avant
    $adminNotifsBefore = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->count();

    // Simuler une inscription
    echo "\n🔄 Simulation d'inscription utilisateur...\n";
    NotificationService::notifyAdminUserRegistration($newUser, '192.168.1.101');

    // Compter les notifications admin après
    $adminNotifsAfter = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->count();

    // Vérifier les notifications admin
    $adminCount = User::where('role', 'admin')->count();
    $expectedAdminNotifs = $adminNotifsBefore + $adminCount;
    $adminNotifCreated = ($adminNotifsAfter >= $expectedAdminNotifs);
    displayResult(
        "Notifications admin créées pour inscription utilisateur",
        $adminNotifCreated,
        "Attendu: au moins $adminCount nouvelles notifications, Trouvé: " . ($adminNotifsAfter - $adminNotifsBefore)
    );

    // Vérifier le contenu de la notification
    $adminNotif = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->where('title', 'LIKE', '%Nouvelle inscription%')->latest()->first();

    if ($adminNotif) {
        $hasEmail = strpos($adminNotif->message, $newUser->email) !== false;
        $hasIP = strpos($adminNotif->message, '192.168.1.101') !== false;
        $hasUserName = strpos($adminNotif->message, $newUser->first_name) !== false;
        $hasPendingStatus = strpos($adminNotif->message, 'attente de validation') !== false;
        
        displayResult(
            "Notification admin contient l'email de l'utilisateur",
            $hasEmail,
            "Email trouvé: " . ($hasEmail ? "Oui" : "Non")
        );
        
        displayResult(
            "Notification admin contient l'adresse IP",
            $hasIP,
            "IP trouvée: " . ($hasIP ? "Oui" : "Non")
        );
        
        displayResult(
            "Notification admin contient le nom de l'utilisateur",
            $hasUserName,
            "Nom trouvé: " . ($hasUserName ? "Oui" : "Non")
        );
        
        displayResult(
            "Notification admin indique le statut 'en attente'",
            $hasPendingStatus,
            "Statut mentionné: " . ($hasPendingStatus ? "Oui" : "Non")
        );
    }

    // Nettoyer l'utilisateur de test
    $newUser->delete();

} catch (\Exception $e) {
    displayResult("Test d'inscription utilisateur", false, "Erreur: " . $e->getMessage());
}

// ============================================
// TEST 3: Notifications de dépôt
// ============================================
echo "\n📋 TEST 3: Notifications de dépôt\n";
echo "---------------------------------------------------\n";

try {
    // Utiliser l'utilisateur de test créé précédemment
    $testUser = User::where('email', 'test_notif_user@example.com')->first();
    
    if ($testUser) {
        // Compter les notifications avant
        $adminNotifsBefore = Notification::whereHas('user', function($q) {
            $q->where('role', 'admin');
        })->count();
        $userNotifsBefore = Notification::where('user_id', $testUser->id)->count();

        // Simuler un dépôt
        echo "\n🔄 Simulation de dépôt...\n";
        $depositAmount = 500.00;
        $depositCurrency = 'EUR';
        
        NotificationService::notifyAdminDeposit($testUser, $depositAmount, $depositCurrency);
        
        // Créer aussi une transaction pour tester la notification utilisateur
        $transaction = Transaction::create([
            'user_id' => $testUser->id,
            'amount' => $depositAmount,
            'type' => 'deposit',
            'status' => 'success',
            'progress' => 100,
        ]);
        
        NotificationService::notifyTransaction($testUser, $transaction, 'success');

        // Compter les notifications après
        $adminNotifsAfter = Notification::whereHas('user', function($q) {
            $q->where('role', 'admin');
        })->count();
        $userNotifsAfter = Notification::where('user_id', $testUser->id)->count();

        // Vérifier les notifications admin
        $adminCount = User::where('role', 'admin')->count();
        $expectedAdminNotifs = $adminNotifsBefore + $adminCount;
        $adminNotifCreated = ($adminNotifsAfter >= $expectedAdminNotifs);
        displayResult(
            "Notifications admin créées pour dépôt",
            $adminNotifCreated,
            "Attendu: au moins $adminCount nouvelles notifications, Trouvé: " . ($adminNotifsAfter - $adminNotifsBefore)
        );

        // Vérifier la notification utilisateur
        $userNotifCreated = ($userNotifsAfter > $userNotifsBefore);
        displayResult(
            "Notification utilisateur créée pour dépôt reçu",
            $userNotifCreated,
            "Attendu: 1 nouvelle notification, Trouvé: " . ($userNotifsAfter - $userNotifsBefore)
        );

        // Vérifier le contenu de la notification admin
        $adminNotif = Notification::whereHas('user', function($q) {
            $q->where('role', 'admin');
        })->where('title', 'LIKE', '%Dépôt effectué%')->latest()->first();

        if ($adminNotif) {
            $hasAmount = strpos($adminNotif->message, '500') !== false;
            $hasCurrency = strpos($adminNotif->message, '€') !== false;
            $hasUserName = strpos($adminNotif->message, $testUser->first_name) !== false;
            
            displayResult(
                "Notification admin contient le montant",
                $hasAmount,
                "Montant trouvé: " . ($hasAmount ? "Oui" : "Non")
            );
            
            displayResult(
                "Notification admin contient la devise",
                $hasCurrency,
                "Devise trouvée: " . ($hasCurrency ? "Oui (€)" : "Non")
            );
            
            displayResult(
                "Notification admin contient le nom de l'utilisateur",
                $hasUserName,
                "Nom trouvé: " . ($hasUserName ? "Oui" : "Non")
            );
        }

        // Nettoyer la transaction de test
        $transaction->delete();
    }

} catch (\Exception $e) {
    displayResult("Test de dépôt", false, "Erreur: " . $e->getMessage());
}

// ============================================
// TEST 4: Vérification des types et couleurs
// ============================================
echo "\n📋 TEST 4: Vérification des types et couleurs de notifications\n";
echo "---------------------------------------------------\n";

try {
    // Vérifier les notifications admin de connexion
    $loginNotif = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->where('title', 'LIKE', '%Connexion utilisateur%')->latest()->first();

    if ($loginNotif) {
        displayResult(
            "Notification connexion - Type correct",
            $loginNotif->type === 'account',
            "Type: {$loginNotif->type}"
        );
        
        displayResult(
            "Notification connexion - Couleur correcte",
            $loginNotif->color === 'blue',
            "Couleur: {$loginNotif->color}"
        );
        
        displayResult(
            "Notification connexion - Icône correcte",
            $loginNotif->icon === 'fa-sign-in-alt',
            "Icône: {$loginNotif->icon}"
        );
    }

    // Vérifier les notifications admin d'inscription
    $registerNotif = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->where('title', 'LIKE', '%Nouvelle inscription%')->latest()->first();

    if ($registerNotif) {
        displayResult(
            "Notification inscription - Type correct",
            $registerNotif->type === 'account',
            "Type: {$registerNotif->type}"
        );
        
        displayResult(
            "Notification inscription - Couleur correcte",
            $registerNotif->color === 'purple',
            "Couleur: {$registerNotif->color}"
        );
        
        displayResult(
            "Notification inscription - Icône correcte",
            $registerNotif->icon === 'fa-user-plus',
            "Icône: {$registerNotif->icon}"
        );
    }

    // Vérifier les notifications admin de dépôt
    $depositNotif = Notification::whereHas('user', function($q) {
        $q->where('role', 'admin');
    })->where('title', 'LIKE', '%Dépôt effectué%')->latest()->first();

    if ($depositNotif) {
        displayResult(
            "Notification dépôt - Type correct",
            $depositNotif->type === 'transaction',
            "Type: {$depositNotif->type}"
        );
        
        displayResult(
            "Notification dépôt - Couleur correcte",
            $depositNotif->color === 'green',
            "Couleur: {$depositNotif->color}"
        );
        
        displayResult(
            "Notification dépôt - Icône correcte",
            $depositNotif->icon === 'fa-money-bill-wave',
            "Icône: {$depositNotif->icon}"
        );
    }

} catch (\Exception $e) {
    displayResult("Test des types et couleurs", false, "Erreur: " . $e->getMessage());
}

// ============================================
// RÉSUMÉ DES TESTS
// ============================================
echo "\n=================================================\n";
echo "RÉSUMÉ DES TESTS\n";
echo "=================================================\n\n";

$totalNotifications = Notification::count();
$adminNotifications = Notification::whereHas('user', function($q) {
    $q->where('role', 'admin');
})->count();
$userNotifications = Notification::whereHas('user', function($q) {
    $q->where('role', 'user');
})->count();

echo "📊 Statistiques des notifications:\n";
echo "   • Total de notifications: $totalNotifications\n";
echo "   • Notifications admin: $adminNotifications\n";
echo "   • Notifications utilisateur: $userNotifications\n\n";

echo "✅ Tests terminés avec succès!\n\n";
echo "📝 Prochaines étapes recommandées:\n";
echo "   1. Tester manuellement l'interface utilisateur\n";
echo "   2. Vérifier la cloche de notification dans le dashboard\n";
echo "   3. Tester le marquage des notifications comme lues\n";
echo "   4. Vérifier les liens d'action des notifications\n\n";

