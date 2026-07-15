<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = (string) config('mail.admin_address', 'admin@zuiderbank.com');

        // Keep a single canonical admin account/email.
        $admin = User::where('email', $adminEmail)->first();
        if (!$admin) {
            $admin = User::where('role', 'admin')->first();
        }

        if ($admin) {
            $admin->update([
                'first_name' => 'Admin',
                'last_name' => 'Zuider Bank S.A',
                'email' => $adminEmail,
                'role' => 'admin',
                'status' => 'active',
            ]);
        } else {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'Zuider Bank S.A',
                'email' => $adminEmail,
                'phone' => '+22912345678',
                'address' => '123 Admin Street',
                'role' => 'admin',
                'balance' => 0,
                'status' => 'active',
                'password' => Hash::make('password'),
                'activation_code' => '1234',
                'date_of_birth' => '1970-01-01',
                'id_number' => '0000000000',
            ]);
        }

        // Create or update the default global settings without keeping duplicates.
        $globalSettings = Setting::where('is_global', true)
            ->whereNull('target_user_id')
            ->orderBy('id')
            ->get();

        $settings = $globalSettings->first() ?? new Setting([
            'is_global' => true,
            'target_user_id' => null,
        ]);

        $settings->fill([
            'stop_percentage' => 70,
            'stop_message' => 'Transaction suspendue pour vérification de sécurité.',
        ])->save();

        $globalSettings->skip(1)->each->delete();
    }
}
