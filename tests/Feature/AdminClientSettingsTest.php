<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureTwoFactorVerified;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AdminClientSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            ValidateCsrfToken::class,
            EnsureTwoFactorVerified::class,
        ]);
    }

    public function test_selecting_a_client_loads_only_that_clients_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $firstClient = User::factory()->create();
        $secondClient = User::factory()->create([
            'activation_code' => Hash::make('A1B2C3'),
        ]);

        Setting::create([
            'target_user_id' => $firstClient->id,
            'stop_percentage' => 25,
            'stop_message' => 'Premier client',
        ]);
        $secondSetting = Setting::create([
            'target_user_id' => $secondClient->id,
            'stop_percentage' => 72,
            'stop_message' => 'Deuxième client',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.settings', [
            'locale' => 'fr',
            'target_user_id' => $secondClient->id,
        ]));

        $response->assertOk();
        $response->assertViewHas('selectedUser', fn (User $user) => $user->is($secondClient));
        $response->assertViewHas('settings', fn (Setting $setting) => $setting->is($secondSetting));
        $response->assertViewHas('hasActivationCode', true);
        $response->assertSee('Deuxième client');
        $response->assertSee(route('admin.settings.activation-code', ['locale' => 'fr']), false);
        $response->assertSee(__('admin_pages.activation_code_configured'));
        $response->assertDontSee('Premier client');
        $response->assertDontSee('Globale');
    }

    public function test_saving_settings_creates_and_updates_one_record_per_client(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $firstClient = User::factory()->create();
        $secondClient = User::factory()->create();

        Setting::create([
            'target_user_id' => $firstClient->id,
            'stop_percentage' => 20,
            'stop_message' => 'Règle conservée',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.settings.save', ['locale' => 'fr']), [
            'target_user_id' => $secondClient->id,
            'stop_percentage' => 65,
            'stop_message' => 'Règle du deuxième client',
        ]);

        $response->assertRedirect(route('admin.settings', [
            'locale' => 'fr',
            'target_user_id' => $secondClient->id,
        ]));
        $this->assertDatabaseHas('settings', [
            'target_user_id' => $firstClient->id,
            'stop_percentage' => 20,
            'stop_message' => 'Règle conservée',
        ]);
        $this->assertDatabaseHas('settings', [
            'target_user_id' => $secondClient->id,
            'stop_percentage' => 65,
            'stop_message' => 'Règle du deuxième client',
        ]);

        $this->actingAs($admin)->post(route('admin.settings.save', ['locale' => 'fr']), [
            'target_user_id' => $secondClient->id,
            'stop_percentage' => 80,
            'stop_message' => 'Règle mise à jour',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount('settings', 2);
        $this->assertDatabaseHas('settings', [
            'target_user_id' => $secondClient->id,
            'stop_percentage' => 80,
            'stop_message' => 'Règle mise à jour',
        ]);
    }

    public function test_saving_requires_a_real_client_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.settings.save', ['locale' => 'fr']), [
            'target_user_id' => $admin->id,
            'stop_percentage' => 50,
            'stop_message' => 'Ne doit pas être enregistré',
        ])->assertSessionHasErrors('target_user_id');

        $this->assertDatabaseCount('settings', 0);
    }

    public function test_admin_can_replace_only_the_selected_clients_activation_code_from_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $firstClient = User::factory()->create([
            'activation_code' => Hash::make('OLD1A2'),
        ]);
        $secondCodeHash = Hash::make('Z9Y8X7');
        $secondClient = User::factory()->create([
            'activation_code' => $secondCodeHash,
        ]);
        $rateLimitKey = 'transfer-activation:'.$firstClient->id;
        RateLimiter::hit($rateLimitKey, 900);

        $response = $this->actingAs($admin)->post(route('admin.settings.activation-code', ['locale' => 'fr']), [
            'target_user_id' => $firstClient->id,
            'stop_percentage' => 65,
            'stop_message' => 'Nouveau palier à 65 %',
            'activation_code' => 'a1b2c3',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.settings', [
            'locale' => 'fr',
            'target_user_id' => $firstClient->id,
        ]));

        $firstClient->refresh();
        $secondClient->refresh();

        $this->assertTrue(Hash::check('A1B2C3', $firstClient->activation_code));
        $this->assertFalse(Hash::check('OLD1A2', $firstClient->activation_code));
        $this->assertSame($secondCodeHash, $secondClient->activation_code);
        $this->assertSame(0, RateLimiter::attempts($rateLimitKey));
        $this->assertDatabaseHas('settings', [
            'target_user_id' => $firstClient->id,
            'stop_percentage' => 65,
            'stop_message' => 'Nouveau palier à 65 %',
        ]);
    }

    public function test_updating_an_activation_code_requires_a_real_client_and_a_mixed_code(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create([
            'activation_code' => Hash::make('OLD1A2'),
        ]);

        $this->actingAs($admin)->post(route('admin.settings.activation-code', ['locale' => 'fr']), [
            'target_user_id' => $client->id,
            'stop_percentage' => 65,
            'stop_message' => 'Nouveau palier',
            'activation_code' => '482901',
        ])->assertSessionHasErrors('activation_code');

        $this->actingAs($admin)->post(route('admin.settings.activation-code', ['locale' => 'fr']), [
            'target_user_id' => $admin->id,
            'stop_percentage' => 65,
            'stop_message' => 'Nouveau palier',
            'activation_code' => 'A1B2C3',
        ])->assertSessionHasErrors('target_user_id');

        $this->assertTrue(Hash::check('OLD1A2', $client->fresh()->activation_code));
    }

    public function test_new_code_target_must_be_above_the_clients_current_progress(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create([
            'activation_code' => Hash::make('OLD1A2'),
        ]);
        Setting::create([
            'target_user_id' => $client->id,
            'stop_percentage' => 70,
            'stop_message' => 'Palier actuel',
        ]);
        Transaction::factory()->create([
            'user_id' => $client->id,
            'type' => 'transfer',
            'status' => 'on_hold',
            'progress' => 70,
        ]);

        $this->actingAs($admin)->post(route('admin.settings.activation-code', ['locale' => 'fr']), [
            'target_user_id' => $client->id,
            'stop_percentage' => 60,
            'stop_message' => 'Palier invalide',
            'activation_code' => 'B2C3D4',
        ])->assertSessionHasErrors('stop_percentage');

        $this->assertTrue(Hash::check('OLD1A2', $client->fresh()->activation_code));
        $this->assertDatabaseHas('settings', [
            'target_user_id' => $client->id,
            'stop_percentage' => 70,
            'stop_message' => 'Palier actuel',
        ]);
    }
}
