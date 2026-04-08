<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserActivity;
use App\Services\AnomalyDetectionService;

class TestAnomalyDetectionSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(AnomalyDetectionService::class);
        $user = User::where('role', '!=', 'admin')->first();

        if (!$user) {
            $this->command->error('No non-admin users found. Please create a user first.');
            return;
        }

        $this->command->info("Testing anomaly detection for user: {$user->name}");
        $this->command->newLine();

        // First, learn the baseline
        $this->command->info('Step 1: Learning baseline behavior...');
        $service->learnUserBehavior($user->id);
        $this->command->info('✓ Baseline learned');
        $this->command->newLine();

        // Test 1: Unusual login time (3 AM)
        $this->command->info('Test 1: Creating login at unusual hour (3 AM)...');
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'login',
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'metadata' => [],
            'activity_at' => now()->setHour(3)->setMinute(0)
        ]);
        $service->detectAnomalies($user->id, 'login', [
            'ip_address' => '192.168.1.100'
        ]);
        $this->command->info('✓ Anomaly detection triggered');
        $this->command->newLine();

        // Test 2: Unknown IP address
        $this->command->info('Test 2: Creating login from unknown IP...');
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'login',
            'ip_address' => '203.0.113.42', // Unknown IP
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'metadata' => [],
            'activity_at' => now()
        ]);
        $service->detectAnomalies($user->id, 'login', [
            'ip_address' => '203.0.113.42'
        ]);
        $this->command->info('✓ Anomaly detection triggered');
        $this->command->newLine();

        // Test 3: Unusually large purchase
        $this->command->info('Test 3: Creating unusually large purchase ($5000)...');
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'purchase',
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'metadata' => ['amount' => 5000],
            'activity_at' => now()
        ]);
        $service->detectAnomalies($user->id, 'purchase', [
            'amount' => 5000
        ]);
        $this->command->info('✓ Anomaly detection triggered');
        $this->command->newLine();

        // Test 4: Rapid purchases
        $this->command->info('Test 4: Creating rapid purchases (10 in 1 hour)...');
        for ($i = 0; $i < 10; $i++) {
            UserActivity::create([
                'user_id' => $user->id,
                'activity_type' => 'purchase',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'metadata' => ['amount' => rand(50, 150)],
                'activity_at' => now()->subMinutes(rand(1, 59))
            ]);
        }
        $service->detectAnomalies($user->id, 'purchase', [
            'amount' => 100
        ]);
        $this->command->info('✓ Anomaly detection triggered');
        $this->command->newLine();

        $anomalyCount = \App\Models\AnomalyDetection::where('user_id', $user->id)->count();
        
        $this->command->info("═══════════════════════════════════════");
        $this->command->info("✓ Test completed successfully!");
        $this->command->info("Total anomalies detected: {$anomalyCount}");
        $this->command->info("═══════════════════════════════════════");
        $this->command->newLine();
        $this->command->info("Visit: http://localhost/admin/anomaly-detection");
        $this->command->info("To view and review the detected anomalies");
    }
}
