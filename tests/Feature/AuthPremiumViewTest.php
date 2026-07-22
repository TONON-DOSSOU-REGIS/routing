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

    public function test_register_page_uses_the_modern_authentication_layout(): void
    {
        $this->get('/fr/register')
            ->assertOk()
            ->assertSee('auth-premium-page', false)
            ->assertSee('auth-bank-card', false)
            ->assertSee('id="auth-menu-toggle"', false)
            ->assertSee('aria-controls="auth-mobile-menu"', false)
            ->assertSee('id="auth-mobile-backdrop"', false)
            ->assertSee('auth-mobile-drawer', false)
            ->assertSee('id="first_name"', false)
            ->assertSee('id="password_confirmation"', false);
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
