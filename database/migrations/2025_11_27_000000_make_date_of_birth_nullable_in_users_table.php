<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Replace NULL dates before making the column NOT NULL to avoid truncation
        \Illuminate\Support\Facades\DB::table('users')
            ->whereNull('date_of_birth')
            ->update(['date_of_birth' => '1970-01-01']);

        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable(false)->change();
        });
    }
};

