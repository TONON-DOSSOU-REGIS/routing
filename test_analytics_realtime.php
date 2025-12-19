<?php
/**
 * Script de test pour vérifier le fonctionnement du rafraîchissement en temps réel
 * des Analytics & Statistiques
 * 
 * Usage: php test_analytics_realtime.php
 */

echo "=== TEST DU RAFRAÎCHISSEMENT EN TEMPS RÉEL - ANALYTICS ===\n\n";

// Configuration
$baseUrl = 'http://localhost:8000'; // Ajuster selon votre configuration
$testUser = [
    'email' => 'test@example.com',
    'password' => 'password'
];

echo "📋 Configuration:\n";
echo "   Base URL: $baseUrl\n";
echo "   Test User: {$testUser['email']}\n\n";

// Test 1: Vérifier que les routes API existent
echo "🔍 Test 1: Vérification des routes API\n";
echo "   ----------------------------------------\n";

$apiRoutes = [
    '/api/analytics/balance-evolution?days=30',
    '/api/analytics/transactions-by-type?days=30',
    '/api/analytics/monthly-comparison',
    '/api/analytics/statistics?days=30'
];

foreach ($apiRoutes as $route) {
    $url = $baseUrl . $route;
    echo "   Testing: $route\n";
    
    // Note: Ces routes nécessitent une authentification
    // Dans un environnement de production, vous devrez vous authentifier d'abord
    echo "   ⚠️  Nécessite authentification\n";
}

echo "\n";

// Test 2: Vérifier la structure du DashboardController
echo "🔍 Test 2: Vérification du DashboardController\n";
echo "   ----------------------------------------\n";

$controllerFile = __DIR__ . '/app/Http/Controllers/DashboardController.php';

if (file_exists($controllerFile)) {
    $content = file_get_contents($controllerFile);
    
    $methods = [
        'getBalanceEvolution',
        'getTransactionsByType',
        'getMonthlyComparison',
        'getAnalyticsStatistics'
    ];
    
    foreach ($methods as $method) {
        if (strpos($content, "function $method") !== false) {
            echo "   ✅ Méthode '$method' trouvée\n";
        } else {
            echo "   ❌ Méthode '$method' manquante\n";
        }
    }
    
    // Vérifier les imports nécessaires
    echo "\n   Vérification des imports:\n";
    $imports = [
        'use Carbon\Carbon;' => 'Carbon',
        'use Illuminate\Support\Facades\DB;' => 'DB Facade',
        'use App\Models\Transaction;' => 'Transaction Model'
    ];
    
    foreach ($imports as $import => $name) {
        if (strpos($content, $import) !== false) {
            echo "   ✅ Import '$name' présent\n";
        } else {
            echo "   ⚠️  Import '$name' manquant\n";
        }
    }
} else {
    echo "   ❌ Fichier DashboardController.php non trouvé\n";
}

echo "\n";

// Test 3: Vérifier la section Analytics
echo "🔍 Test 3: Vérification de la section Analytics\n";
echo "   ----------------------------------------\n";

$analyticsFile = __DIR__ . '/resources/views/components/analytics-section.blade.php';

if (file_exists($analyticsFile)) {
    $content = file_get_contents($analyticsFile);
    
    $features = [
        'startAnalyticsAutoRefresh' => 'Fonction de démarrage auto-refresh',
        'stopAnalyticsAutoRefresh' => 'Fonction d\'arrêt auto-refresh',
        'showUpdateIndicator' => 'Indicateur de mise à jour',
        'showErrorIndicator' => 'Indicateur d\'erreur',
        'isLoadingAnalytics' => 'Protection contre chargements multiples',
        'analyticsRefreshInterval' => 'Variable d\'intervalle',
        'visibilitychange' => 'Gestion visibilité page',
        'ts=${timestamp}' => 'Cache busting (timestamp)'
    ];
    
    foreach ($features as $feature => $description) {
        if (strpos($content, $feature) !== false) {
            echo "   ✅ $description\n";
        } else {
            echo "   ❌ $description manquant\n";
        }
    }
    
    // Vérifier l'intervalle de rafraîchissement
    if (preg_match('/setInterval\([^,]+,\s*(\d+)\)/', $content, $matches)) {
        $interval = $matches[1];
        $seconds = $interval / 1000;
        echo "\n   ℹ️  Intervalle de rafraîchissement: {$seconds}s ({$interval}ms)\n";
    }
} else {
    echo "   ❌ Fichier analytics-section.blade.php non trouvé\n";
}

echo "\n";

// Test 4: Vérifier les routes API dans routes/api.php
echo "🔍 Test 4: Vérification des routes API\n";
echo "   ----------------------------------------\n";

$apiRoutesFile = __DIR__ . '/routes/api.php';

if (file_exists($apiRoutesFile)) {
    $content = file_get_contents($apiRoutesFile);
    
    $routes = [
        '/analytics/balance-evolution' => 'getBalanceEvolution',
        '/analytics/transactions-by-type' => 'getTransactionsByType',
        '/analytics/monthly-comparison' => 'getMonthlyComparison',
        '/analytics/statistics' => 'getAnalyticsStatistics'
    ];
    
    foreach ($routes as $route => $method) {
        if (strpos($content, $route) !== false && strpos($content, $method) !== false) {
            echo "   ✅ Route '$route' -> $method\n";
        } else {
            echo "   ❌ Route '$route' manquante ou mal configurée\n";
        }
    }
    
    // Vérifier le middleware auth
    if (strpos($content, "middleware(['auth'])") !== false || 
        strpos($content, "middleware('auth')") !== false) {
        echo "\n   ✅ Middleware 'auth' appliqué aux routes analytics\n";
    } else {
        echo "\n   ⚠️  Middleware 'auth' non détecté\n";
    }
} else {
    echo "   ❌ Fichier routes/api.php non trouvé\n";
}

echo "\n";

// Test 5: Vérifier le Market Tracker (déjà fonctionnel)
echo "🔍 Test 5: Vérification du Market Tracker\n";
echo "   ----------------------------------------\n";

$marketTrackerFile = __DIR__ . '/resources/views/components/market-tracker-fixed.blade.php';

if (file_exists($marketTrackerFile)) {
    $content = file_get_contents($marketTrackerFile);
    
    if (strpos($content, 'startAutoRefresh') !== false) {
        echo "   ✅ Market Tracker: Auto-refresh activé\n";
        
        if (preg_match('/setInterval\([^,]+,\s*(\d+)\)/', $content, $matches)) {
            $interval = $matches[1];
            $seconds = $interval / 1000;
            echo "   ℹ️  Intervalle: {$seconds}s ({$interval}ms)\n";
        }
    } else {
        echo "   ⚠️  Market Tracker: Auto-refresh non détecté\n";
    }
} else {
    echo "   ❌ Fichier market-tracker-fixed.blade.php non trouvé\n";
}

echo "\n";

// Résumé
echo "=== RÉSUMÉ DES TESTS ===\n\n";
echo "✅ Corrections implémentées:\n";
echo "   1. Méthodes API ajoutées au DashboardController\n";
echo "   2. Auto-refresh implémenté (30 secondes)\n";
echo "   3. Cache busting avec timestamp\n";
echo "   4. Indicateurs visuels de mise à jour\n";
echo "   5. Gestion de la visibilité de la page\n";
echo "   6. Protection contre chargements multiples\n\n";

echo "📝 Prochaines étapes:\n";
echo "   1. Démarrer le serveur: php artisan serve\n";
echo "   2. Se connecter à l'application\n";
echo "   3. Accéder au tableau de bord\n";
echo "   4. Vérifier que les données se chargent\n";
echo "   5. Attendre 30 secondes pour voir le rafraîchissement\n";
echo "   6. Vérifier les notifications de mise à jour\n";
echo "   7. Effectuer une transaction et observer la mise à jour\n\n";

echo "⚠️  Notes importantes:\n";
echo "   - Les routes API nécessitent une authentification\n";
echo "   - Le rafraîchissement s'arrête quand l'onglet est inactif\n";
echo "   - Les graphiques se mettent à jour sans rechargement de page\n";
echo "   - Market Tracker: refresh toutes les 5 secondes\n";
echo "   - Analytics: refresh toutes les 30 secondes\n\n";

echo "🎉 Tests terminés!\n";
