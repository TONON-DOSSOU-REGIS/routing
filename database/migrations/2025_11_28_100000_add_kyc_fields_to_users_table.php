<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Add KYC/AML columns to users table.
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // KYC status lifecycle
            $table->enum('kyc_status', ['not_started', 'pending', 'in_review', 'approved', 'rejected', 'expired'])
                  ->default('not_started')
                  ->after('status');

            // Risk score from screening/verification (nullable until computed)
            $table->decimal('kyc_risk_score', 5, 2)->nullable()->after('kyc_status');

            // Last time the user was screened against sanctions/PEP lists
            $table->timestamp('kyc_last_screened_at')->nullable()->after('kyc_risk_score');

            // Politically Exposed Person flag
            $table->boolean('kyc_pep_flag')->default(false)->after('kyc_last_screened_at');

            // Helpful indexes for admin/review filters
            $table->index('kyc_status');
            $table->index('kyc_pep_flag');
        });
    }

    /**
     * Revert KYC/AML columns from users table.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop indexes first (avoid issues on some drivers)
            $table->dropIndex(['kyc_status']);
            $table->dropIndex(['kyc_pep_flag']);

            $table->dropColumn([
                'kyc_status',
                'kyc_risk_score',
                'kyc_last_screened_at',
                'kyc_pep_flag',
            ]);
        });
    }
};

