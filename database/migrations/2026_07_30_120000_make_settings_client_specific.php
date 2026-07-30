<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateClientIds = DB::table('settings')
            ->whereNotNull('target_user_id')
            ->select('target_user_id')
            ->groupBy('target_user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('target_user_id');

        foreach ($duplicateClientIds as $clientId) {
            $settingToKeep = DB::table('settings')
                ->where('target_user_id', $clientId)
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->value('id');

            DB::table('settings')
                ->where('target_user_id', $clientId)
                ->where('id', '!=', $settingToKeep)
                ->delete();
        }

        DB::table('settings')->whereNull('target_user_id')->delete();

        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('target_user_id')->nullable(false)->change();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('is_global');
            $table->unique('target_user_id', 'settings_target_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique('settings_target_user_id_unique');
            $table->boolean('is_global')->default(false);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('target_user_id')->nullable()->change();
        });
    }
};
