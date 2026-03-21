<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTwoFactorRequirementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_route_requires_two_factor_middleware(): void
    {
        $route = app('router')->getRoutes()->getByName('admin.dashboard');

        $this->assertNotNull($route);
        $this->assertContains('auth', $route->middleware());
        $this->assertContains('admin', $route->middleware());
        $this->assertContains('twofactor', $route->middleware());
    }

    public function test_admin_without_two_factor_is_redirected_to_setup(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard', ['locale' => 'fr']));

        $response->assertRedirect(route('twofactor.setup', ['locale' => 'fr']));
        $response->assertSessionHas('status', __('auth.2fa_admin_setup_required', [], 'fr'));
    }

    public function test_admin_can_access_two_factor_setup_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('twofactor.setup', ['locale' => 'fr']));

        $response->assertOk();
        $response->assertSee(__('auth.2fa_setup_heading', [], 'fr'));

        $admin->refresh();
        $this->assertNotEmpty($admin->two_factor_secret);
    }

    public function test_admin_cannot_disable_two_factor_once_policy_is_mandatory(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => true,
            'two_factor_secret' => 'TESTSECRET123',
            'two_factor_backup_codes' => [],
        ]);

        $response = $this->actingAs($admin)
            ->startSession()
            ->withSession(['_token' => 'test'])
            ->from(route('twofactor.setup', ['locale' => 'fr']))
            ->post(route('twofactor.disable', ['locale' => 'fr']), [
                '_token' => 'test',
                'password' => 'password',
            ]);

        $response->assertRedirect(route('twofactor.setup', ['locale' => 'fr']));
        $response->assertSessionHasErrors('password');

        $admin->refresh();
        $this->assertTrue($admin->two_factor_enabled);
    }
}
