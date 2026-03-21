<?php

namespace Tests\Feature;

use App\Mail\UserApprovedNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminApprovalMailQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_approval_email_is_queued(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => true,
            'two_factor_secret' => 'ADMINSECRET123',
            'two_factor_backup_codes' => [],
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->startSession()
            ->withSession([
                '2fa_passed' => true,
                '_token' => 'test',
            ])
            ->post(route('admin.users.approve', ['locale' => 'fr', 'user' => $user]), [
                '_token' => 'test',
            ]);

        $response->assertRedirect();

        Mail::assertQueued(UserApprovedNotification::class, function (UserApprovedNotification $mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->user->is($user);
        });

        $user->refresh();
        $this->assertSame('active', $user->status);
    }
}
