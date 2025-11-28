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
            $table->string('city')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Replace NULL city values before making the column NOT NULL to avoid truncation
        \Illuminate\Support\Facades\DB::table('users')
            ->whereNull('city')
            ->update(['city' => 'N/A']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable(false)->change();
        });
    }
};

