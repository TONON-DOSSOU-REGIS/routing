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

    public function test_footer_linked_pages_share_one_identical_footer(): void
    {
        $renderFooter = function (string $routeName): string {
            $response = $this->get(route($routeName, ['locale' => 'fr']));

            $response->assertOk();
            $content = $response->getContent();
            $this->assertSame(1, substr_count($content, 'data-public-footer'));
            $this->assertMatchesRegularExpression('/<footer class="bank-footer" data-public-footer>.*?<\/footer>/s', $content);
            preg_match('/<footer class="bank-footer" data-public-footer>.*?<\/footer>/s', $content, $matches);

            return $matches[0];
        };

        $homeFooter = $renderFooter('home');

        foreach ([
            'services.comptes-professionnels',
            'services.virements-internationaux',
            'services.gestion-tresorerie',
            'services.cartes-paiement',
            'about.notre-histoire',
            'about.carrieres',
            'about.presse',
            'about.blog',
            'support.centre-aide',
            'support.nous-contacter',
            'support.securite',
            'support.mentions-legales',
            'support.politique-cookies',
        ] as $routeName) {
            $this->assertSame($homeFooter, $renderFooter($routeName));
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
        $response->assertSee('.site-shell main .btn {', false);
        $response->assertSee('min-height: 48px', false);
        $response->assertSee('scroll-margin-top: 112px', false);
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

    public function test_hero_backgrounds_crossfade_with_local_optimized_images(): void
    {
        $response = $this->get(route('home', ['locale' => 'fr']));

        $response->assertOk()
            ->assertSee('id="hero-backgrounds"', false)
            ->assertSee('nexalune-financial-district.webp', false)
            ->assertSee('nexalune-digital-banking.webp', false)
            ->assertSee('nexalune-private-banking.webp', false)
            ->assertSee("background.classList.toggle('is-active'", false);

        foreach ([
            'nexalune-financial-district.webp',
            'nexalune-digital-banking.webp',
            'nexalune-private-banking.webp',
        ] as $image) {
            $this->assertFileExists(public_path('images/hero/'.$image));
        }
    }

    public function test_homepage_enrichment_is_complete_and_translated(): void
    {
        foreach (['fr', 'en', 'de', 'nl', 'es', 'pl', 'it'] as $locale) {
            $response = $this->get(route('home', ['locale' => $locale]));

            $response->assertOk()
                ->assertSee('id="experience"', false)
                ->assertSee('class="experience-visual"', false)
                ->assertSee('nexalune-banking-devices.webp', false)
                ->assertDontSee('class="dashboard-preview"', false)
                ->assertSee('id="security-features"', false)
                ->assertSee('class="features-grid"', false)
                ->assertSeeText(trans('home.why_choose_title', [], $locale))
                ->assertSeeText(trans('home.features_title', [], $locale))
                ->assertDontSee('home.advantage_1_title')
                ->assertDontSee('home.feature_1_title')
                ->assertDontSee('home.faq_1_subtitle');
        }

        $this->assertFileExists(public_path('images/experience/nexalune-banking-devices.webp'));
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
                ->assertSee('@media (max-width: 480px)', false)
                // Both hero actions stay on the same row on mobile.
                ->assertSee('data-public-hero-actions', false)
                ->assertSee('.hero-actions[data-public-hero-actions] {', false)
                ->assertSee('grid-template-columns: repeat(2, minmax(0, 1fr));', false)
                // Content sections must remain readable instead of inheriting
                // the hero's dark background over long mobile pages.
                ->assertSee('.modern-page {', false)
                ->assertSee('background: #ffffff;', false);
        }
    }

    public function test_official_phone_number_and_french_flag_are_visible_and_clickable(): void
    {
        foreach (['fr', 'en', 'de', 'nl', 'es', 'pl', 'it'] as $locale) {
            $this->assertSame('+33 6 35 78 68 12', trans('support.contact_phone_number', [], $locale));

            $this->get(route('support.nous-contacter', ['locale' => $locale]))
                ->assertOk()
                ->assertSee('href="tel:+33635786812"', false)
                ->assertSee('+33 6 35 78 68 12')
                ->assertSee('class="contact-phone-flag"', false);
        }

        $this->get(route('home', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('href="tel:+33635786812"', false)
            ->assertSee('+33 6 35 78 68 12')
            ->assertSee('class="footer-phone-flag"', false)
            ->assertSee('fill="#002654"', false)
            ->assertSee('fill="#CE1126"', false);
    }
}
