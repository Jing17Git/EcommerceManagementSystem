<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;

class UserActivitySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', '!=', 'admin')->take(5)->get();

        foreach ($users as $user) {
            // Generate normal login pattern (30 days of history)
            for ($i = 30; $i >= 1; $i--) {
                $date = now()->subDays($i);
                
                // Normal login times: 8-10 AM and 6-8 PM
                $morningLogin = $date->copy()->setHour(rand(8, 10))->setMinute(rand(0, 59));
                $eveningLogin = $date->copy()->setHour(rand(18, 20))->setMinute(rand(0, 59));
                
                UserActivity::create([
                    'user_id' => $user->id,
                    'activity_type' => 'login',
                    'ip_address' => '192.168.1.' . rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'metadata' => [],
                    'activity_at' => $morningLogin
                ]);
                
                if (rand(0, 1)) {
                    UserActivity::create([
                        'user_id' => $user->id,
                        'activity_type' => 'login',
                        'ip_address' => '192.168.1.' . rand(1, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        'metadata' => [],
                        'activity_at' => $eveningLogin
                    ]);
                }
            }

            // Generate normal shopping pattern
            for ($i = 30; $i >= 1; $i--) {
                $date = now()->subDays($i);
                
                // View products
                for ($j = 0; $j < rand(3, 8); $j++) {
                    UserActivity::create([
                        'user_id' => $user->id,
                        'activity_type' => 'view_product',
                        'ip_address' => '192.168.1.' . rand(1, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        'metadata' => ['product_id' => rand(1, 50)],
                        'activity_at' => $date->copy()->addHours(rand(9, 20))->addMinutes(rand(0, 59))
                    ]);
                }
                
                // Occasional purchases (normal amounts: $20-$200)
                if (rand(0, 3) === 0) {
                    UserActivity::create([
                        'user_id' => $user->id,
                        'activity_type' => 'purchase',
                        'ip_address' => '192.168.1.' . rand(1, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        'metadata' => ['amount' => rand(20, 200)],
                        'activity_at' => $date->copy()->addHours(rand(10, 19))->addMinutes(rand(0, 59))
                    ]);
                }
            }
        }

        $this->command->info('Generated normal user activity patterns for ' . $users->count() . ' users');
    }
}
