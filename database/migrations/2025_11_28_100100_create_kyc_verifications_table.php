<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create kyc_verifications table to track KYC lifecycle per user.
     */
    public function up(): void
    {
        Schema::create('kyc_verifications', function (Blueprint $table) {
            $table->id();

            // Link to the user who is being verified
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // KYC workflow status
            $table->enum('status', ['pending', 'in_review', 'approved', 'rejected', 'expired'])
                ->default('pending')
                ->index();

            // Provider / reference info (can be "mock" initially)
            $table->string('provider');
            $table->string('reference')->nullable();

            // Scoring and PEP flags
            $table->decimal('risk_score', 5, 2)->nullable();
            $table->boolean('pep_flag')->default(false)->index();
            $table->json('pep_details')->nullable();

            // Review metadata
            $table->text('rejection_reason')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Helpful indexes
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Drop kyc_verifications table.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_verifications');
    }
};

