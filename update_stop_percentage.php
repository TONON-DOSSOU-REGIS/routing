<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Setting;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

try {
    // Update all settings to set stop_percentage to 0
    Setting::update(['stop_percentage' => 0]);

    echo "✅ Successfully updated stop_percentage to 0% for all settings.\n";
    echo "Transactions will now complete without interruption.\n";

} catch (Exception $e) {
    echo "❌ Error updating settings: " . $e->getMessage() . "\n";
}
