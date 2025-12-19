<?php

/**
 * Test Script: Chat Attachment CSRF Fix Verification
 * 
 * This script verifies that the CSRF token fix for chat attachments is working correctly.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;

echo "=================================================\n";
echo "TEST: Chat Attachment CSRF Fix Verification\n";
echo "=================================================\n\n";

$allTestsPassed = true;

// Test 1: Verify client chat widget file exists
echo "1. Vérification du fichier client-chat-widget...\n";
$widgetPath = resource_path('views/components/client-chat-widget.blade.php');
if (File::exists($widgetPath)) {
    echo "   ✅ Fichier existe: $widgetPath\n";
    
    $content = File::get($widgetPath);
    
    // Test 1.1: Check for dynamic CSRF token retrieval
    echo "\n   1.1. Vérification de la récupération dynamique du token CSRF...\n";
    if (strpos($content, "document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content')") !== false) {
        echo "       ✅ Token CSRF récupéré dynamiquement depuis la meta tag\n";
    } else {
        echo "       ❌ Token CSRF non récupéré dynamiquement\n";
        $allTestsPassed = false;
    }
    
    // Test 1.2: Check for CSRF token validation
    echo "\n   1.2. Vérification de la validation du token CSRF...\n";
    if (strpos($content, "if (!csrfToken)") !== false) {
        echo "       ✅ Validation du token CSRF présente\n";
    } else {
        echo "       ❌ Validation du token CSRF manquante\n";
        $allTestsPassed = false;
    }
    
    // Test 1.3: Check for error message when CSRF token is missing
    echo "\n   1.3. Vérification du message d'erreur pour token manquant...\n";
    if (strpos($content, "Token CSRF manquant") !== false) {
        echo "       ✅ Message d'erreur pour token manquant présent\n";
    } else {
        echo "       ❌ Message d'erreur pour token manquant absent\n";
        $allTestsPassed = false;
    }
    
    // Test 1.4: Check for 419 error handling (CSRF token mismatch)
    echo "\n   1.4. Vérification de la gestion de l'erreur 419 (CSRF mismatch)...\n";
    if (strpos($content, "response.status === 419") !== false) {
        echo "       ✅ Gestion de l'erreur 419 présente\n";
    } else {
        echo "       ❌ Gestion de l'erreur 419 manquante\n";
        $allTestsPassed = false;
    }
    
    // Test 1.5: Check for session expired message
    echo "\n   1.5. Vérification du message de session expirée...\n";
    if (strpos($content, "session a expiré") !== false) {
        echo "       ✅ Message de session expirée présent\n";
    } else {
        echo "       ❌ Message de session expirée absent\n";
        $allTestsPassed = false;
    }
    
    // Test 1.6: Check for 422 error handling (validation error)
    echo "\n   1.6. Vérification de la gestion de l'erreur 422 (validation)...\n";
    if (strpos($content, "response.status === 422") !== false) {
        echo "       ✅ Gestion de l'erreur 422 présente\n";
    } else {
        echo "       ❌ Gestion de l'erreur 422 manquante\n";
        $allTestsPassed = false;
    }
    
    // Test 1.7: Check for response.ok validation
    echo "\n   1.7. Vérification de la validation response.ok...\n";
    if (strpos($content, "response.ok && data.success") !== false) {
        echo "       ✅ Validation response.ok présente\n";
    } else {
        echo "       ❌ Validation response.ok manquante\n";
        $allTestsPassed = false;
    }
    
    // Test 1.8: Verify old hardcoded CSRF token is removed
    echo "\n   1.8. Vérification que l'ancien token CSRF hardcodé est supprimé...\n";
    if (strpos($content, "'X-CSRF-TOKEN': '{{ csrf_token() }}'") === false) {
        echo "       ✅ Ancien token CSRF hardcodé supprimé\n";
    } else {
        echo "       ⚠️  Ancien token CSRF hardcodé encore présent (peut causer des problèmes)\n";
        $allTestsPassed = false;
    }
    
} else {
    echo "   ❌ Fichier n'existe pas: $widgetPath\n";
    $allTestsPassed = false;
}

// Test 2: Verify dashboard has CSRF meta tag
echo "\n2. Vérification de la meta tag CSRF dans le dashboard...\n";
$dashboardPath = resource_path('views/dashboard/index.blade.php');
if (File::exists($dashboardPath)) {
    echo "   ✅ Fichier dashboard existe: $dashboardPath\n";
    
    $content = File::get($dashboardPath);
    
    if (strpos($content, '<meta name="csrf-token" content="{{ csrf_token() }}">') !== false) {
        echo "   ✅ Meta tag CSRF présente dans le dashboard\n";
    } else {
        echo "   ❌ Meta tag CSRF manquante dans le dashboard\n";
        $allTestsPassed = false;
    }
} else {
    echo "   ❌ Fichier dashboard n'existe pas: $dashboardPath\n";
    $allTestsPassed = false;
}

// Test 3: Verify ChatController exists and handles attachments
echo "\n3. Vérification du ChatController...\n";
$controllerPath = app_path('Http/Controllers/ChatController.php');
if (File::exists($controllerPath)) {
    echo "   ✅ ChatController existe: $controllerPath\n";
    
    $content = File::get($controllerPath);
    
    // Check for attachment handling
    if (strpos($content, "hasFile('attachment')") !== false) {
        echo "   ✅ Gestion des pièces jointes présente\n";
    } else {
        echo "   ❌ Gestion des pièces jointes manquante\n";
        $allTestsPassed = false;
    }
    
    // Check for file validation
    if (strpos($content, "'attachment' => 'nullable|file") !== false) {
        echo "   ✅ Validation des fichiers présente\n";
    } else {
        echo "   ❌ Validation des fichiers manquante\n";
        $allTestsPassed = false;
    }
} else {
    echo "   ❌ ChatController n'existe pas: $controllerPath\n";
    $allTestsPassed = false;
}

// Test 4: Verify routes are protected by CSRF
echo "\n4. Vérification de la protection CSRF des routes...\n";
$routesPath = base_path('routes/web.php');
if (File::exists($routesPath)) {
    echo "   ✅ Fichier routes existe: $routesPath\n";
    
    $content = File::get($routesPath);
    
    // Check if chat routes are under auth middleware (which includes CSRF)
    if (strpos($content, "Route::middleware(['auth'])->group") !== false &&
        strpos($content, "Route::prefix('chat')") !== false) {
        echo "   ✅ Routes chat protégées par middleware auth (inclut CSRF)\n";
    } else {
        echo "   ⚠️  Configuration des routes chat à vérifier\n";
    }
} else {
    echo "   ❌ Fichier routes n'existe pas: $routesPath\n";
    $allTestsPassed = false;
}

// Test 5: Verify documentation exists
echo "\n5. Vérification de la documentation...\n";
$docPath = base_path('CHAT_ATTACHMENT_CSRF_FIX.md');
if (File::exists($docPath)) {
    echo "   ✅ Documentation du fix existe: $docPath\n";
} else {
    echo "   ⚠️  Documentation du fix manquante (recommandé mais non critique)\n";
}

// Final summary
echo "\n=================================================\n";
if ($allTestsPassed) {
    echo "✅ TOUS LES TESTS SONT PASSÉS!\n";
    echo "=================================================\n";
    echo "\nLe fix CSRF pour les pièces jointes du chat est correctement implémenté.\n";
    echo "\nPour tester manuellement:\n";
    echo "1. Connectez-vous en tant qu'utilisateur\n";
    echo "2. Ouvrez le dashboard\n";
    echo "3. Cliquez sur le widget de chat\n";
    echo "4. Essayez d'envoyer un message avec une pièce jointe\n";
    echo "5. Vérifiez que le message est envoyé sans erreur CSRF\n";
} else {
    echo "❌ CERTAINS TESTS ONT ÉCHOUÉ\n";
    echo "=================================================\n";
    echo "\nVeuillez vérifier les erreurs ci-dessus et corriger les problèmes.\n";
}
echo "\n";
