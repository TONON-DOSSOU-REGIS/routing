<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ChatAttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_chat_image_is_displayed_through_the_protected_attachment_route(): void
    {
        Storage::fake('public');
        Event::fake();
        $this->withoutMiddleware([
            VerifyCsrfToken::class,
            ValidateCsrfToken::class,
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'two_factor_enabled' => true,
            'two_factor_secret' => 'TESTSECRET123',
        ]);
        $client = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
            'two_factor_enabled' => false,
        ]);

        $response = $this->actingAs($client)->post(route('chat.send'), [
            'attachment' => UploadedFile::fake()->image('preuve.png', 120, 80),
        ], [
            'Accept' => 'application/json',
        ]);

        $message = ChatMessage::query()->sole();
        $attachmentUrl = route('chat.attachment', ['message' => $message->id], false);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message.attachment_url', $attachmentUrl)
            ->assertJsonPath('message.is_image_attachment', true);

        Storage::disk('public')->assertExists($message->attachment_path);

        $this->actingAs($client)
            ->get($attachmentUrl)
            ->assertOk()
            ->assertHeader('content-type', 'image/png');

        $this->actingAs($admin)
            ->withSession(['2fa_passed' => true])
            ->get($attachmentUrl)
            ->assertOk();
    }

    public function test_chat_attachment_is_not_visible_to_an_unrelated_user(): void
    {
        Storage::fake('public');

        $sender = User::factory()->create();
        $receiver = User::factory()->create(['role' => 'admin']);
        $outsider = User::factory()->create();
        $path = UploadedFile::fake()->image('confidentiel.png')->store('chat_attachments', 'public');

        $message = ChatMessage::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => '',
            'attachment_path' => $path,
            'attachment_name' => 'confidentiel.png',
            'attachment_type' => 'image/png',
            'attachment_size' => Storage::disk('public')->size($path),
        ]);

        $this->actingAs($outsider)
            ->get(route('chat.attachment', ['message' => $message]))
            ->assertForbidden();
    }
}
