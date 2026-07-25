<?php

test('the application root redirects to the default locale', function () {
    $response = $this->get('/');

    $response->assertRedirect('/' . config('app.locale'));
});
