<?php

namespace Tests\Feature;

use App\Mail\AdminTransferActivityMail;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminTransferActivityMailTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'email' => 'admin@zuiderbank.com',
        ]);
    }

    private function client(float $balance = 5000): User
    {
        return User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'two_factor_enabled' => false,
            'balance' => $balance,
            'activation_code' => Hash::make('482901'),
        ]);
    }

    public function test_admin_receives_an_email_when_a_transfer_starts(): void
    {
        Mail::fake();
        $this->admin();
        $client = $this->client();

        $payload = [
            'recipient_name' => 'Jean Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'recipient_bic' => 'BNPAFRPP',
            'bank_name' => 'BNP Paribas',
            'reason' => 'Test transfer',
        ];

        $this->actingAs($client)
            ->postJson(route('transactions.start', ['locale' => 'fr']), $payload + [
                'activation_code' => '482901',
            ])
            ->assertOk();

        Mail::assertQueued(AdminTransferActivityMail::class, function (AdminTransferActivityMail $mail) use ($client) {
            return $mail->stage === AdminTransferActivityMail::STAGE_STARTED
                && $mail->client->is($client)
                && $mail->hasTo('admin@zuiderbank.com');
        });
    }

    public function test_admin_receives_an_email_when_a_transfer_is_put_on_hold(): void
    {
        Mail::fake();
        $this->admin();
        $client = $this->client();

        Setting::create([
            'stop_percentage' => 40,
            'stop_message' => 'Vérification de conformité en cours.',
            'is_global' => true,
            'target_user_id' => null,
        ]);

        $transaction = Transaction::create([
            'user_id' => $client->id,
            'amount' => 1200,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 39,
            'recipient_name' => 'Jean Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'bank_name' => 'BNP Paribas',
        ]);

        $this->actingAs($client)
            ->postJson(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transaction->id])
            ->assertOk()
            ->assertJsonPath('status', 'on_hold');

        Mail::assertQueued(AdminTransferActivityMail::class, function (AdminTransferActivityMail $mail) {
            return $mail->stage === AdminTransferActivityMail::STAGE_ON_HOLD
                && $mail->holdMessage === 'Vérification de conformité en cours.';
        });
    }

    public function test_admin_receives_a_single_email_when_a_transfer_completes(): void
    {
        Mail::fake();
        $this->admin();
        $client = $this->client();

        $transaction = Transaction::create([
            'user_id' => $client->id,
            'amount' => 800,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'recipient_name' => 'Jean Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'bank_name' => 'BNP Paribas',
        ]);

        $this->actingAs($client)
            ->postJson(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transaction->id])
            ->assertOk()
            ->assertJsonPath('progress', 100);

        Mail::assertQueued(AdminTransferActivityMail::class, fn (AdminTransferActivityMail $mail) => $mail->stage === AdminTransferActivityMail::STAGE_COMPLETED);

        // Polling again must not re-send the completion email.
        $this->actingAs($client)
            ->postJson(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transaction->id])
            ->assertOk();

        $completedCount = Mail::queued(AdminTransferActivityMail::class)
            ->filter(fn ($mail) => $mail->stage === AdminTransferActivityMail::STAGE_COMPLETED)
            ->count();

        $this->assertSame(1, $completedCount, 'Completion email must be queued exactly once.');
    }

    public function test_admin_activity_email_is_not_sent_for_admin_initiated_transfers(): void
    {
        Mail::fake();
        $admin = $this->admin();

        $transaction = Transaction::create([
            'user_id' => $admin->id,
            'amount' => 500,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'recipient_name' => 'Jean Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'bank_name' => 'BNP Paribas',
        ]);

        $this->actingAs($admin)
            ->withSession(['2fa_passed' => true])
            ->postJson(route('transactions.progress', ['locale' => 'fr']), ['tx_id' => $transaction->id]);

        Mail::assertNotQueued(AdminTransferActivityMail::class);
    }
}
