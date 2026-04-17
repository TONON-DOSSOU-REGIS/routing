<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('stop_message')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')
            ->whereRaw('CHAR_LENGTH(stop_message) > 255')
            ->update([
                'stop_message' => DB::raw('LEFT(stop_message, 255)'),
            ]);

        Schema::table('settings', function (Blueprint $table) {
            $table->string('stop_message', 255)->change();
        });
    }
};
