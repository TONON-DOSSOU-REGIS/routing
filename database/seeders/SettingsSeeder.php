<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default settings if they don't exist
        if (!Setting::exists()) {
            Setting::create([
                'stop_percentage' => 0,
                'stop_message' => 'Votre transaction est en cours de traitement.',
                'target_user_id' => null,
                'is_global' => true,
            ]);
        }
    }
}

