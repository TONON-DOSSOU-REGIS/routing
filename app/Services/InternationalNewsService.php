<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class InternationalNewsService
{
    public function latest(string $locale): array
    {
        $apiKey = (string) config('services.gnews.key');

        if ($apiKey === '') {
            throw new RuntimeException('GNews API key is not configured.');
        }

        $language = in_array($locale, ['fr', 'en', 'de', 'es', 'it', 'nl'], true) ? $locale : 'en';

        return Cache::remember("international-news:{$language}", now()->addMinutes(5), function () use ($apiKey, $language) {
            $response = Http::acceptJson()
                ->withHeaders(['X-Api-Key' => $apiKey])
                ->timeout(8)
                ->retry(2, 250)
                ->get('https://gnews.io/api/v4/top-headlines', [
                    'category' => 'world',
                    'lang' => $language,
                    'max' => 6,
                ])
                ->throw();

            return collect($response->json('articles', []))
                ->take(6)
                ->map(fn (array $article) => [
                    'title' => (string) ($article['title'] ?? ''),
                    'description' => (string) ($article['description'] ?? ''),
                    'url' => (string) ($article['url'] ?? ''),
                    'image' => (string) ($article['image'] ?? ''),
                    'published_at' => $article['publishedAt'] ?? null,
                    'source' => (string) data_get($article, 'source.name', ''),
                ])
                ->filter(fn (array $article) => $article['title'] !== '' && filter_var($article['url'], FILTER_VALIDATE_URL))
                ->values()
                ->all();
        });
    }
}
