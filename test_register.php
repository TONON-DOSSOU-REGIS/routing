<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Testing user registration...\n";

// Test data matching the form
$testData = [
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => 'test@example.com',
    'phone' => '+33123456789',
    'address' => '123 Test Street',
    'country' => 'France',
    'city' => 'Paris',
    'date_of_birth' => '1990-01-01',
    'id_type' => 'CNI',
    'id_number' => 'TEST123456',
    'iban' => 'FR7612345678901234567890123',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'terms' => '1'
];

try {
    // Create user using the same logic as RegisterController
    $user = User::create([
        'first_name' => $testData['first_name'],
        'last_name' => $testData['last_name'],
        'email' => $testData['email'],
        'phone' => $testData['phone'],
        'address' => $testData['address'],
        'country' => $testData['country'],
        'city' => $testData['city'],
        'date_of_birth' => $testData['date_of_birth'],
        'id_type' => $testData['id_type'],
        'id_number' => $testData['id_number'],
        'iban' => $testData['iban'],
        'role' => 'user',
        'balance' => 0.00,
        'default_currency' => 'EUR',
        'status' => 'pending',
        'password' => Hash::make($testData['password']),
    ]);

    echo "✅ User created successfully!\n";
    echo "User ID: " . $user->id . "\n";
    echo "Name: " . $user->first_name . " " . $user->last_name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Status: " . $user->status . "\n";

} catch (Exception $e) {
    echo "❌ Error creating user: " . $e->getMessage() . "\n";
}
