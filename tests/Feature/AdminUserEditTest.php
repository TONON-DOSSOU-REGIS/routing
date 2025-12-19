<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can update user details', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'balance' => 100.00,
        'activation_code' => 'old_code'
    ]);

    $response = $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->put(route('admin.users.update', $user), [
            '_token' => 'test',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone' => '+1234567890',
            'role' => 'user',
            'adresse' => '123 New Street',
            'iban' => 'FR7612345678901234567890123',
            'bic' => 'BNPAFRPP',
            'activation_code' => 'new_code',
            'balance' => 200.00,
            'status' => 'active',
        ]);

    $response->assertRedirect(localized_route('admin.users'));
    $response->assertSessionHas('status', 'Utilisateur mis à jour avec succès.');

    $user->refresh();
    expect($user->first_name)->toBe('Jane');
    expect($user->last_name)->toBe('Smith');
    expect($user->email)->toBe('jane@example.com');
    expect($user->phone)->toBe('+1234567890');
    expect($user->role)->toBe('user');
    expect($user->address)->toBe('123 New Street');
    expect($user->iban)->toBe('FR7612345678901234567890123');
    expect($user->bic)->toBe('BNPAFRPP');
    expect($user->activation_code)->toBe('new_code');
    expect($user->balance)->toBe('200.00');
    expect($user->status)->toBe('active');
});

test('admin can update and create credit card info with user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    $response = $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->put(route('admin.users.update', $user), [
            '_token' => 'test',
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->role,
            'balance' => $user->balance,
            'status' => $user->status,
            'card_holder_name' => 'John Cardholder',
            'card_number' => '4111111111111111',
            'card_type' => 'Visa',
            'expiry_date' => now()->addYear()->format('Y-m-d'),
        ]);

    $response->assertRedirect(localized_route('admin.users'));
    $response->assertSessionHas('status', 'Utilisateur mis à jour avec succès.');

    $user->refresh();
    $creditCard = $user->creditCard;
    expect($creditCard)->not->toBeNull();
    expect($creditCard->card_holder_name)->toBe('John Cardholder');
    expect($creditCard->card_number)->toBe('4111111111111111');
    expect($creditCard->card_type)->toBe('Visa');
    expect($creditCard->expiry_date->format('Y-m-d'))->toBe(now()->addYear()->format('Y-m-d'));
});

test('admin can delete credit card info', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $user->creditCard()->create([
        'card_holder_name' => 'John Cardholder',
        'card_number' => '4111111111111111',
        'card_type' => 'Visa',
        'expiry_date' => now()->addYear(),
    ]);

    $response = $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->put(route('admin.users.update', $user), [
            '_token' => 'test',
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->role,
            'balance' => $user->balance,
            'status' => $user->status,
            // All credit card fields empty to trigger deletion
            'card_holder_name' => '',
            'card_number' => '',
            'card_type' => '',
            'expiry_date' => '',
        ]);

    $response->assertRedirect(localized_route('admin.users'));
    $response->assertSessionHas('status', 'Utilisateur mis à jour avec succès.');

    $user->refresh();
    expect($user->creditCard)->toBeNull();
});

test('admin can reset user password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['email' => 'user@example.com']);

    $response = $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->patch(route('admin.users.reset-password', $user), [
            '_token' => 'test',
        ]);

    $response->assertRedirect(localized_route('admin.users'));
    $response->assertSessionHas('status', 'Mot de passe réinitialisé avec succès. Un email a été envoyé à l\'utilisateur.');

    // Check that password was changed
    $user->refresh();
    expect($user->password)->not->toBeNull();
});

test('password reset and user update are independent', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'first_name' => 'Original',
        'email' => 'original@example.com'
    ]);

    // First, update user details
    $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->put(route('admin.users.update', $user), [
            '_token' => 'test',
            'first_name' => 'Updated',
            'last_name' => $user->last_name,
            'email' => 'updated@example.com',
            'role' => $user->role,
            'balance' => $user->balance,
            'status' => $user->status,
        ]);

    $user->refresh();
    expect($user->first_name)->toBe('Updated');
    expect($user->email)->toBe('updated@example.com');

    // Then reset password - should not affect the updated details
    $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->patch(route('admin.users.reset-password', $user), [
            '_token' => 'test',
        ]);

    $user->refresh();
    expect($user->first_name)->toBe('Updated'); // Should remain updated
    expect($user->email)->toBe('updated@example.com'); // Should remain updated
});

test('user update validation works', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['email' => 'user@example.com']);

    $response = $this->actingAs($admin)
        ->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->startSession()
        ->withSession(['_token' => 'test'])
        ->put(route('admin.users.update', $user), [
            '_token' => 'test',
            'first_name' => '', // Required field empty
            'last_name' => $user->last_name,
            'email' => 'invalid-email', // Invalid email
            'role' => $user->role,
            'balance' => $user->balance,
            'status' => $user->status,
        ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['first_name', 'email']);
});

test('admin can edit user page loads correctly', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'activation_code' => 'test_code'
    ]);

    $response = $this->withoutMiddleware(\App\Http\Middleware\IsAdmin::class)
        ->actingAs($admin)
        ->startSession()
        ->get(route('admin.users.edit', $user));

$response->assertStatus(200);
file_put_contents('response_dump.html', $response->getContent());
$content = html_entity_decode($response->getContent());
$this->assertStringContainsString("Modifier l'utilisateur", $content);
    $response->assertSee('Test');
    $response->assertSee('User');
    $response->assertSee('test@example.com');
    $response->assertSee('test_code');
});

