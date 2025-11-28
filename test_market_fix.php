<?php

echo "🧪 MARKET TRACKER FIX VERIFICATION TEST\n";
echo "======================================\n\n";

// Test 1: Check if fixed component exists
echo "1. Checking if fixed component exists...\n";
$componentPath = __DIR__ . '/resources/views/components/market-tracker-fixed.blade.php';
if (file_exists($componentPath)) {
    echo "✅ Fixed component file exists: $componentPath\n";

    // Check if it contains CSRF token
    $content = file_get_contents($componentPath);
    if (strpos($content, 'X-CSRF-TOKEN') !== false) {
        echo "✅ Component contains CSRF token header\n";
    } else {
        echo "❌ Component missing CSRF token header\n";
    }

    if (strpos($content, 'credentials: \'same-origin\'') !== false) {
        echo "✅ Component contains credentials header\n";
    } else {
        echo "❌ Component missing credentials header\n";
    }
} else {
    echo "❌ Fixed component file does not exist\n";
}

echo "\n";

// Test 2: Check if dashboards are using fixed component
echo "2. Checking dashboard integrations...\n";

$userDashboard = __DIR__ . '/resources/views/dashboard/index.blade.php';
$adminDashboard = __DIR__ . '/resources/views/admin/dashboard.blade.php';

if (file_exists($userDashboard)) {
    $content = file_get_contents($userDashboard);
    if (strpos($content, 'components.market-tracker-fixed') !== false) {
        echo "✅ User dashboard uses fixed component\n";
    } else {
        echo "❌ User dashboard not using fixed component\n";
    }
} else {
    echo "❌ User dashboard file not found\n";
}

if (file_exists($adminDashboard)) {
    $content = file_get_contents($adminDashboard);
    if (strpos($content, 'components.market-tracker-fixed') !== false) {
        echo "✅ Admin dashboard uses fixed component\n";
    } else {
        echo "❌ Admin dashboard not using fixed component\n";
    }
} else {
    echo "❌ Admin dashboard file not found\n";
}

echo "\n";

// Test 3: Check if market API route exists
echo "3. Checking market API route...\n";
$routesFile = __DIR__ . '/routes/web.php';
if (file_exists($routesFile)) {
    $content = file_get_contents($routesFile);
    if (strpos($content, 'api.market.all') !== false || strpos($content, "Route::get('/all'") !== false) {
        echo "✅ Market API route exists in web.php\n";
    } else {
        echo "❌ Market API route not found in web.php\n";
    }
} else {
    echo "❌ Routes file not found\n";
}

echo "\n";

// Test 4: Check if MarketDataController exists
echo "4. Checking MarketDataController...\n";
$controllerPath = __DIR__ . '/app/Http/Controllers/MarketDataController.php';
if (file_exists($controllerPath)) {
    echo "✅ MarketDataController exists\n";
    $content = file_get_contents($controllerPath);
    if (strpos($content, 'function index()') !== false) {
        echo "✅ Controller has 'index' method (used for /api/market/all route)\n";
    } else {
        echo "❌ Controller missing 'index' method\n";
    }
} else {
    echo "❌ MarketDataController not found\n";
}

echo "\n";

// Test 5: Check if MarketDataService exists
echo "5. Checking MarketDataService...\n";
$servicePath = __DIR__ . '/app/Services/MarketDataService.php';
if (file_exists($servicePath)) {
    echo "✅ MarketDataService exists\n";
    $content = file_get_contents($servicePath);
    if (strpos($content, 'getAllMarketData') !== false) {
        echo "✅ Service has 'getAllMarketData' method\n";
    } else {
        echo "❌ Service missing 'getAllMarketData' method\n";
    }
} else {
    echo "❌ MarketDataService not found\n";
}

echo "\n";

// Test 6: Check if server is running (basic connectivity test)
echo "6. Testing server connectivity...\n";
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Accept: application/json',
        'timeout' => 5
    ]
]);

$apiUrl = 'http://127.0.0.1:8000/api/market/all';
$response = @file_get_contents($apiUrl, false, $context);

if ($response !== false) {
    $data = json_decode($response, true);
    if ($data && isset($data['crypto']) && isset($data['stocks']) && isset($data['forex'])) {
        echo "✅ Market API is responding correctly\n";
        echo "   - Crypto items: " . count($data['crypto']) . "\n";
        echo "   - Stock items: " . count($data['stocks']) . "\n";
        echo "   - Forex items: " . count($data['forex']) . "\n";
    } else {
        echo "❌ Market API response format incorrect\n";
    }
} else {
    echo "❌ Cannot connect to market API (server may not be running)\n";
    echo "   Make sure to run: php artisan serve --host=127.0.0.1 --port=8000\n";
}

echo "\n";
echo "🎯 MANUAL TESTING INSTRUCTIONS:\n";
echo "================================\n";
echo "1. Open browser to: http://127.0.0.1:8000/login\n";
echo "2. Login with: admin@sgbank.com / admin123\n";
echo "3. Navigate to dashboard\n";
echo "4. Check if market data displays without errors\n";
echo "5. Try switching between 'Tous', 'Crypto', 'Actions', 'Forex' tabs\n";
echo "6. Verify data auto-refreshes every 30 seconds\n";

echo "\n";
echo "✅ TEST COMPLETE - Market tracker fix verification finished!\n";

?>

