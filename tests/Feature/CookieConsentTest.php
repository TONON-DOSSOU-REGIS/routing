<?php

test('the cookie consent banner appears on the home page', function () {
    $this->get(route('home', ['locale' => 'fr']))
        ->assertOk()
        ->assertSee('data-cookie-consent-root', false)
        ->assertSee('data-cookie-action="accept-all"', false)
        ->assertSee('data-cookie-action="reject-all"', false)
        ->assertSee('data-cookie-action="customize"', false);
});

test('the cookie consent banner appears on authenticated-shell pages too', function () {
    // GDPR consent must be collected regardless of which page is loaded first.
    $this->get(route('login', ['locale' => 'fr']))
        ->assertOk()
        ->assertSee('data-cookie-consent-root', false);
});

test('the dedicated cookie policy page is reachable and details every cookie category', function () {
    $this->get(route('support.politique-cookies', ['locale' => 'fr']))
        ->assertOk()
        ->assertSee(__('cookies.page_heading'))
        ->assertSee(__('cookies.category_necessary_title'))
        ->assertSee(__('cookies.category_analytics_title'))
        ->assertSee(__('cookies.category_functional_title'))
        ->assertSee(__('cookies.category_marketing_title'))
        ->assertSee(__('cookies.section_legal_basis_title'))
        ->assertSee(__('cookies.section_rights_title'))
        ->assertSee('data-label="'.__('cookies.table_name').'"', false)
        ->assertSee('content: attr(data-label)', false);
});

test('the preferences center exposes toggles for every optional cookie category', function () {
    $response = $this->get(route('home', ['locale' => 'fr']));

    $response->assertOk()
        ->assertSee('data-cookie-category="analytics"', false)
        ->assertSee('data-cookie-category="functional"', false)
        ->assertSee('data-cookie-category="marketing"', false)
        // Necessary cookies are always on and cannot be toggled off.
        ->assertSee(__('cookies.category_necessary_badge'));
});

test('cookie translations exist for every supported locale', function () {
    foreach (['fr', 'en', 'es', 'de', 'it', 'nl', 'pl'] as $locale) {
        app()->setLocale($locale);

        expect(__('cookies.banner_title'))->not->toBe('cookies.banner_title');
        expect(__('cookies.page_heading'))->not->toBe('cookies.page_heading');
        expect(__('cookies.footer_link_label'))->not->toBe('cookies.footer_link_label');
    }
});
