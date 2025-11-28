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
            $table->string('activation_code')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Guard against dropping non-existent column during rollback
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'activation_code')) {
            \Illuminate\Support\Facades\Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('activation_code');
            });
        }
    }
};

