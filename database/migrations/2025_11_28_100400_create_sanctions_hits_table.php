<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create sanctions_hits table to store individual matches from screenings.
     */
    public function up(): void
    {
        Schema::create('sanctions_hits', function (Blueprint $table) {
            $table->id();

            // Link to AML screening
            $table->foreignId('aml_screening_id')
                ->constrained('aml_screenings')
                ->cascadeOnDelete();

            // Basic hit info
            $table->string('list_name', 191)->index(); // e.g., OFAC, UN, EU, HMT
            $table->string('entity_name', 191);
            $table->date('dob')->nullable();
            $table->string('country', 100)->nullable();

            // Matching score (if provided by provider)
            $table->decimal('score', 5, 2)->nullable();

            // Raw provider payload for the hit
            $table->json('raw')->nullable();

            $table->timestamps();

            // Helpful composite indexes
            $table->index(['aml_screening_id', 'list_name']);
            $table->index(['aml_screening_id', 'score']);
        });
    }

    /**
     * Drop sanctions_hits table.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanctions_hits');
    }
};

