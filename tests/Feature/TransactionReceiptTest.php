<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionReceiptTest extends TestCase
{
    use RefreshDatabase;

    public function test_receipt_shows_validated_icon_and_message_when_progress_100()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'progress' => 100,
            'status' => 'success',
        ]);

        $this->actingAs($user);
        $response = $this->get(route('transactions.receipt.html', ['locale' => 'fr', 'transaction' => $transaction->id]));
        $response->assertStatus(200);
        $response->assertSee('validate-icon.png');
        $response->assertSee('Le virement a été effectué à 100% avec succès.');
    }

    public function test_receipt_shows_alert_icon_and_progress_message_when_progress_less_than_100()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'progress' => 75,
            'status' => 'pending',
        ]);

        $this->actingAs($user);
        $response = $this->get(route('transactions.receipt.html', ['locale' => 'fr', 'transaction' => $transaction->id]));
        $response->assertStatus(200);
        $response->assertSee('alert-icon.png');
        $response->assertSee('Le virement est en cours, à 75% de progression.');
    }

    public function test_stop_percentage_validation_allows_0_to_100()
    {
        $this->withExceptionHandling();

        // Create user with admin role properly if is_admin column does not exist
        $user = User::factory()->create([
            'role' => 'admin',
            'date_of_birth' => '1990-01-01',
            'id_type' => 'passport',
        ]);
        $this->actingAs($user);

        // Test sending valid stop_percentage values
        foreach ([0, 50, 100] as $value) {
            $response = $this->post(route('admin.settings.save', ['locale' => 'fr']), [
                'stop_percentage' => $value,
                'stop_message' => 'Test message',
                'target_user_id' => null,
                'is_global' => true,
            ]);
            $response->assertSessionHasNoErrors('stop_percentage');
        }

        // Test invalid value
        $response = $this->post(route('admin.settings.save', ['locale' => 'fr']), [
            'stop_percentage' => 101,
            'stop_message' => 'Test message',
            'target_user_id' => null,
            'is_global' => true,
        ]);
        $response->assertSessionHasErrors('stop_percentage');
    }
}

