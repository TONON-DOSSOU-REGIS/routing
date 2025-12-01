<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

try {
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        echo "Admin user found: " . $admin->email . " - Role: " . $admin->role . "\n";
        echo "Is admin: " . ($admin->isAdmin() ? 'Yes' : 'No') . "\n";
    } else {
        echo "No admin user found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
