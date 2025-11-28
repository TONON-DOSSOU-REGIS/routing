<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\KycVerification;
use App\Models\KycDocument;

class KycCriticalPathTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_kyc_endpoints(): void
    {
        // Provide CSRF token via session to avoid 419 while keeping auth middleware active
        $token = 'test_csrf_token';
        $this->withSession(['_token' => $token]);

        $this->get('/kyc')->assertRedirect('/login');
        $this->get('/kyc/status')->assertRedirect('/login');
        $this->post('/kyc/submit', [], ['X-CSRF-TOKEN' => $token])->assertRedirect('/login');
    }

    public function test_user_can_submit_kyc_with_valid_documents_and_status_becomes_pending(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $this->actingAs($user);

        // Provide CSRF token via session to avoid 419 while keeping middleware active
        $token = 'test_csrf_token';
        $this->withSession(['_token' => $token]);

        $response = $this->post('/kyc/submit', [
            // Use generic file creation to avoid GD dependency
            'id_front' => UploadedFile::fake()->create('id_front.jpg', 100, 'image/jpeg'),
            'id_back' => UploadedFile::fake()->create('id_back.jpg', 100, 'image/jpeg'),
            'selfie' => UploadedFile::fake()->create('selfie.jpg', 100, 'image/jpeg'),
            'proof_of_address' => UploadedFile::fake()->create('poa.pdf', 100, 'application/pdf'),
        ], ['X-CSRF-TOKEN' => $token]);

        $response->assertCreated()
                 ->assertJson(['kyc_status' => 'pending']);

        $user->refresh();
        $this->assertSame('pending', $user->kyc_status);

        // One verification created and linked to the user
        $this->assertDatabaseCount('kyc_verifications', 1);
        $verification = KycVerification::first();
        $this->assertNotNull($verification);
        $this->assertSame($user->id, $verification->user_id);

        // Four documents created for that verification
        $this->assertDatabaseCount('kyc_documents', 4);
        $this->assertSame(4, KycDocument::where('kyc_verification_id', $verification->id)->count());

        // GET /kyc returns latest verification with documents
        $this->get('/kyc')
            ->assertOk()
            ->assertJsonStructure([
                'kyc_status',
                'latest_verification' => [
                    'id',
                    'status',
                    'provider',
                    'reference',
                    'submitted_at',
                    'reviewed_at',
                    'documents',
                ],
            ]);

        // GET /kyc/status returns current status and flags
        $this->get('/kyc/status')
            ->assertOk()
            ->assertJsonStructure([
                'kyc_status',
                'kyc_pep_flag',
                'kyc_last_screened_at',
                'kyc_risk_score',
            ]);
    }
}

