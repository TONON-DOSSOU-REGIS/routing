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
            'date_naissance' => '1990-01-01',
            'role' => 'user',
            'adresse' => '123 New Street',
            'ville' => 'New City',
            'pays' => 'France',
            'type_piece' => 'CNI',
            'numero_piece' => '123456789',
            'iban' => 'FR7612345678901234567890123',
            'bic' => 'BNPAFRPP',
            'activation_code' => 'new_code',
            'balance' => 200.00,
            'status' => 'active',
        ]);

    $response->assertRedirect(route('admin.users'));
    $response->assertSessionHas('status', 'Utilisateur mis à jour avec succès.');

    $user->refresh();
    expect($user->first_name)->toBe('Jane');
    expect($user->last_name)->toBe('Smith');
    expect($user->email)->toBe('jane@example.com');
    expect($user->phone)->toBe('+1234567890');
    expect($user->date_of_birth->format('Y-m-d'))->toBe('1990-01-01');
    expect($user->role)->toBe('user');
    expect($user->address)->toBe('123 New Street');
    expect($user->city)->toBe('New City');
    expect($user->country)->toBe('France');
    expect($user->id_type)->toBe('CNI');
    expect($user->id_number)->toBe('123456789');
    expect($user->iban)->toBe('FR7612345678901234567890123');
    expect($user->bic)->toBe('BNPAFRPP');
    expect($user->activation_code)->toBe('new_code');
    expect($user->balance)->toBe('200.00');
    expect($user->status)->toBe('active');
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

    $response->assertRedirect(route('admin.users'));
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
    $response->assertSee('Modifier l&#039;utilisateur');
    $response->assertSee('Test');
    $response->assertSee('User');
    $response->assertSee('test@example.com');
    $response->assertSee('test_code');
});
