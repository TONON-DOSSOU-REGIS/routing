<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PremiumDashboardDesignTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_dashboard_uses_the_vip_shared_shell(): void
    {
        $client = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'two_factor_enabled' => false,
        ]);

        $this->actingAs($client)
            ->get(route('dashboard', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('premium-sidebar-brand', false)
            ->assertSee('premium-topbar', false)
            ->assertSee('premium-content-stack', false)
            ->assertSee('data-premium-card-system="ultra"', false)
            ->assertSee('data-mobile-menu-autoclose="true"', false)
            ->assertSee('chat-premium-invite', false)
            ->assertSee('data-chat-zoom-in', false)
            ->assertSee('ZuiderChatAudio', false)
            ->assertSee('client-chat-jump-latest', false)
            ->assertSee('data-chat-scroll="client"', false)
            ->assertSee('premium-dashboard-sidebar-close', false)
            ->assertSee('data-live-news', false)
            ->assertSee('data-client-news-section', false)
            ->assertDontSee('market-tracker-widget', false);
    }

    public function test_admin_dashboard_uses_the_vip_shared_shell(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => true,
            'two_factor_secret' => 'TESTSECRET123',
        ]);

        $this->actingAs($admin)
            ->withSession(['2fa_passed' => true])
            ->get(route('admin.dashboard', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('premium-theme-admin', false)
            ->assertSee('premium-sidebar-brand', false)
            ->assertSee('premium-topbar', false)
            ->assertSee('premium-content-stack', false)
            ->assertSee('data-premium-card-system="ultra"', false)
            ->assertSee('data-mobile-menu-autoclose="true"', false)
            ->assertSee('chat-premium-invite', false)
            ->assertSee('chat-premium-admin-recipient', false)
            ->assertSee('data-chat-zoom-in', false)
            ->assertSee('ZuiderChatAudio', false)
            ->assertSee('admin-chat-jump-latest-v2', false)
            ->assertSee('data-chat-scroll="admin"', false)
            ->assertSee('data-live-news', false)
            ->assertDontSee('market-tracker-widget', false);
    }

    public function test_transfer_page_displays_the_contrasted_journey_card(): void
    {
        $client = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'two_factor_enabled' => false,
        ]);

        $this->actingAs($client)
            ->get(route('transactions.create', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('data-transfer-journey', false)
            ->assertSee('transfer-step-number', false)
            ->assertSee('transfer-step-status', false);
    }
}
