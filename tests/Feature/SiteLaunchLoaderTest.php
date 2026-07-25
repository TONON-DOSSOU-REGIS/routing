<?php

test('the global shell includes the branded launch loader', function () {
    $response = $this->get(route('home', ['locale' => 'fr']));

    $response->assertOk()
        ->assertSee('id="site-launch-loader"', false)
        ->assertSee('images/zuider-logo-white.png', false)
        ->assertSee('Initialisation sécurisée', false)
        ->assertSee('siteLoaderSpin', false);
});

test('the application shell prevents white flashes between pages', function () {
    $response = $this->get(route('login', ['locale' => 'fr']));

    $response->assertOk()
        ->assertSee('background-color: #03101f', false)
        ->assertSee('#site-launch-loader.is-leaving', false)
        ->assertSee("document.addEventListener('click'", false)
        ->assertSee("window.addEventListener('beforeunload'", false);
});
