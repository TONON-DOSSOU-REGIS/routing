<?php

namespace Tests\Feature;

use App\Mail\TransferActivationCodeMail;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TransferActivationCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_code_is_emailed_and_required_before_transfer_starts(): void
    {
        Mail::fake();
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1250,
            'email' => 'client@example.com',
        ]);
        $this->actingAs($user);
        $payload = $this->transferPayload();

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');
        $this->assertDatabaseCount('transactions', 0);

        $this->postJson(route('transactions.activation-code', ['locale' => 'fr']), $payload)
            ->assertOk();

        $sentCode = null;
        $sentMail = null;
        Mail::assertSent(TransferActivationCodeMail::class, function (TransferActivationCodeMail $mail) use (&$sentCode, &$sentMail, $user) {
            $sentCode = $mail->code;
            $sentMail = $mail;

            return $mail->hasTo($user->email);
        });

        $this->assertMatchesRegularExpression('/^\d{6}$/', (string) $sentCode);
        $renderedMail = $sentMail->render();
        $this->assertStringContainsString('Jean Dupont', $renderedMail);
        $this->assertStringContainsString((string) $sentCode, $renderedMail);

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + ['activation_code' => '000000'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');
        $this->assertDatabaseCount('transactions', 0);

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + ['activation_code' => $sentCode])
            ->assertOk()
            ->assertJsonStructure(['tx_id']);

        $transaction = Transaction::firstOrFail();
        $this->assertSame('pending', $transaction->status);
        $this->assertNull($transaction->activation_code);

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $payload + ['activation_code' => $sentCode])
            ->assertUnprocessable();
        $this->assertDatabaseCount('transactions', 1);
    }

    public function test_code_is_rejected_when_transfer_details_change(): void
    {
        Mail::fake();
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1250,
        ]);
        $this->actingAs($user);
        $payload = $this->transferPayload();

        $this->postJson(route('transactions.activation-code', ['locale' => 'fr']), $payload)->assertOk();
        $code = null;
        Mail::assertSent(TransferActivationCodeMail::class, function (TransferActivationCodeMail $mail) use (&$code) {
            $code = $mail->code;

            return true;
        });

        $changedPayload = array_merge($payload, [
            'recipient_name' => 'Autre bénéficiaire',
            'activation_code' => $code,
        ]);

        $this->postJson(route('transactions.start', ['locale' => 'fr']), $changedPayload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('activation_code');
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_formatted_iban_and_lowercase_bic_are_normalized_before_sending_the_code(): void
    {
        Mail::fake();
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1250,
        ]);

        $payload = $this->transferPayload();
        $payload['recipient_iban'] = 'fr76 3000 6000 0112 3456 7890 189';
        $payload['recipient_bic'] = 'agrifrpp';

        $this->actingAs($user)
            ->postJson(route('transactions.activation-code', ['locale' => 'fr']), $payload)
            ->assertOk();

        Mail::assertSent(TransferActivationCodeMail::class);
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
