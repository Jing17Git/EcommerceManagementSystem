<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = User::where('email', 'richarddbautista1@gmail.com')->first();

        if ($existingAdmin) {
            // Update existing user to admin
            $existingAdmin->update([
                'role' => 'administrator',
                'password' => Hash::make('shophubph123'),
            ]);
            
            $this->command->info('✅ Existing user updated to administrator role');
        } else {
            // Create new admin user
            User::create([
                'name' => 'Richard Bautista',
                'email' => 'richarddbautista1@gmail.com',
                'password' => Hash::make('shophubph123'),
                'role' => 'administrator',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('✅ Admin account created successfully');
        }

        $this->command->info('');
        $this->command->info('Admin Login Credentials:');
        $this->command->info('Email: richarddbautista1@gmail.com');
        $this->command->info('Password: shophubph123');
        $this->command->info('Role: Administrator');
    }
}
