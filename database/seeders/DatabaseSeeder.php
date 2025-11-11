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
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'BankPro',
            'email' => 'admin@bankpro.com',
            'phone' => '+22912345678',
            'address' => '123 Admin Street',
            'country' => 'Benin',
            'city' => 'Porto-Novo',
            'date_of_birth' => '1980-01-01',
            'id_type' => 'CNI',
            'id_number' => '123456789',
            'role' => 'admin',
            'balance' => 0,
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Create default settings
        Setting::create([
            'stop_percentage' => 70,
            'stop_message' => 'Transaction suspendue pour vérification de sécurité.',
        ]);
    }
}
