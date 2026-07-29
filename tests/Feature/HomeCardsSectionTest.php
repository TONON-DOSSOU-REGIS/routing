<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeCardsSectionTest extends TestCase
{
    public function test_public_mobile_menu_is_initialized_without_waiting_for_dom_content_loaded(): void
    {
        $response = $this->get(route('about.notre-histoire', ['locale' => 'fr']));

        $response->assertOk()
            ->assertSee('id="mobile-menu-button"', false)
            ->assertSee("toggle.dataset.menuInitialized = 'true'", false);
    }

    public function test_public_pages_share_the_home_navigation(): void
    {
        // Home and footer pages must render the exact same navigation shell.
        foreach ([
            route('home', ['locale' => 'fr']),
            route('about.notre-histoire', ['locale' => 'fr']),
            route('support.centre-aide', ['locale' => 'fr']),
            route('services.cartes-paiement', ['locale' => 'fr']),
        ] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('class="bank-nav"', false)
                ->assertSee('class="bank-nav-inner"', false)
                ->assertSee('id="mobile-menu-button"', false)
                ->assertSee('language-selector', false)
                // The legacy inner-page navbar must be gone everywhere.
                ->assertDontSee('modern-nav-inner', false);
        }
    }

    public function test_homepage_displays_the_three_card_offers(): void
    {
        $response = $this->get(route('home', ['locale' => 'fr']));

        $response->assertOk();
        $response->assertSee('button-feedback-', false);
        $response->assertSee("toggle.dataset.menuInitialized = 'true'", false);
        $response->assertSee('(function () {', false);
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

    public function test_public_pages_are_responsive_on_small_screens(): void
    {
        foreach ([
            route('about.notre-histoire', ['locale' => 'fr']),
            route('support.nous-contacter', ['locale' => 'fr']),
            route('services.comptes-professionnels', ['locale' => 'fr']),
            route('support.mentions-legales', ['locale' => 'fr']),
        ] as $url) {
            $this->get($url)
                ->assertOk()
                // Sideways scrolling must be impossible on a phone.
                ->assertSee('overflow-x: hidden', false)
                // Two-column layouts with fixed track minimums collapse in time.
                ->assertSee('.hero-grid,', false)
                ->assertSee('.split-panel,', false)
                // Dedicated small-phone breakpoint.
                ->assertSee('@media (max-width: 480px)', false);
        }
    }
}
