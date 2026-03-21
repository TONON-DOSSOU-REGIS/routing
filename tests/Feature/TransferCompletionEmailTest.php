<?php

namespace Tests\Feature;

use App\Mail\TransferConfirmationMail;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TransferCompletionEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_email_when_transfer_reaches_exactly_100_percent(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1000,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 100,
        ]);

        $response = $this->callProgressAsUser($user, $transaction->id);

        $this->assertSame('success', $response['status']);
        $this->assertSame(100, (int) $response['progress']);

        Mail::assertQueued(TransferConfirmationMail::class, 1);
        Mail::assertQueued(TransferConfirmationMail::class, function (TransferConfirmationMail $mail) use ($user, $transaction) {
            return $mail->hasTo($user->email) && $mail->transaction->id === $transaction->id;
        });

        $transaction->refresh();
        $user->refresh();

        $this->assertSame('success', $transaction->status);
        $this->assertSame(100, (int) $transaction->progress);
        $this->assertTrue((bool) data_get($transaction->meta, 'transfer_completion_email_sent'));
        $this->assertEquals(900.0, (float) $user->balance);
    }

    public function test_transfer_completion_email_is_sent_only_once(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1500,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 250,
        ]);

        $this->callProgressAsUser($user, $transaction->id);
        $this->callProgressAsUser($user, $transaction->id);

        Mail::assertQueued(TransferConfirmationMail::class, 1);
    }

    private function callProgressAsUser(User $user, int $transactionId): array
    {
        $this->actingAs($user);

        $request = Request::create('/transactions/progress', 'POST', [
            'tx_id' => $transactionId,
        ]);

        $response = app(TransactionController::class)->progress($request);

        $this->assertSame(200, $response->status());

        return $response->getData(true);
    }
}
