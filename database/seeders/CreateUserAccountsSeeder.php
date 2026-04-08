<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUserAccountsSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating user accounts...');

        // Create Admin Account
        $admin = User::create([
            'name' => 'Richard Bautista (Admin)',
            'email' => 'richarddbautista1@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'current_role' => 'administrator',
            'email_verified_at' => now()
        ]);
        $this->command->info('✓ Admin created: ' . $admin->email);

        // Create Seller Account
        $seller = User::create([
            'name' => 'Seller Account',
            'email' => 'binscruz10@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
            'current_role' => 'seller',
            'roles' => ['seller', 'buyer'],
            'email_verified_at' => now(),
            'store_name' => 'Bins Store',
            'store_email' => 'binscruz10@gmail.com',
            'store_description' => 'Quality products from Bins Store',
            'auto_accept_orders' => true,
            'email_notifications' => true
        ]);
        $this->command->info('✓ Seller created: ' . $seller->email);

        // Create Buyer Account
        $buyer = User::create([
            'name' => 'Buyer Account',
            'email' => 'gar041922@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'current_role' => 'buyer',
            'email_verified_at' => now()
        ]);
        $this->command->info('✓ Buyer created: ' . $buyer->email);

        $this->command->newLine();
        $this->command->info('=== ACCOUNTS CREATED SUCCESSFULLY ===');
        $this->command->newLine();
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Administrator', 'richarddbautista1@gmail.com', 'password123'],
                ['Seller', 'binscruz10@gmail.com', 'password123'],
                ['Buyer', 'gar041922@gmail.com', 'password123']
            ]
        );
    }
}
