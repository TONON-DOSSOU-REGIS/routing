<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

uses(RefreshDatabase::class);

test('admin generates a client login link without an expiration date', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $client = User::factory()->create();

    $response = $this->actingAs($admin)
        ->withoutMiddleware([
            \App\Http\Middleware\IsAdmin::class,
            \App\Http\Middleware\EnsureTwoFactorVerified::class,
            VerifyCsrfToken::class,
        ])
        ->post(route('admin.users.login-link', [
            'locale' => 'fr',
            'user' => $client,
        ]));

    $response->assertSessionHas('login_link')
        ->assertSessionMissing('login_link_expires_at');

    expect($client->fresh()->login_link_expires_at)->toBeNull();
});

test('a client login link remains valid regardless of its former expiration date', function () {
    $rawToken = 'permanent-client-link';
    $client = User::factory()->create([
        'login_link_token' => hash('sha256', $rawToken),
        'login_link_expires_at' => now()->subYear(),
    ]);

    $response = $this->get(route('login.short', [
        'locale' => 'fr',
        'token' => $rawToken,
    ]));

    $response->assertRedirect('/fr/login')
        ->assertSessionHas('prefill_email', $client->email)
        ->assertSessionDoesntHaveErrors();

    expect($client->fresh()->login_link_used_at)->not->toBeNull();
});
