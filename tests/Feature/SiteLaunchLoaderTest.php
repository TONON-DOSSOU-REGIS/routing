<?php

test('the home page shows the branded launch loader', function () {
    $this->get(route('home', ['locale' => 'fr']))
        ->assertOk()
        ->assertSee('id="site-launch-loader"', false)
        ->assertSee('data-launch-loader', false)
        ->assertSee('images/zuider-logo-white.png', false)
        ->assertSee('Initialisation sécurisée', false)
        ->assertSee('siteLoaderSpin', false);
});

test('the launch loader can never block interaction or stay stuck', function () {
    $response = $this->get(route('home', ['locale' => 'fr']));

    $response->assertOk()
        // Decorative overlay: taps always reach the page underneath.
        ->assertSee('pointer-events: none', false)
        // Plays once per browsing session, skipped when returning home later.
        ->assertSee('zuider_launch_intro', false)
        // Independent safety nets guaranteeing dismissal.
        ->assertSee('hardTimeout', false)
        ->assertSee("window.addEventListener('load', settle", false)
        ->assertSee("window.addEventListener('pageshow', hideLoader)", false);
});

test('inner pages never render the launch loader', function () {
    $this->get(route('login', ['locale' => 'fr']))
        ->assertOk()
        ->assertDontSee('id="site-launch-loader"', false)
        ->assertDontSee('data-launch-loader', false);

    $this->get(route('register', ['locale' => 'fr']))
        ->assertOk()
        ->assertDontSee('id="site-launch-loader"', false);
});

test('the application shell uses a neutral background to avoid a jarring flash between pages', function () {
    // The base <body> background must be close to the real inner-page
    // background (light dashboards/auth pages), not the dark home-page
    // color — otherwise every navigation briefly flashes a mismatched color
    // before the page's own CSS paints.
    $this->get(route('login', ['locale' => 'fr']))
        ->assertOk()
        ->assertSee('background-color: #f5f8fc', false)
        ->assertDontSee('background-color: #03101f', false);
});
