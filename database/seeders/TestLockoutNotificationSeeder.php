<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\LoginSecurityService;
use Illuminate\Database\Seeder;

class TestLockoutNotificationSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Testing Login Lockout with Notification...');

        // Create or get test user
        $user = User::firstOrCreate(
            ['email' => 'lockout.test@example.com'],
            [
                'name' => 'Lockout Test User',
                'password' => bcrypt('password123'),
                'role' => 'buyer'
            ]
        );

        $this->command->info("Test user: {$user->email}");

        $loginSecurity = app(LoginSecurityService::class);

        // Simulate 5 failed login attempts
        for ($i = 1; $i <= 5; $i++) {
            $loginSecurity->recordAttempt($user->email, false, 'Invalid credentials');
            $remaining = $loginSecurity->getRemainingAttempts($user->email);
            $this->command->info("Attempt {$i}: {$remaining} attempts remaining");
        }

        // Check lockout status
        $lockInfo = $loginSecurity->isLocked($user->email);
        
        if ($lockInfo['locked']) {
            $this->command->info('✓ Account is now locked!');
            $this->command->info("  Locked until: {$lockInfo['locked_until']}");
            $this->command->info("  Remaining: {$lockInfo['remaining_seconds']} seconds");
            $this->command->info('✓ Email notification should have been sent!');
            $this->command->info('  Check your mail logs or inbox.');
        } else {
            $this->command->error('✗ Account was not locked as expected');
        }

        $this->command->newLine();
        $this->command->info('To clear the lockout:');
        $this->command->line('  DB::table(\'login_lockouts\')->where(\'identifier\', \'' . $user->email . '\')->update([\'failed_attempts\' => 0, \'locked_until\' => null]);');
    }
}
