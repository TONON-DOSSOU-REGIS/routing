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
            // Add 'pending' value to 'status' enum on MySQL and ensure activation_code column exists.
            DB::statement("ALTER TABLE users MODIFY COLUMN `status` ENUM('active', 'suspended', 'pending') NOT NULL DEFAULT 'pending'");
        }

        if (!Schema::hasColumn('users', 'activation_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('activation_code')->nullable()->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->usesMySql()) {
            DB::statement("ALTER TABLE users MODIFY COLUMN `status` ENUM('active', 'suspended') NOT NULL DEFAULT 'active'");
        }

        if (Schema::hasColumn('users', 'activation_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('activation_code');
            });
        }
    }

    private function usesMySql(): bool
    {
        return DB::getDriverName() === 'mysql';
    }
};
