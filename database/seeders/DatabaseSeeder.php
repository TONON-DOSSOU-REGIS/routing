<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
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
        // Create admin user if not exists
        if (!User::where('email', 'admin@sgbank.com')->exists()) {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'SG BANK',
                'email' => 'admin@sgbank.com',
                'phone' => '+22912345678',
                'address' => '123 Admin Street',
                'role' => 'admin',
                'balance' => 0,
                'status' => 'active',
                'password' => Hash::make('password'),
                'activation_code' => '1234',
                'date_of_birth' => '1970-01-01',
                'id_number' => '0000000000', // Added to fix seeding error
            ]);
        }

        // Create default settings
        Setting::create([
            'stop_percentage' => 70,
            'stop_message' => 'Transaction suspendue pour vérification de sécurité.',
        ]);
    }
}

