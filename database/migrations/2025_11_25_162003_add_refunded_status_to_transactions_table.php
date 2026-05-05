<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if ($this->usesMySql()) {
            // Add 'refunded' to the status enum on MySQL.
            DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'success', 'on_hold', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
        }
        
        // Add columns for refund tracking
        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('refunded_at')->nullable()->after('updated_at');
            $table->unsignedBigInteger('refunded_by')->nullable()->after('refunded_at');
            $table->text('refund_reason')->nullable()->after('refunded_by');
            
            // Foreign key for admin who refunded
            $table->foreign('refunded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop FK if it exists (ignore if already absent)
        try {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['refunded_by']);
            });
        } catch (\Throwable $e) {
            // foreign key might not exist depending on previous state; ignore
        }

        // Drop columns if they exist (guarded)
        Schema::table('transactions', function (Blueprint $table) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('transactions', 'refunded_at')) {
                $table->dropColumn('refunded_at');
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('transactions', 'refunded_by')) {
                $table->dropColumn('refunded_by');
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('transactions', 'refund_reason')) {
                $table->dropColumn('refund_reason');
            }
        });
        
        if ($this->usesMySql()) {
            // Revert status enum to original on MySQL.
            DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'success', 'on_hold') NOT NULL DEFAULT 'pending'");
        }
    }

    private function usesMySql(): bool
    {
        return DB::getDriverName() === 'mysql';
    }
};
