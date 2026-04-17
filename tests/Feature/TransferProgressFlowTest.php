<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferProgressFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    public function test_progress_starts_and_increments_by_one_after_start(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => '1234',
            'two_factor_enabled' => false,
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

    public function test_on_hold_uses_admin_message_and_returns_banking_info(): void
    {
        Setting::create([
            'stop_percentage' => 50,
            'stop_message' => 'Message admin stop 50%',
            'is_global' => true,
            'target_user_id' => null,
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => '1234',
            'two_factor_enabled' => false,
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
        Setting::create([
            'stop_percentage' => 100,
            'stop_message' => 'Doit ignorer ce message',
            'is_global' => true,
            'target_user_id' => null,
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 5000,
            'activation_code' => '1234',
            'two_factor_enabled' => false,
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

    private function validTransferPayload(): array
    {
        return [
            'recipient_name' => 'Jean Dupont',
            'recipient_iban' => 'FR7630006000011234567890189',
            'recipient_bic' => 'AGRIFRPP',
            'bank_name' => 'SG BANK',
            'reason' => 'Test transfer',
            'activation_code' => '1234',
        ];
    }
}
