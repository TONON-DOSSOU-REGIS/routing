<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TransferActivationCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_defined_code_is_required_before_transfer_starts(): void
    {
        $user = $this->clientWithCode('482901');
        $this->actingAs($user);
        $payload = $this->transferPayload();

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + ['activation_code' => '000000'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 0);

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + ['activation_code' => '482901'])
            ->assertOk()
            ->assertJsonStructure(['tx_id']);

        $transaction = Transaction::firstOrFail();
        $this->assertSame('pending', $transaction->status);
        $this->assertNull($transaction->activation_code);
        $this->assertNull($user->fresh()->activation_code);

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + ['activation_code' => '482901'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 1);
        $this->assertFalse(Route::has('transactions.activation-code'));
    }

    public function test_transfer_is_blocked_when_admin_has_not_configured_a_code(): void
    {
        $user = $this->clientWithCode();

        $this->actingAs($user)
            ->postJson(route('transactions.start', ['locale' => 'fr']), $this->transferPayload() + [
                'activation_code' => '123456',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_legacy_plaintext_code_is_never_accepted(): void
    {
        $user = $this->clientWithCode();
        $user->forceFill(['activation_code' => '123456'])->save();

        $this->actingAs($user)
            ->postJson(route('transactions.start', ['locale' => 'fr']), $this->transferPayload() + [
                'activation_code' => '123456',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_one_clients_code_cannot_authorize_another_clients_transfer(): void
    {
        $firstClient = $this->clientWithCode('111111');
        $this->clientWithCode('222222');

        $this->actingAs($firstClient)
            ->postJson(route('transactions.start', ['locale' => 'fr']), $this->transferPayload() + [
                'activation_code' => '222222',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_new_code_cannot_start_a_second_transfer_while_one_is_pending(): void
    {
        $user = $this->clientWithCode('111111');
        $this->actingAs($user);
        $payload = $this->transferPayload();

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + [
            'activation_code' => '111111',
        ])->assertOk();

        $user->forceFill(['activation_code' => Hash::make('222222')])->save();

        $this->postJson(route('transfer.start', ['locale' => 'fr']), $payload + [
            'activation_code' => '222222',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 1);
        $this->assertTrue(Hash::check('222222', (string) $user->fresh()->activation_code));
    }

    public function test_five_wrong_codes_lock_further_attempts_for_fifteen_minutes(): void
    {
        $user = $this->clientWithCode('654321');
        $this->actingAs($user);
        $payload = $this->transferPayload();

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $routeName = $attempt % 2 === 0 ? 'transfer.start' : 'transactions.start';
            $this->postJson(route($routeName, ['locale' => 'fr']), $payload + [
                'activation_code' => '000000',
            ])->assertUnprocessable();
        }

        $this->assertTrue(RateLimiter::tooManyAttempts('transfer-activation:'.$user->id, 5));

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + [
            'activation_code' => '654321',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_formatted_iban_and_lowercase_bic_are_normalized_when_starting_transfer(): void
    {
        $user = $this->clientWithCode('920184');
        $payload = $this->transferPayload();
        $payload['recipient_iban'] = 'fr76 3000 6000 0112 3456 7890 189';
        $payload['recipient_bic'] = 'agrifrpp';
        $payload['activation_code'] = '920184';

        $this->actingAs($user)
            ->postJson(route('transactions.start', ['locale' => 'fr']), $payload)
            ->assertOk();

        $this->assertDatabaseHas('transactions', [
            'recipient_iban' => 'FR7630006000011234567890189',
            'recipient_bic' => 'AGRIFRPP',
        ]);
    }

    public function test_client_page_uses_the_admin_code_without_an_email_request(): void
    {
        $user = $this->clientWithCode('482901');

        $this->actingAs($user)
            ->get(route('transfer.create', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('name="activation_code"', false)
            ->assertSee('pattern="[0-9]{6}"', false)
            ->assertDontSee('transactions/activation-code', false)
            ->assertDontSee(__('transactions.send_activation_code'));
    }

    public function test_client_cannot_define_a_code_through_admin_routes(): void
    {
        $client = $this->clientWithCode('123456');
        $target = User::factory()->create();

        $this->actingAs($client)
            ->putJson(route('admin.users.update', ['locale' => 'fr', 'user' => $target]), [
                'activation_code' => '999999',
            ])
            ->assertForbidden();

        $this->assertNull($target->fresh()->activation_code);
    }

    private function clientWithCode(?string $code = null): User
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1250,
            'activation_code' => null,
            'two_factor_enabled' => false,
        ]);

        if ($code !== null) {
            $user->forceFill(['activation_code' => Hash::make($code)])->save();
        }

        RateLimiter::clear('transfer-activation:'.$user->id);

        return $user;
    }

    private function transferPayload(): array
    {
        return [
            'recipient_name' => 'Jean Dupont',
            'recipient_iban' => 'FR7630006000011234567890189',
            'recipient_bic' => 'AGRIFRPP',
            'bank_name' => 'Banque bénéficiaire',
            'reason' => 'Facture 2026',
        ];
    }
}
