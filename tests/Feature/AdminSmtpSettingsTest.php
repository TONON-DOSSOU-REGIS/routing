<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureTwoFactorVerified;
use App\Models\SmtpSetting;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminSmtpSettingsTest extends TestCase
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

    public function test_admin_can_open_the_smtp_configuration_without_exposing_the_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        SmtpSetting::create([
            'id' => 1,
            'host' => 'smtp.example.com',
            'port' => 587,
            'scheme' => 'smtp',
            'username' => 'mailer@example.com',
            'password' => 'smtp-secret',
            'from_address' => 'contact@example.com',
            'from_name' => 'NEXALUNE BANK',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.settings', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('id="smtp-configuration"', false)
            ->assertSee(route('admin.settings.smtp', ['locale' => 'fr']), false)
            ->assertSee('smtp.example.com')
            ->assertSee('contact@example.com')
            ->assertDontSee('smtp-secret');
    }

    public function test_admin_can_save_encrypted_smtp_settings_and_activate_them(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.settings.smtp', ['locale' => 'fr']), [
            'smtp_host' => 'smtp.provider.test',
            'smtp_port' => 465,
            'smtp_scheme' => 'smtps',
            'smtp_username' => 'bank@provider.test',
            'smtp_password' => 'very-sensitive-password',
            'smtp_from_address' => 'notifications@nexalunebank.com',
            'smtp_from_name' => 'NEXALUNE BANK',
        ]);

        $response->assertSessionHasNoErrors()
            ->assertSessionHas('status', __('admin_pages.smtp_settings_updated'));

        $settings = SmtpSetting::query()->findOrFail(1);
        $rawPassword = DB::table('smtp_settings')->where('id', 1)->value('password');

        $this->assertSame('very-sensitive-password', $settings->password);
        $this->assertNotSame('very-sensitive-password', $rawPassword);
        $this->assertSame('smtp', config('mail.default'));
        $this->assertSame('smtp.provider.test', config('mail.mailers.smtp.host'));
        $this->assertSame(465, config('mail.mailers.smtp.port'));
        $this->assertSame('smtps', config('mail.mailers.smtp.scheme'));
        $this->assertSame('notifications@nexalunebank.com', config('mail.from.address'));
    }

    public function test_blank_password_keeps_the_existing_smtp_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        SmtpSetting::create([
            'id' => 1,
            'host' => 'smtp.old.test',
            'port' => 587,
            'scheme' => 'smtp',
            'username' => 'old-user',
            'password' => 'password-to-keep',
            'from_address' => 'old@example.com',
            'from_name' => 'Old sender',
        ]);

        $this->actingAs($admin)->post(route('admin.settings.smtp', ['locale' => 'fr']), [
            'smtp_host' => 'smtp.new.test',
            'smtp_port' => 587,
            'smtp_scheme' => 'smtp',
            'smtp_username' => 'new-user',
            'smtp_password' => '',
            'smtp_from_address' => 'new@example.com',
            'smtp_from_name' => 'New sender',
        ])->assertSessionHasNoErrors();

        $settings = SmtpSetting::query()->findOrFail(1);

        $this->assertSame('smtp.new.test', $settings->host);
        $this->assertSame('password-to-keep', $settings->password);
    }

    public function test_non_admin_cannot_update_smtp_settings(): void
    {
        $client = User::factory()->create(['role' => 'user']);

        $this->actingAs($client)->post(route('admin.settings.smtp', ['locale' => 'fr']), [
            'smtp_host' => 'smtp.example.com',
            'smtp_port' => 587,
            'smtp_scheme' => 'smtp',
            'smtp_from_address' => 'contact@example.com',
            'smtp_from_name' => 'NEXALUNE BANK',
        ])->assertForbidden();

        $this->assertDatabaseCount('smtp_settings', 0);
    }
}
