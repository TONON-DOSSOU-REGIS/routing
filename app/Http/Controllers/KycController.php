<?php

namespace App\Http\Controllers;

use App\Models\KycVerification;
use App\Models\KycDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KycController extends Controller
{
    /**
     * Show KYC status and (future) upload form.
     * For now, returns JSON status placeholder until Blade view is added.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $latest = KycVerification::where('user_id', $user->id)
            ->latest()
            ->with('documents')
            ->first();

        return response()->json([
            'kyc_status' => $user->kyc_status ?? 'not_started',
            'latest_verification' => $latest ? [
                'id' => $latest->id,
                'status' => $latest->status,
                'provider' => $latest->provider,
                'reference' => $latest->reference,
                'submitted_at' => $latest->submitted_at,
                'reviewed_at' => $latest->reviewed_at,
                'documents' => $latest->documents->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'type' => $doc->type,
                        'mime_type' => $doc->mime_type,
                        'size' => $doc->size,
                        'verified' => $doc->verified,
                        'verified_at' => $doc->verified_at,
                    ];
                }),
            ] : null,
        ]);
    }

    /**
     * Submit KYC documents:
     * - id_front
     * - id_back
     * - selfie
     * - proof_of_address
     */
    public function submit(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'id_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'selfie' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'proof_of_address' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $user) {
            // Create a new verification case
            $verification = KycVerification::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'provider' => 'mock', // initial provider placeholder
                'reference' => null,
                'risk_score' => null,
                'pep_flag' => false,
                'pep_details' => null,
                'rejection_reason' => null,
                'submitted_at' => now(),
            ]);

            // Helper to store and create document record
            $storeDoc = function (string $field, string $type) use ($request, $verification, $user) {
                $file = $request->file($field);
                $path = $file->store("kyc/{$user->id}", ['disk' => 'local']);

                KycDocument::create([
                    'kyc_verification_id' => $verification->id,
                    'type' => $type,
                    'path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'checksum' => hash_file('sha256', $file->getRealPath()),
                    'extracted_data' => null,
                    'verified' => false,
                    'verified_at' => null,
                ]);
            };

            $storeDoc('id_front', 'id_front');
            $storeDoc('id_back', 'id_back');
            $storeDoc('selfie', 'selfie');
            $storeDoc('proof_of_address', 'proof_of_address');

            // Update user's overall KYC status
            $user->kyc_status = 'pending';
            $user->save();
        });

        return response()->json([
            'message' => 'KYC submitted successfully. Your verification is now pending review.',
            'kyc_status' => 'pending',
        ], 201);
    }

    /**
     * Polling endpoint to check current KYC status quickly.
     */
    public function status()
    {
        $user = Auth::user();

        return response()->json([
            'kyc_status' => $user->kyc_status ?? 'not_started',
            'kyc_pep_flag' => (bool) ($user->kyc_pep_flag ?? false),
            'kyc_last_screened_at' => $user->kyc_last_screened_at,
            'kyc_risk_score' => $user->kyc_risk_score,
        ]);
    }
}

