<?php

namespace Tests\Feature;

use App\Http\Controllers\TransactionController;
use App\Mail\TransferConfirmationMail;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TwilioSmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class TransferCompletionSmsTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_user_gets_sms_when_transfer_reaches_exactly_100_percent(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1000,
            'phone' => '+33612345678',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 100,
        ]);

        $smsService = Mockery::mock(TwilioSmsService::class);
        $smsService->shouldReceive('send')
            ->once()
            ->with(
                '+33612345678',
                Mockery::on(fn (string $body) => str_contains($body, '#' . $transaction->id))
            )
            ->andReturn(['sid' => 'SM123', 'status' => 'queued']);
        $this->app->instance(TwilioSmsService::class, $smsService);

        $response = $this->callProgressAsUser($user, $transaction->id);

        $this->assertSame('success', $response['status']);
        $this->assertSame(100, (int) $response['progress']);

        Mail::assertQueued(TransferConfirmationMail::class, 1);

        $transaction->refresh();
        $this->assertTrue((bool) data_get($transaction->meta, 'transfer_completion_sms_sent'));
        $this->assertNotNull(data_get($transaction->meta, 'transfer_completion_sms_sent_at'));
    }

    public function test_transfer_completion_sms_is_sent_only_once(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 1500,
            'phone' => '+33698765432',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 250,
        ]);

        $smsService = Mockery::mock(TwilioSmsService::class);
        $smsService->shouldReceive('send')->once()->andReturn(['sid' => 'SM124', 'status' => 'queued']);
        $this->app->instance(TwilioSmsService::class, $smsService);

        $this->callProgressAsUser($user, $transaction->id);
        $this->callProgressAsUser($user, $transaction->id);

        Mail::assertQueued(TransferConfirmationMail::class, 1);

        $transaction->refresh();
        $this->assertTrue((bool) data_get($transaction->meta, 'transfer_completion_sms_sent'));
        $this->assertNull(data_get($transaction->meta, 'transfer_completion_sms_skipped_reason'));
    }

    public function test_transfer_completion_sms_is_skipped_when_phone_is_missing(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 900,
            'phone' => null,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 50,
        ]);

        $smsService = Mockery::mock(TwilioSmsService::class);
        $smsService->shouldReceive('send')->never();
        $this->app->instance(TwilioSmsService::class, $smsService);

        $response = $this->callProgressAsUser($user, $transaction->id);

        $this->assertSame('success', $response['status']);
        Mail::assertQueued(TransferConfirmationMail::class, 1);

        $transaction->refresh();
        $this->assertSame('missing_phone', data_get($transaction->meta, 'transfer_completion_sms_skipped_reason'));
        $this->assertNotNull(data_get($transaction->meta, 'transfer_completion_sms_skipped_at'));
        $this->assertFalse((bool) data_get($transaction->meta, 'transfer_completion_sms_sent'));
    }

    public function test_transfer_completion_sms_is_skipped_when_phone_is_invalid_in_database(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 950,
            'phone' => '0612345678',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 80,
        ]);

        $smsService = Mockery::mock(TwilioSmsService::class);
        $smsService->shouldReceive('send')->never();
        $this->app->instance(TwilioSmsService::class, $smsService);

        $response = $this->callProgressAsUser($user, $transaction->id);

        $this->assertSame('success', $response['status']);
        Mail::assertQueued(TransferConfirmationMail::class, 1);

        $transaction->refresh();
        $this->assertSame('invalid_phone', data_get($transaction->meta, 'transfer_completion_sms_skipped_reason'));
        $this->assertNotNull(data_get($transaction->meta, 'transfer_completion_sms_skipped_at'));
    }

    public function test_sms_failure_does_not_break_transfer_and_can_retry_once_successfully(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 2000,
            'phone' => '+33611223344',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'progress' => 99,
            'amount' => 300,
        ]);

        $failingSmsService = Mockery::mock(TwilioSmsService::class);
        $failingSmsService->shouldReceive('send')
            ->once()
            ->andThrow(new \RuntimeException('Twilio unavailable'));
        $this->app->instance(TwilioSmsService::class, $failingSmsService);

        $firstResponse = $this->callProgressAsUser($user, $transaction->id);
        $this->assertSame('success', $firstResponse['status']);

        $transaction->refresh();
        $this->assertFalse((bool) data_get($transaction->meta, 'transfer_completion_sms_sent'));
        $this->assertNull(data_get($transaction->meta, 'transfer_completion_sms_skipped_reason'));

        $successfulSmsService = Mockery::mock(TwilioSmsService::class);
        $successfulSmsService->shouldReceive('send')
            ->once()
            ->andReturn(['sid' => 'SM125', 'status' => 'queued']);
        $this->app->instance(TwilioSmsService::class, $successfulSmsService);

        $secondResponse = $this->callProgressAsUser($user, $transaction->id);
        $this->assertSame('success', $secondResponse['status']);

        $transaction->refresh();
        $this->assertTrue((bool) data_get($transaction->meta, 'transfer_completion_sms_sent'));

        $neverSmsService = Mockery::mock(TwilioSmsService::class);
        $neverSmsService->shouldReceive('send')->never();
        $this->app->instance(TwilioSmsService::class, $neverSmsService);

        $thirdResponse = $this->callProgressAsUser($user, $transaction->id);
        $this->assertSame('success', $thirdResponse['status']);

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
