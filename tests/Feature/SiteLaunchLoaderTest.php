<?php

test('the global shell includes the branded launch loader', function () {
    $response = $this->get(route('home', ['locale' => 'fr']));

    $response->assertOk()
        ->assertSee('id="site-launch-loader"', false)
        ->assertSee('images/Logosite.png', false)
        ->assertSee('Initialisation sécurisée', false)
        ->assertSee('siteLoaderProgress', false);
});
