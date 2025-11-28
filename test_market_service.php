<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Market API Service...\n";

try {
    $service = app(\App\Services\MarketDataService::class);
    $data = $service->getAllMarketData();

    echo "✅ Success!\n";
    echo "Crypto items: " . count($data['crypto']) . "\n";
    echo "Stock items: " . count($data['stocks']) . "\n";
    echo "Forex items: " . count($data['forex']) . "\n";
    echo "Timestamp: " . $data['timestamp'] . "\n";

    // Test a sample crypto item
    if (!empty($data['crypto'])) {
        $sample = $data['crypto'][0];
        echo "\nSample Crypto Data:\n";
        echo "- Symbol: " . ($sample['symbol'] ?? 'N/A') . "\n";
        echo "- Name: " . ($sample['name'] ?? 'N/A') . "\n";
        echo "- Price USD: $" . number_format($sample['price_usd'] ?? 0, 2) . "\n";
        echo "- Change 24h: " . ($sample['change_24h'] ?? 0) . "%\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

