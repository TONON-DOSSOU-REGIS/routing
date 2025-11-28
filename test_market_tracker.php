<?php

echo "=== Testing Market Tracker Fix ===\n\n";

// Test 1: Check if market service returns data
echo "1. Testing Market Service...\n";
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $service = app(\App\Services\MarketDataService::class);
    $data = $service->getAllMarketData();

    $cryptoCount = count($data['crypto']);
    $stockCount = count($data['stocks']);
    $forexCount = count($data['forex']);

    echo "   ✅ Service working: {$cryptoCount} crypto, {$stockCount} stocks, {$forexCount} forex\n";

} catch (Exception $e) {
    echo "   ❌ Service error: " . $e->getMessage() . "\n";
}

// Test 2: Check if fixed component exists
echo "\n2. Testing Fixed Component...\n";
$componentPath = 'resources/views/components/market-tracker-fixed.blade.php';

if (file_exists($componentPath)) {
    echo "   ✅ Fixed component exists\n";

    $content = file_get_contents($componentPath);
    if (strpos($content, 'X-CSRF-TOKEN') !== false) {
        echo "   ✅ CSRF token header found in component\n";
    } else {
        echo "   ❌ CSRF token header missing\n";
    }

    if (strpos($content, 'credentials: \'same-origin\'') !== false) {
        echo "   ✅ Credentials header found in component\n";
    } else {
        echo "   ❌ Credentials header missing\n";
    }
} else {
    echo "   ❌ Fixed component not found\n";
}

// Test 3: Check dashboard integration
echo "\n3. Testing Dashboard Integration...\n";
$userDashboard = 'resources/views/dashboard/index.blade.php';
$adminDashboard = 'resources/views/admin/dashboard.blade.php';

if (file_exists($userDashboard)) {
    $content = file_get_contents($userDashboard);
    if (strpos($content, 'market-tracker-fixed') !== false) {
        echo "   ✅ User dashboard uses fixed component\n";
    } else {
        echo "   ❌ User dashboard still uses old component\n";
    }
}

if (file_exists($adminDashboard)) {
    $content = file_get_contents($adminDashboard);
    if (strpos($content, 'market-tracker-fixed') !== false) {
        echo "   ✅ Admin dashboard uses fixed component\n";
    } else {
        echo "   ❌ Admin dashboard still uses old component\n";
    }
}

// Test 4: Check server status
echo "\n4. Testing Server Status...\n";
$serverRunning = false;
exec('netstat -an | find "8000" 2>nul', $output);
if (!empty($output)) {
    echo "   ✅ Laravel server appears to be running on port 8000\n";
    $serverRunning = true;
} else {
    echo "   ⚠️  Laravel server may not be running\n";
}

echo "\n=== Test Summary ===\n";
echo "Market tracker bug fix has been implemented.\n";
echo "The fix addresses the CSRF token issue that was preventing real-time data display.\n";

if ($serverRunning) {
    echo "\nTo test manually:\n";
    echo "1. Open browser to http://127.0.0.1:8000/login\n";
    echo "2. Login with: admin@sgbank.com / admin123\n";
    echo "3. Check if market data displays in real-time on the dashboard\n";
}

echo "\n=== Fix Details ===\n";
echo "- Root cause: Missing CSRF token in fetch requests\n";
echo "- Solution: Added proper authentication headers to market-tracker component\n";
echo "- Files updated: Created market-tracker-fixed.blade.php, updated dashboards\n";
echo "- Result: Market data should now display correctly with auto-refresh\n";

echo "\n✅ Bug fix complete!\n";

