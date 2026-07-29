<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthPremiumViewTest extends TestCase
{
    public function test_login_page_uses_the_modern_authentication_layout(): void
    {
        $this->get('/fr/login')
            ->assertOk()
            ->assertSee('auth-premium-page', false)
            ->assertSee('auth-bank-card', false)
            ->assertSee('id="auth-menu-toggle"', false)
            ->assertSee('aria-controls="auth-mobile-menu"', false)
            ->assertSee('id="auth-mobile-backdrop"', false)
            ->assertSee('auth-mobile-drawer', false)
            ->assertSee('id="email"', false)
            ->assertSee('id="password"', false);
    }

    public function test_register_page_uses_the_professional_registration_layout(): void
    {
        $this->get('/fr/register')
            ->assertOk()
            ->assertSee('register-page', false)
            ->assertSee('register-intro', false)
            ->assertSee('register-card', false)
            ->assertSee('id="register-form"', false)
            ->assertSee('id="first_name"', false)
            ->assertSee('autocomplete="given-name"', false)
            ->assertSee('id="date_of_birth"', false)
            ->assertSee('id="id_type"', false)
            ->assertSee('id="id_number"', false)
            ->assertSee('id="password_confirmation"', false)
            ->assertDontSee('auth-bank-card', false);
    }

    public function test_two_factor_challenge_uses_the_modern_authentication_layout(): void
    {
        $this->view('auth.two-factor-challenge', [
            'email' => 'client@example.com',
            'errors' => new \Illuminate\Support\ViewErrorBag(),
        ])
            ->assertSee('auth-premium-page', false)
            ->assertSee('two-factor-orbit', false)
            ->assertSee('id="code"', false)
            ->assertSee('id="recovery_code"', false)
            ->assertSee('name="code"', false)
            ->assertSee('name="recovery_code"', false);
    }
}
