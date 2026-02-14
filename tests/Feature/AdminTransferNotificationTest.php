<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTransferNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_notification_is_created_when_transfer_is_started(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'amount' => 250.50,
            'recipient_name' => 'Jean Dupont',
            'recipient_iban' => 'FR7630006000011234567890189',
        ]);

        NotificationService::notifyAdminTransferStarted($user, $transaction);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $admin->id,
            'type' => 'transaction',
            'title' => 'Virement initie',
            'is_read' => false,
        ]);
    }

    public function test_notifications_unread_count_route_is_accessible_to_admins(): void
    {
        $route = app('router')->getRoutes()->getByName('notifications.unread-count');

        $this->assertNotNull($route);
        $this->assertSame('{locale}/notifications/unread-count', $route->uri());
        $this->assertContains('auth', $route->middleware());
        $this->assertContains('twofactor', $route->middleware());
        $this->assertNotContains('notAdmin', $route->middleware());
    }

    public function test_admin_notification_is_localized_with_admin_locale(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'locale' => 'en',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'status' => 'pending',
            'amount' => 125.00,
            'recipient_name' => 'John Smith',
            'recipient_iban' => 'GB29NWBK60161331926819',
        ]);

        NotificationService::notifyAdminTransferStarted($user, $transaction);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $admin->id,
            'type' => 'transaction',
            'title' => 'Transfer started',
            'is_read' => false,
        ]);
    }
}
