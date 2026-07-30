<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware([
        \App\Http\Middleware\IsAdmin::class,
        \App\Http\Middleware\EnsureTwoFactorVerified::class,
        VerifyCsrfToken::class,
    ]);
});

test('admin user creation page only displays essential fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->get(route('admin.users.create', ['locale' => 'fr']));

    $response->assertOk()
        ->assertSee('name="phone"', false)
        ->assertSee('name="pays"', false)
        ->assertSee('name="date_naissance"', false)
        ->assertSee('name="activation_code"', false)
        ->assertSee('pattern="(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{6}"', false)
        ->assertSee('data-password-toggle="password"', false)
        ->assertSee('data-password-toggle="password_confirmation"', false)
        ->assertDontSee('name="profile_photo"', false)
        ->assertDontSee('name="adresse"', false)
        ->assertDontSee('name="type_piece"', false)
        ->assertDontSee('name="iban"', false);
});

test('admin can create a user with only the simplified form fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->post(route('admin.users.store', ['locale' => 'fr']), [
            'first_name' => 'Amina',
            'last_name' => 'Diallo',
            'email' => 'amina.diallo@example.com',
            'password' => 'StrongPass1!',
            'password_confirmation' => 'StrongPass1!',
            'phone' => '+221771234567',
            'role' => 'user',
            'pays' => 'Sénégal',
            'activation_code' => 'a1b2c3',
        ]);

    $response->assertRedirect(route('admin.users', ['locale' => 'fr']));

    $this->assertDatabaseHas('users', [
        'email' => 'amina.diallo@example.com',
        'phone' => '+221771234567',
        'country' => 'Sénégal',
        'date_of_birth' => null,
        'id_type' => null,
        'profile_photo_path' => null,
    ]);

    $user = User::where('email', 'amina.diallo@example.com')->firstOrFail();
    expect($user->activation_code)->not->toBe('A1B2C3');
    expect(Hash::check('A1B2C3', $user->activation_code))->toBeTrue();
    expect($user->toArray())->not->toHaveKey('activation_code');
});

test('admin activation code must combine letters and numbers', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    foreach (['482901', 'ABCDEF', 'A1B2!3'] as $index => $activationCode) {
        $response = $this->actingAs($admin)
            ->post(route('admin.users.store', ['locale' => 'fr']), [
                'first_name' => 'Client',
                'last_name' => 'Test',
                'email' => "client-format-{$index}@example.com",
                'password' => 'StrongPass1!',
                'password_confirmation' => 'StrongPass1!',
                'phone' => '+221771234567',
                'role' => 'user',
                'pays' => 'Sénégal',
                'activation_code' => $activationCode,
            ]);

        $response->assertSessionHasErrors('activation_code');
        $this->assertDatabaseMissing('users', [
            'email' => "client-format-{$index}@example.com",
        ]);
    }
});
