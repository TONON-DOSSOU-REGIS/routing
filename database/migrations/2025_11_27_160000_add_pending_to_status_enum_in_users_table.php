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
            // For MySQL, modify enum type by using raw SQL.
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'suspended', 'pending') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->usesMySql()) {
            // Revert enum change to original enum without 'pending'.
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'suspended') NOT NULL DEFAULT 'active'");
        }
    }

    private function usesMySql(): bool
    {
        return DB::getDriverName() === 'mysql';
    }
};
