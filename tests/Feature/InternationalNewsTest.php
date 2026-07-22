<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class InternationalNewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_receive_normalized_international_headlines(): void
    {
        Cache::flush();
        config(['services.gnews.key' => 'test-api-key']);
        Http::fake([
            'https://gnews.io/api/v4/top-headlines*' => Http::response([
                'articles' => [[
                    'title' => 'International banking update',
                    'description' => 'A current international finance story.',
                    'url' => 'https://example.com/international-news',
                    'image' => 'https://example.com/news.jpg',
                    'publishedAt' => '2026-07-22T08:00:00Z',
                    'source' => ['name' => 'Global Newsroom'],
                ]],
            ]),
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'two_factor_enabled' => false,
        ]);

        $this->actingAs($user)
            ->getJson(route('international-news', ['locale' => 'fr']))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('articles.0.title', 'International banking update')
            ->assertJsonPath('articles.0.source', 'Global Newsroom');

        Http::assertSent(fn ($request) => str_starts_with($request->url(), 'https://gnews.io/api/v4/top-headlines?')
            && $request['category'] === 'world'
            && $request['lang'] === 'fr'
            && $request->hasHeader('X-Api-Key', 'test-api-key'));
    }
}
