<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeCardsSectionTest extends TestCase
{
    public function test_homepage_displays_the_three_card_offers(): void
    {
        $response = $this->get(route('home', ['locale' => 'fr']));

        $response->assertOk();
        $response->assertSee('button-feedback-', false);
        $response->assertSee('id="cards"', false);
        $response->assertSee('Carte Standard');
        $response->assertSee('Carte Premium');
        $response->assertSee('Carte VIP');
        $response->assertSee('bank-card-product--standard', false);
        $response->assertSee('bank-card-product--premium', false);
        $response->assertSee('bank-card-product--vip', false);
    }

    public function test_card_section_is_translated_in_every_supported_locale(): void
    {
        foreach (['fr', 'en', 'de', 'nl', 'es', 'pl', 'it'] as $locale) {
            $response = $this->get(route('home', ['locale' => $locale]));

            $response->assertOk();
            $response->assertDontSee('home.cards_title');
            $response->assertDontSee('home.cards_choose');
        }
    }

    public function test_hero_contains_twenty_rotating_titles_in_every_supported_locale(): void
    {
        foreach (['fr', 'en', 'de', 'nl', 'es', 'pl', 'it'] as $locale) {
            $titles = trans('home.hero_slider_titles', [], $locale);

            $this->assertIsArray($titles);
            $this->assertCount(20, $titles);
            $this->assertCount(20, array_unique($titles));
        }

        $response = $this->get(route('home', ['locale' => 'fr']));
        $response->assertOk();
        $response->assertSee('id="hero-rotating-title"', false);
        $response->assertSee('id="hero-title-progress"', false);
        $response->assertSee('const heroTitles =', false);
    }

    public function test_hero_trust_indicators_are_dynamic_counters(): void
    {
        $response = $this->get(route('home', ['locale' => 'de']));

        $response->assertOk();
        $response->assertSee('data-counter-target="10000"', false);
        $response->assertSee('data-counter-target="27"', false);
        $response->assertSee('data-counter-target="4.7"', false);
        $response->assertSee('Betreute Kunden');
        $response->assertSee('Bediente Länder');
        $response->assertSee('Ausgezeichnet Trustpilot');
        $response->assertSee('const animateCounter = function', false);
    }

    public function test_happy_customer_card_contains_a_crossfade_carousel(): void
    {
        $response = $this->get(route('home', ['locale' => 'fr']));

        $response->assertOk();
        $response->assertSee('id="happy-customer-carousel"', false);
        $response->assertDontSee('id="happy-carousel-count"', false);
        $response->assertSee('happy-customer-11.webp');
        $response->assertSee('const scheduleCustomerSlide = function', false);
        $this->assertSame(11, count(glob(public_path('images/customer-carousel/*.webp'))));
    }
}
