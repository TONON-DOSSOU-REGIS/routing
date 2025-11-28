<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create kyc_documents table to store uploaded identity documents.
     */
    public function up(): void
    {
        Schema::create('kyc_documents', function (Blueprint $table) {
            $table->id();

            // Link to KYC verification case
            $table->foreignId('kyc_verification_id')
                ->constrained('kyc_verifications')
                ->cascadeOnDelete();

            // Document metadata
            $table->enum('type', ['id_front', 'id_back', 'selfie', 'proof_of_address'])->index();
            $table->string('path');
            $table->string('mime_type', 191);
            $table->unsignedBigInteger('size');
            $table->string('checksum', 191)->index();

            // Optional OCR/extraction output
            $table->json('extracted_data')->nullable();

            // Verification flags
            $table->boolean('verified')->default(false)->index();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // Helpful indexes
            $table->index(['kyc_verification_id', 'type']);
        });
    }

    /**
     * Drop kyc_documents table.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_documents');
    }
};

