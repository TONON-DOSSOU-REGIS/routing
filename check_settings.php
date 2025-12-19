<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

echo "=== CURRENT SETTINGS ===\n\n";

$settings = Setting::all();

if ($settings->isEmpty()) {
    echo "No settings found in database.\n";
} else {
    foreach ($settings as $setting) {
        echo "ID: {$setting->id}\n";
        echo "Stop Percentage: {$setting->stop_percentage}%\n";
        echo "Stop Message: {$setting->stop_message}\n";
        echo "Target User ID: " . ($setting->target_user_id ?? 'NULL') . "\n";
        echo "Is Global: " . ($setting->is_global ? 'Yes' : 'No') . "\n";
        echo "Created: {$setting->created_at}\n";
        echo "Updated: {$setting->updated_at}\n";
        echo "------------------------\n";
    }
}

echo "\n=== CHECKING FOR USER-SPECIFIC SETTINGS ===\n";

// Check if there are settings for user ID 2 (from the log)
$userSettings = Setting::where('target_user_id', 2)->first();
if ($userSettings) {
    echo "Found settings for user ID 2:\n";
    echo "Stop Percentage: {$userSettings->stop_percentage}%\n";
    echo "Stop Message: {$userSettings->stop_message}\n";
    echo "Is Global: " . ($userSettings->is_global ? 'Yes' : 'No') . "\n";
} else {
    echo "No user-specific settings found for user ID 2.\n";
}

// Check global settings
$globalSettings = Setting::where('is_global', true)->first();
if ($globalSettings) {
    echo "\nGlobal settings found:\n";
    echo "Stop Percentage: {$globalSettings->stop_percentage}%\n";
    echo "Stop Message: {$globalSettings->stop_message}\n";
} else {
    echo "\nNo global settings found.\n";
}
