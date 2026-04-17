<?php

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware([
        \App\Http\Middleware\IsAdmin::class,
        \App\Http\Middleware\EnsureTwoFactorVerified::class,
        VerifyCsrfToken::class,
    ]);
});

test('admin transactions page loads with transaction summaries', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'role' => 'user',
        'first_name' => 'Jane',
        'last_name' => 'Client',
        'email' => 'jane.client@example.com',
    ]);

    $transaction = Transaction::factory()->for($user)->create([
        'type' => 'transfer',
        'status' => 'success',
        'recipient_name' => 'Acme Beneficiary',
        'reason' => 'Verification mobile admin transactions',
    ]);

    $response = $this->actingAs($admin)
        ->startSession()
        ->get(route('admin.transactions', ['locale' => 'fr']));

    $response->assertStatus(200);
    $response->assertSee('Journal des transactions');
    $response->assertSee('#' . $transaction->id);
    $response->assertSee('Jane');
    $response->assertSee('Acme Beneficiary');
    $response->assertSee('Rembourser');
});
