<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoginAttempt;
use App\Services\LoginSecurityService;

class TestLoginSecuritySeeder extends Seeder
{
    public function run(): void
    {
        $service = app(LoginSecurityService::class);
        
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('Testing Login Security System');
        $this->command->info('═══════════════════════════════════════');
        $this->command->newLine();

        $testEmail = 'test@example.com';

        // Simulate 5 failed login attempts using the service
        $this->command->info('Simulating 5 failed login attempts...');
        
        for ($i = 1; $i <= 5; $i++) {
            // Manually set request IP for testing
            request()->merge(['test_ip' => '192.168.1.100']);
            
            $service->recordAttempt($testEmail, false, 'Invalid credentials');
            
            $this->command->info("  Attempt {$i}/5 - Failed");
            
            // Check remaining attempts
            $remaining = $service->getRemainingAttempts($testEmail);
            if ($remaining > 0) {
                $this->command->warn("    → {$remaining} attempt(s) remaining");
            } else {
                $this->command->error("    → LOCKOUT TRIGGERED!");
            }
        }
        
        $this->command->newLine();
        
        // Check if locked
        $lockInfo = $service->isLocked($testEmail);
        
        if ($lockInfo['locked']) {
            $this->command->error('✗ ACCOUNT LOCKED!');
            $this->command->error('  Reason: ' . ucfirst($lockInfo['reason']) . ' lockout');
            $this->command->error('  Duration: ' . ceil($lockInfo['remaining_seconds'] / 60) . ' minute(s)');
            $this->command->error('  Message: ' . $service->getLockoutMessage($lockInfo));
        } else {
            $this->command->warn('⚠ Account should be locked but is not!');
        }
        
        $this->command->newLine();
        
        // Show statistics
        $failedCount = LoginAttempt::where('email', $testEmail)
            ->where('successful', false)
            ->count();
            
        $this->command->info('Statistics:');
        $this->command->info("  Total failed attempts: {$failedCount}");
        $this->command->info("  Test email: {$testEmail}");
        $this->command->info("  Lockout threshold: " . $service->getMaxAttempts());
        $this->command->info("  Lockout duration: " . $service->getLockoutDuration() . " minutes");
        
        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('✓ Test completed!');
        $this->command->info('═══════════════════════════════════════');
        $this->command->newLine();
        
        $this->command->info('View results at:');
        $this->command->info('  • Login Attempts: http://localhost/admin/login-security');
        $this->command->info('  • Lockouts: http://localhost/admin/login-security/lockouts');
        $this->command->newLine();
        
        $this->command->warn('To test lockout on login page:');
        $this->command->warn('  1. Go to http://localhost/login');
        $this->command->warn('  2. Try to login with: ' . $testEmail);
        $this->command->warn('  3. You should see the lockout message');
    }
}
