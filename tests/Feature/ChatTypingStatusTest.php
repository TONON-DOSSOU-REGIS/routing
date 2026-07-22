<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ChatTypingStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_when_the_selected_client_is_typing(): void
    {
        $this->withoutMiddleware([
            VerifyCsrfToken::class,
            ValidateCsrfToken::class,
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => true,
            'two_factor_secret' => 'TESTSECRET123',
        ]);
        $client = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'two_factor_enabled' => false,
        ]);

        $cacheKey = "chat:user:typing:{$client->id}:{$admin->id}";
        Cache::forget($cacheKey);

        $this->actingAs($client)
            ->postJson(route('chat.typing'), [
                'receiver_id' => $admin->id,
                'is_typing' => true,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($admin)
            ->withSession(['2fa_passed' => true])
            ->getJson(route('chat.messages.user', ['userId' => $client->id]))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('user_typing', true);

        Cache::forget($cacheKey);
    }
}
