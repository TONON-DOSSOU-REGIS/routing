<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TransferProgressFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_progress_starts_and_increments_by_one_after_start(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => Hash::make('123456'),
            'two_factor_enabled' => false,
        ]);
        Setting::create([
            'target_user_id' => $user->id,
            'stop_percentage' => 80,
            'stop_message' => 'Arrêt à 80 %',
        ]);

        $this->actingAs($user);

        $startResponse = $this->post(route('transactions.start', ['locale' => 'fr']), $this->validTransferPayload());
        $startResponse->assertOk()->assertJsonStructure(['tx_id']);

        $transactionId = (int) $startResponse->json('tx_id');
        $transaction = Transaction::findOrFail($transactionId);

        $this->assertSame(5000.0, (float) $transaction->amount);
        $this->assertSame(0, (int) $transaction->progress);
        $this->assertSame('pending', $transaction->status);

        $progress1 = $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId]);
        $progress1->assertOk();
        $this->assertSame('pending', $progress1->json('status'));
        $this->assertSame(1, (int) $progress1->json('progress'));

        $progress2 = $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId]);
        $progress2->assertOk();
        $this->assertSame('pending', $progress2->json('status'));
        $this->assertSame(2, (int) $progress2->json('progress'));
    }

    public function test_another_clients_settings_are_never_applied(): void
    {
        $configuredClient = User::factory()->create();
        $currentClient = User::factory()->create();

        Setting::create([
            'target_user_id' => $configuredClient->id,
            'stop_percentage' => 1,
            'stop_message' => 'Réglage réservé à un autre client',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $currentClient->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 0,
        ]);

        $response = $this->actingAs($currentClient)->post(
            route('transactions.progress', ['locale' => 'fr']),
            ['tx_id' => $transaction->id]
        );

        $response->assertOk()->assertJson([
            'status' => 'pending',
            'progress' => 0,
        ]);
        $this->assertNull($response->json('message'));
    }

    public function test_on_hold_uses_admin_message_and_returns_banking_info(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => Hash::make('123456'),
            'two_factor_enabled' => false,
        ]);

        Setting::create([
            'stop_percentage' => 50,
            'stop_message' => 'Message admin stop 50%',
            'target_user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $payload = $this->validTransferPayload();
        $startResponse = $this->post(route('transactions.start', ['locale' => 'fr']), $payload);
        $startResponse->assertOk();

        $transactionId = (int) $startResponse->json('tx_id');
        $lastJson = null;

        for ($i = 0; $i < 70; $i++) {
            $response = $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId]);
            $response->assertOk();
            $lastJson = $response->json();

            if (($lastJson['status'] ?? null) === 'on_hold') {
                break;
            }
        }

        $this->assertIsArray($lastJson);
        $this->assertSame('on_hold', $lastJson['status']);
        $this->assertSame(50, (int) $lastJson['progress']);
        $this->assertSame('Message admin stop 50%', $lastJson['message']);
        $this->assertSame($payload['recipient_name'], $lastJson['recipient_name']);
        $this->assertSame($payload['recipient_iban'], $lastJson['recipient_iban']);
    }

    public function test_stop_percentage_100_results_in_success_not_on_hold(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => Hash::make('123456'),
            'two_factor_enabled' => false,
        ]);

        Setting::create([
            'stop_percentage' => 100,
            'stop_message' => 'Doit ignorer ce message',
            'target_user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $startResponse = $this->post(route('transactions.start', ['locale' => 'fr']), $this->validTransferPayload());
        $startResponse->assertOk();

        $transactionId = (int) $startResponse->json('tx_id');
        Transaction::whereKey($transactionId)->update([
            'progress' => 99,
            'status' => 'pending',
        ]);

        $response = $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId]);
        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
            'progress' => 100,
        ]);
    }

    public function test_new_admin_code_uses_the_updated_absolute_percentage_and_message(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnsureTwoFactorVerified::class);
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => null,
            'two_factor_enabled' => false,
        ]);
        Setting::create([
            'stop_percentage' => 50,
            'stop_message' => 'Ancien message',
            'target_user_id' => $user->id,
        ]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'on_hold',
            'progress' => 50,
            'message' => 'Ancien message',
            'meta' => ['next_stop_progress' => 50],
        ]);

        $this->actingAs($admin)->post(route('admin.settings.activation-code', ['locale' => 'fr']), [
            'target_user_id' => $user->id,
            'stop_percentage' => 75,
            'stop_message' => 'Nouveau message au palier 75%',
            'activation_code' => 'B2C3D4',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('settings', [
            'target_user_id' => $user->id,
            'stop_percentage' => 75,
            'stop_message' => 'Nouveau message au palier 75%',
        ]);

        $this->actingAs($user)->postJson(route('transactions.resume', ['locale' => 'fr']), [
            'tx_id' => $transaction->id,
            'activation_code' => 'B2C3D4',
        ])->assertOk()->assertJson([
            'status' => 'pending',
            'progress' => 50,
            'next_stop_progress' => 75,
        ]);

        $transaction->refresh()->update(['progress' => 74]);
        $this->postJson(route('transactions.progress', ['locale' => 'fr']), [
            'tx_id' => $transaction->id,
        ])->assertOk()->assertJson([
            'status' => 'on_hold',
            'progress' => 75,
            'message' => 'Nouveau message au palier 75%',
        ]);
    }

    public function test_successive_codes_resume_the_same_transfer_from_each_progress_stage(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnsureTwoFactorVerified::class);
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => Hash::make('A1B2C3'),
            'two_factor_enabled' => false,
        ]);
        Setting::create([
            'stop_percentage' => 30,
            'stop_message' => 'Nouveau code requis',
            'target_user_id' => $user->id,
        ]);
        $this->actingAs($user);
        $configureNextCode = function (string $code, int $nextPercentage, string $message) use ($admin, $user): void {
            $this->actingAs($admin)
                ->post(route('admin.settings.activation-code', ['locale' => 'fr']), [
                    'target_user_id' => $user->id,
                    'stop_percentage' => $nextPercentage,
                    'stop_message' => $message,
                    'activation_code' => $code,
                ])
                ->assertRedirect(route('admin.settings', [
                    'locale' => 'fr',
                    'target_user_id' => $user->id,
                ]));

            $this->actingAs($user);
        };

        $payload = $this->validTransferPayload();
        $payload['activation_code'] = 'a1b2c3';
        $startResponse = $this->post(route('transactions.start', ['locale' => 'fr']), $payload);
        $startResponse->assertOk();

        $transactionId = (int) $startResponse->json('tx_id');
        $transaction = Transaction::findOrFail($transactionId);
        $this->assertSame(30, (int) $transaction->meta['next_stop_progress']);
        $this->assertSame(1, (int) $transaction->meta['authorization_count']);

        $transaction->update(['progress' => 29]);
        $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId])
            ->assertOk()
            ->assertJson([
                'status' => 'on_hold',
                'progress' => 30,
                'can_resume' => true,
        ]);
        $this->assertSame(5000.0, (float) $user->fresh()->balance);
        $this->assertNull($user->fresh()->activation_code);

        $this->postJson(route('transactions.resume', ['locale' => 'fr']), [
            'tx_id' => $transactionId,
            'activation_code' => 'B2C3D4',
        ])->assertUnprocessable()->assertJsonValidationErrors('activation_code');

        $configureNextCode('b2c3d4', 60, 'Arrêt intermédiaire à 60 %');
        $this->postJson(route('transactions.resume', ['locale' => 'fr']), [
            'tx_id' => $transactionId,
            'activation_code' => 'Z9Y8X7',
        ])->assertUnprocessable()->assertJsonValidationErrors('activation_code');
        $this->assertSame('on_hold', $transaction->fresh()->status);
        $this->assertTrue(Hash::check('B2C3D4', (string) $user->fresh()->activation_code));

        $this->postJson(route('transactions.resume', ['locale' => 'fr']), [
            'tx_id' => $transactionId,
            'activation_code' => 'b2c3d4',
        ])->assertOk()->assertJson([
            'status' => 'pending',
            'progress' => 30,
            'next_stop_progress' => 60,
        ]);
        $this->assertNull($user->fresh()->activation_code);

        $transaction->refresh()->update(['progress' => 59]);
        $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId])
            ->assertOk()
            ->assertJson([
                'status' => 'on_hold',
                'progress' => 60,
                'message' => 'Arrêt intermédiaire à 60 %',
            ]);

        $configureNextCode('C3D4E5', 90, 'Dernière validation requise à 90 %');
        $this->postJson(route('transactions.resume', ['locale' => 'fr']), [
            'tx_id' => $transactionId,
            'activation_code' => 'C3D4E5',
        ])->assertOk()->assertJson([
            'status' => 'pending',
            'progress' => 60,
            'next_stop_progress' => 90,
        ]);

        $transaction->refresh()->update(['progress' => 89]);
        $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId])
            ->assertOk()
            ->assertJson([
                'status' => 'on_hold',
                'progress' => 90,
                'message' => 'Dernière validation requise à 90 %',
            ]);

        $configureNextCode('D4E5F6', 100, 'Finalisation autorisée');
        $this->postJson(route('transactions.resume', ['locale' => 'fr']), [
            'tx_id' => $transactionId,
            'activation_code' => 'D4E5F6',
        ])->assertOk()->assertJson([
            'status' => 'pending',
            'progress' => 90,
            'next_stop_progress' => 100,
        ]);

        $transaction->refresh()->update(['progress' => 99]);
        $this->post(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transactionId])
            ->assertOk()
            ->assertJson(['status' => 'success', 'progress' => 100]);

        $transaction->refresh();
        $this->assertDatabaseCount('transactions', 1);
        $this->assertSame(0.0, (float) $user->fresh()->balance);
        $this->assertSame(4, (int) $transaction->meta['authorization_count']);
        $this->assertSame([0, 30, 60, 90], collect($transaction->meta['authorization_steps'])->pluck('authorized_progress')->all());
    }

    private function validTransferPayload(): array
    {
        $payload = [
            'recipient_name' => 'Jean Dupont',
            'recipient_iban' => 'FR7630006000011234567890189',
            'recipient_bic' => 'AGRIFRPP',
            'bank_name' => 'SG BANK',
            'reason' => 'Test transfer',
            'activation_code' => '123456',
        ];

        return $payload;
    }
}
