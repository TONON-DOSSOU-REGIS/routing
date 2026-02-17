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
        $adminEmail = (string) config('mail.admin_address', 'admin@valtrixbank.com');

        // Keep a single canonical admin account/email.
        $admin = User::where('email', $adminEmail)->first();
        if (!$admin) {
            $admin = User::where('role', 'admin')->first();
        }

        if ($admin) {
            $admin->update([
                'email' => $adminEmail,
                'last_name' => 'Valtrix Bank',
                'role' => 'admin',
                'status' => 'active',
            ]);
        } else {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'Valtrix Bank',
                'email' => $adminEmail,
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


