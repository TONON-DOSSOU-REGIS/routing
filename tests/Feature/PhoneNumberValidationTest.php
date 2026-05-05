<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;

class PhoneNumberValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_normalizes_a_valid_international_phone_number(): void
    {
        $payload = $this->validRegistrationPayload([
            'email' => 'new-client@example.com',
            'id_number' => 'REGPHONE01',
            'phone' => '+33 6 12 34 56 78',
        ]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('register', ['locale' => 'fr']), $payload);

        $response->assertRedirect(route('pending-approval', ['locale' => 'fr']));

        $this->assertDatabaseHas('users', [
            'email' => 'new-client@example.com',
            'phone' => '+33612345678',
            'status' => 'pending',
        ]);
    }

    public function test_public_registration_rejects_a_local_phone_number_without_country_prefix(): void
    {
        $payload = $this->validRegistrationPayload([
            'email' => 'bad-phone@example.com',
            'id_number' => 'REGPHONE02',
            'phone' => '0612345678',
        ]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->from(route('register', ['locale' => 'fr']))
            ->post(route('register', ['locale' => 'fr']), $payload);

        $response->assertRedirect(route('register', ['locale' => 'fr']));
        $response->assertSessionHasErrors(['phone']);

        $this->assertDatabaseMissing('users', [
            'email' => 'bad-phone@example.com',
        ]);
    }

    public function test_admin_user_creation_normalizes_a_valid_international_phone_number(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->withoutMiddleware([
                \App\Http\Middleware\IsAdmin::class,
                \App\Http\Middleware\EnsureTwoFactorVerified::class,
                VerifyCsrfToken::class,
            ])
            ->actingAs($admin)
            ->post(route('admin.users.store', ['locale' => 'fr']), [
                'first_name' => 'Admin',
                'last_name' => 'Created',
                'email' => 'admin-created@example.com',
                'password' => 'StrongPass1!',
                'password_confirmation' => 'StrongPass1!',
                'phone' => '+33 6 55 44 33 22',
                'role' => 'user',
                'ville' => 'Paris',
                'pays' => 'France',
                'date_naissance' => '1992-04-10',
                'type_piece' => 'Passeport',
                'numero_piece' => 'ADMINPHONE01',
            ]);

        $response->assertRedirect(route('admin.users', ['locale' => 'fr']));

        $this->assertDatabaseHas('users', [
            'email' => 'admin-created@example.com',
            'phone' => '+33655443322',
        ]);
    }

    public function test_admin_user_update_normalizes_a_valid_international_phone_number(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'email' => 'existing-user@example.com',
            'phone' => '+33600000000',
        ]);

        $response = $this->withoutMiddleware([
                \App\Http\Middleware\IsAdmin::class,
                \App\Http\Middleware\EnsureTwoFactorVerified::class,
                VerifyCsrfToken::class,
            ])
            ->actingAs($admin)
            ->put(route('admin.users.update', ['locale' => 'fr', 'user' => $user]), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => '+1 234 567 8901',
                'role' => $user->role,
                'balance' => $user->balance,
                'status' => $user->status,
            ]);

        $response->assertRedirect(route('admin.users', ['locale' => 'fr']));

        $user->refresh();
        $this->assertSame('+12345678901', $user->phone);
    }

    private function validRegistrationPayload(array $overrides = []): array
    {
        return array_merge([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'phone' => '+33612345678',
            'address' => '12 rue Victor Hugo',
            'country' => 'France',
            'city' => 'Paris',
            'date_of_birth' => '1990-05-10',
            'id_type' => 'Passport',
            'id_number' => 'REGPHONE00',
            'iban' => 'FR7612345678901234567890123',
            'password' => 'StrongPass1!',
            'password_confirmation' => 'StrongPass1!',
            'terms' => '1',
        ], $overrides);
    }
}
