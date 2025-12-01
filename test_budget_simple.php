<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\User;
use App\Models\Budget;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    // Create a test user if not exists
    $user = User::first();
    if (!$user) {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }

    // Try to create a budget with a different category or month
    $budget = Budget::create([
        'user_id' => $user->id,
        'category' => 'Transport', // Different category
        'amount' => 300.00,
        'spent' => 100.00,
        'month' => now()->format('Y-m-d'),
        'alert_enabled' => true,
        'alert_threshold' => 75,
    ]);

    echo "Budget created successfully!\n";
    echo "ID: " . $budget->id . "\n";
    echo "Category: " . $budget->category . "\n";
    echo "Amount: $" . $budget->amount . "\n";
    echo "Spent: $" . $budget->spent . "\n";
    echo "Remaining: $" . $budget->remaining . "\n";
    echo "Percentage Used: " . $budget->percentage_used . "%\n";
    echo "Is Over Budget: " . ($budget->is_over_budget ? 'Yes' : 'No') . "\n";
    echo "Should Alert: " . ($budget->should_alert ? 'Yes' : 'No') . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
