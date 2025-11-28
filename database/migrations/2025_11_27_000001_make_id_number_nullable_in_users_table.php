<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIdNumberNullableInUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Replace NULL values before making the column NOT NULL to avoid data truncation
        \Illuminate\Support\Facades\DB::table('users')
            ->whereNull('id_number')
            ->update(['id_number' => 'N/A']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('id_number')->nullable(false)->change();
        });
    }
}

