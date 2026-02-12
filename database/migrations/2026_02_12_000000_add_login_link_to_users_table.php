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
            $table->string('login_link_token', 64)->nullable()->unique()->after('remember_token');
            $table->timestamp('login_link_expires_at')->nullable()->after('login_link_token');
            $table->timestamp('login_link_used_at')->nullable()->after('login_link_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'login_link_token',
                'login_link_expires_at',
                'login_link_used_at',
            ]);
        });
    }
};
