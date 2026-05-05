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
        // First, check if columns already exist
        $hasRefundedColumns = Schema::hasColumn('transactions', 'refunded_at');
        
        if (!$hasRefundedColumns) {
            // Add columns for refund tracking
            Schema::table('transactions', function (Blueprint $table) {
                $table->timestamp('refunded_at')->nullable()->after('updated_at');
                $table->unsignedBigInteger('refunded_by')->nullable()->after('refunded_at');
                $table->text('refund_reason')->nullable()->after('refunded_by');
            });
        }
        
        // Check if foreign key exists before adding
        if ($this->usesMySql()) {
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'transactions' 
                AND CONSTRAINT_NAME = 'transactions_refunded_by_foreign'
            ");
        } else {
            $foreignKeys = [['CONSTRAINT_NAME' => 'sqlite_skip']];
        }

        if (empty($foreignKeys) && Schema::hasColumn('transactions', 'refunded_by')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->foreign('refunded_by')->references('id')->on('users')->onDelete('set null');
            });
        }
        
        // Update enum to include 'refunded' status
        if ($this->usesMySql()) {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'success', 'on_hold', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, update any 'refunded' status to 'failed' to avoid truncation error
        DB::statement("UPDATE transactions SET status = 'failed' WHERE status = 'refunded'");

        // Check if foreign key exists before dropping
        $foreignKeys = $this->usesMySql()
            ? DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'transactions'
                AND CONSTRAINT_NAME = 'transactions_refunded_by_foreign'
            ")
            : [];

        if (!empty($foreignKeys)) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['refunded_by']);
            });
        }

        // Check if columns exist before dropping
        $hasRefundedColumns = Schema::hasColumn('transactions', 'refunded_at');

        if ($hasRefundedColumns) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn(['refunded_at', 'refunded_by', 'refund_reason']);
            });
        }

        // Revert status enum to original
        if ($this->usesMySql()) {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'success', 'on_hold', 'failed') NOT NULL DEFAULT 'pending'");
        }
    }

    private function usesMySql(): bool
    {
        return DB::getDriverName() === 'mysql';
    }
};
