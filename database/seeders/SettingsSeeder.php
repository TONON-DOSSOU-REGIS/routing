<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('role', 'user')->each(function (User $user) {
            Setting::firstOrCreate(
                ['target_user_id' => $user->id],
                [
                    'stop_percentage' => 0,
                    'stop_message' => 'Votre transaction est en cours de traitement.',
                ]
            );
        });
    }
}
