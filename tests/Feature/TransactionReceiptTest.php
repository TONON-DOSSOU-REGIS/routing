<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Middleware\EnsureTwoFactorVerified;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionReceiptTest extends TestCase
{
    use RefreshDatabase;

    public function test_receipt_shows_success_status_and_verification_details_when_progress_100(): void
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'progress' => 100,
            'status' => 'success',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('transactions.receipt.html', ['locale' => 'fr', 'transaction' => $transaction->id]));

        $response->assertOk();
        $response->assertSee('status-success');
        $response->assertSee('Reçu');
        $response->assertSee('Réussi');
        $response->assertSee('100%');
        $response->assertSee('Code de verification');
    }

    public function test_receipt_shows_pending_status_and_progress_when_progress_less_than_100(): void
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'progress' => 75,
            'status' => 'pending',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('transactions.receipt.html', ['locale' => 'fr', 'transaction' => $transaction->id]));

        $response->assertOk();
        $response->assertSee('status-pending');
        $response->assertSee('En attente');
        $response->assertSee('75%');
        $response->assertSee('Code de verification');
    }

    public function test_stop_percentage_validation_allows_0_to_100(): void
    {
        $this->withExceptionHandling();
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $this->withoutMiddleware(EnsureTwoFactorVerified::class);

        $user = User::factory()->create([
            'role' => 'admin',
            'date_of_birth' => '1990-01-01',
            'id_type' => 'passport',
        ]);

        $this->actingAs($user);

        foreach ([0, 50, 100] as $value) {
            $response = $this->post(route('admin.settings.save', ['locale' => 'fr']), [
                'stop_percentage' => $value,
                'stop_message' => 'Test message',
                'target_user_id' => null,
                'is_global' => true,
            ]);

            $response->assertSessionHasNoErrors('stop_percentage');
        }

        $response = $this->post(route('admin.settings.save', ['locale' => 'fr']), [
            'stop_percentage' => 101,
            'stop_message' => 'Test message',
            'target_user_id' => null,
            'is_global' => true,
        ]);

        $response->assertSessionHasErrors('stop_percentage');
    }

    public function test_stop_message_validation_allows_more_than_255_characters(): void
    {
        $this->withExceptionHandling();
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $this->withoutMiddleware(EnsureTwoFactorVerified::class);

        $admin = User::factory()->create([
            'role' => 'admin',
            'date_of_birth' => '1990-01-01',
            'id_type' => 'passport',
        ]);

        $this->actingAs($admin);

        $longMessage = trim(str_repeat('Message de suspension premium ', 15));

        $response = $this->post(route('admin.settings.save', ['locale' => 'fr']), [
            'stop_percentage' => 50,
            'stop_message' => $longMessage,
            'target_user_id' => null,
            'is_global' => true,
        ]);

        $response->assertSessionHasNoErrors('stop_message');
        $response->assertSessionHas('status');

        $setting = Setting::query()->first();

        $this->assertNotNull($setting);
        $this->assertGreaterThan(255, strlen($longMessage));
        $this->assertSame($longMessage, $setting->stop_message);
    }

    public function test_polish_transfer_page_renders_auto_transfer_translations(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'balance' => 400000,
            'default_currency' => 'PLN',
            'two_factor_enabled' => false,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('transactions.create', ['locale' => 'pl']));

        $response->assertOk();
        $response->assertSee('Kwota przelewana automatycznie');
        $response->assertSee('Przelew automatycznie wykorzysta cale dostepne saldo na koncie.');
        $response->assertSee('Kwota, ktora zostanie przelana');
        $response->assertSee('Kwota jest automatycznie pobierana z konta, aby przyspieszyc operacje.');
        $response->assertSee('Uzupelnij tylko dane beneficjenta i kod aktywacji, aby sfinalizowac przelew.');
        $response->assertDontSee('transactions.auto_transfer_title');
        $response->assertDontSee('transactions.auto_transfer_description');
        $response->assertDontSee('transactions.auto_transfer_amount_label');
        $response->assertDontSee('transactions.auto_transfer_amount_notice');
        $response->assertDontSee('transactions.auto_transfer_helper');
    }
}
