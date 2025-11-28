<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create aml_screenings table to store sanctions/PEP screening results.
     */
    public function up(): void
    {
        Schema::create('aml_screenings', function (Blueprint $table) {
            $table->id();

            // Link to the screened user
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Provider information (e.g., "mock", "external_vendor")
            $table->string('provider', 191);

            // Query payload used to screen (normalized user data)
            $table->json('query');

            // Screening status & score
            $table->enum('status', ['clear', 'potential_match', 'match'])
                ->default('clear')
                ->index();

            $table->decimal('score', 5, 2)->nullable();

            // Raw provider response (normalized or original)
            $table->json('result')->nullable();

            // Timestamps for lifecycle
            $table->timestamp('screened_at')->useCurrent();
            $table->timestamp('rescreen_after')->nullable();
            $table->timestamp('last_rescreened_at')->nullable();

            $table->timestamps();

            // Helpful composite indexes
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'screened_at']);
        });
    }

    /**
     * Drop aml_screenings table.
     */
    public function down(): void
    {
        Schema::dropIfExists('aml_screenings');
    }
};

