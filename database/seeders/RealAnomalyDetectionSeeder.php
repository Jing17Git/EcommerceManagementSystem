<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AnomalyDetection;
use App\Models\UserActivity;
use App\Models\BehaviorBaseline;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RealAnomalyDetectionSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Generating real anomaly detection data...');

        // Get all users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found in database!');
            return;
        }

        $this->command->info("Found {$users->count()} users");

        // Get admin user for reviews
        $admin = User::where('role', 'administrator')->first();
        if (!$admin) {
            $this->command->warn('No admin user found. Skipping reviewed anomalies.');
        }

        // Clear existing anomalies
        AnomalyDetection::truncate();
        $this->command->info('Cleared existing anomalies');

        // Create behavior baselines for users
        $this->createBehaviorBaselines($users);

        // Generate various types of anomalies
        $this->generateSuspiciousLoginAnomalies($users, $admin);
        $this->generateUnusualShoppingAnomalies($users, $admin);
        $this->generateAbnormalSellerAnomalies($users, $admin);
        $this->generateUserActivityAnomalies($users, $admin);

        $totalAnomalies = AnomalyDetection::count();
        $this->command->newLine();
        $this->command->info("✓ Generated {$totalAnomalies} realistic anomalies");
        
        // Show summary
        $this->showSummary();
    }

    private function createBehaviorBaselines($users)
    {
        foreach ($users as $user) {
            // Login pattern baseline
            BehaviorBaseline::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'behavior_type' => 'login_pattern'
                ],
                [
                    'baseline_data' => json_encode([
                        'avg_session_duration' => rand(300, 1800),
                        'common_login_hours' => [9, 10, 11, 14, 15, 16, 17, 18],
                        'common_ip_addresses' => ['192.168.1.1', '10.0.0.1'],
                        'avg_pages_per_session' => rand(5, 20)
                    ]),
                    'learned_at' => now()
                ]
            );

            // Shopping pattern baseline (for buyers)
            if ($user->role === 'buyer') {
                BehaviorBaseline::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'behavior_type' => 'shopping_pattern'
                    ],
                    [
                        'baseline_data' => json_encode([
                            'avg_orders_per_week' => rand(1, 5),
                            'avg_order_value' => rand(50, 500),
                            'common_shopping_hours' => [10, 11, 12, 14, 15, 16, 19, 20]
                        ]),
                        'learned_at' => now()
                    ]
                );
            }

            // Seller activity baseline (for sellers)
            if ($user->role === 'seller') {
                BehaviorBaseline::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'behavior_type' => 'seller_activity'
                    ],
                    [
                        'baseline_data' => json_encode([
                            'avg_products_per_day' => rand(2, 5),
                            'avg_product_price' => rand(100, 1000),
                            'avg_orders_per_day' => rand(5, 20)
                        ]),
                        'learned_at' => now()
                    ]
                );
            }
        }
        $this->command->info('✓ Created behavior baselines');
    }

    private function generateSuspiciousLoginAnomalies($users, $admin)
    {
        $count = 0;
        
        foreach ($users->random(min(2, $users->count())) as $user) {
            // Suspicious login from unusual location
            AnomalyDetection::create([
                'user_id' => $user->id,
                'anomaly_type' => 'suspicious_login',
                'severity' => 'high',
                'description' => "Login attempt from unusual location (IP: 185.220.101.{rand(1, 255)}) at unusual time (3:47 AM)",
                'detection_data' => json_encode([
                    'ip_address' => "185.220.101." . rand(1, 255),
                    'location' => 'Unknown Location',
                    'time' => '03:47:00',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'expected_ips' => ['192.168.1.1', '10.0.0.1'],
                    'expected_hours' => [9, 10, 11, 14, 15, 16, 17, 18]
                ]),
                'detected_at' => now()->subHours(rand(1, 48)),
                'status' => 'pending'
            ]);
            $count++;

            // Multiple failed login attempts
            if (rand(0, 1) && $admin) {
                AnomalyDetection::create([
                    'user_id' => $user->id,
                    'anomaly_type' => 'suspicious_login',
                    'severity' => 'critical',
                    'description' => "Multiple failed login attempts detected: 8 attempts in 5 minutes from IP 203.0.113." . rand(1, 255),
                    'detection_data' => json_encode([
                        'failed_attempts' => 8,
                        'time_window' => '5 minutes',
                        'ip_address' => "203.0.113." . rand(1, 255),
                        'last_attempt' => now()->subMinutes(rand(10, 120))->toDateTimeString()
                    ]),
                    'detected_at' => now()->subHours(rand(2, 72)),
                    'status' => rand(0, 1) ? 'pending' : 'reviewed',
                    'reviewed_at' => rand(0, 1) ? now()->subHours(rand(1, 24)) : null,
                    'reviewed_by' => rand(0, 1) ? $admin->id : null,
                    'review_notes' => rand(0, 1) ? 'Investigated - appears to be brute force attempt. User notified.' : null
                ]);
                $count++;
            }
        }

        $this->command->info("✓ Generated {$count} suspicious login anomalies");
    }

    private function generateUnusualShoppingAnomalies($users, $admin)
    {
        $count = 0;
        $buyers = $users->where('role', 'buyer');

        if ($buyers->isEmpty()) {
            $this->command->warn('No buyers found, skipping shopping anomalies');
            return;
        }

        foreach ($buyers->random(min(2, $buyers->count())) as $user) {
            // Unusual purchase amount
            AnomalyDetection::create([
                'user_id' => $user->id,
                'anomaly_type' => 'unusual_shopping',
                'severity' => 'medium',
                'description' => "Unusual purchase amount detected: ₱" . number_format(rand(5000, 15000), 2) . " (3x higher than average)",
                'detection_data' => json_encode([
                    'order_amount' => rand(5000, 15000),
                    'avg_order_amount' => rand(500, 2000),
                    'deviation' => '3x higher',
                    'order_time' => now()->subHours(rand(1, 24))->toDateTimeString()
                ]),
                'detected_at' => now()->subHours(rand(1, 48)),
                'status' => 'pending'
            ]);
            $count++;

            // Rapid consecutive orders
            if (rand(0, 1) && $admin) {
                AnomalyDetection::create([
                    'user_id' => $user->id,
                    'anomaly_type' => 'unusual_shopping',
                    'severity' => 'high',
                    'description' => "Rapid consecutive orders: " . rand(5, 10) . " orders placed within 15 minutes",
                    'detection_data' => json_encode([
                        'order_count' => rand(5, 10),
                        'time_window' => '15 minutes',
                        'total_amount' => rand(3000, 8000),
                        'avg_orders_per_day' => 1
                    ]),
                    'detected_at' => now()->subHours(rand(3, 96)),
                    'status' => rand(0, 1) ? 'resolved' : 'pending',
                    'reviewed_at' => rand(0, 1) ? now()->subHours(rand(1, 48)) : null,
                    'reviewed_by' => rand(0, 1) ? $admin->id : null,
                    'review_notes' => rand(0, 1) ? 'Legitimate bulk purchase confirmed with user.' : null
                ]);
                $count++;
            }
        }

        $this->command->info("✓ Generated {$count} unusual shopping anomalies");
    }

    private function generateAbnormalSellerAnomalies($users, $admin)
    {
        $count = 0;
        $sellers = $users->where('role', 'seller');

        if ($sellers->isEmpty()) {
            $this->command->warn('No sellers found, skipping seller anomalies');
            return;
        }

        foreach ($sellers->random(min(1, $sellers->count())) as $user) {
            // Unusual product pricing
            AnomalyDetection::create([
                'user_id' => $user->id,
                'anomaly_type' => 'abnormal_seller_activity',
                'severity' => 'medium',
                'description' => "Unusual product pricing detected: Product priced at ₱" . number_format(rand(50000, 100000), 2) . " (10x higher than category average)",
                'detection_data' => json_encode([
                    'product_price' => rand(50000, 100000),
                    'category_avg_price' => rand(5000, 10000),
                    'deviation' => '10x higher',
                    'product_id' => rand(1, 100)
                ]),
                'detected_at' => now()->subHours(rand(1, 72)),
                'status' => 'pending'
            ]);
            $count++;

            // Rapid product listing
            if ($admin) {
                AnomalyDetection::create([
                    'user_id' => $user->id,
                    'anomaly_type' => 'abnormal_seller_activity',
                    'severity' => 'low',
                    'description' => "Rapid product listing: " . rand(20, 50) . " products added within 1 hour",
                    'detection_data' => json_encode([
                        'products_added' => rand(20, 50),
                        'time_window' => '1 hour',
                        'avg_products_per_day' => rand(2, 5)
                    ]),
                    'detected_at' => now()->subDays(rand(1, 7)),
                    'status' => 'false_positive',
                    'reviewed_at' => now()->subDays(rand(1, 5)),
                    'reviewed_by' => $admin->id,
                    'review_notes' => 'Seller was doing bulk import from CSV. Legitimate activity.'
                ]);
                $count++;
            }
        }

        $this->command->info("✓ Generated {$count} abnormal seller anomalies");
    }

    private function generateUserActivityAnomalies($users, $admin)
    {
        $count = 0;

        // Create some user activities first
        foreach ($users->random(min(2, $users->count())) as $user) {
            // Unusual session duration
            if ($admin) {
                AnomalyDetection::create([
                    'user_id' => $user->id,
                    'anomaly_type' => 'suspicious_login',
                    'severity' => 'low',
                    'description' => "Unusual session duration: " . rand(180, 300) . " minutes (3x longer than average)",
                    'detection_data' => json_encode([
                        'session_duration' => rand(180, 300) * 60, // in seconds
                        'avg_session_duration' => rand(15, 30) * 60,
                        'pages_visited' => rand(100, 200)
                    ]),
                    'detected_at' => now()->subHours(rand(12, 168)),
                    'status' => 'reviewed',
                    'reviewed_at' => now()->subHours(rand(1, 72)),
                    'reviewed_by' => $admin->id,
                    'review_notes' => 'User was actively browsing products. Normal behavior.'
                ]);
                $count++;
            }

            // Account access from new device
            if (rand(0, 1)) {
                AnomalyDetection::create([
                    'user_id' => $user->id,
                    'anomaly_type' => 'suspicious_login',
                    'severity' => 'medium',
                    'description' => "Account accessed from new device: iPhone 15 Pro (iOS 17.2) from IP 172.16." . rand(1, 255) . "." . rand(1, 255),
                    'detection_data' => json_encode([
                        'device' => 'iPhone 15 Pro',
                        'os' => 'iOS 17.2',
                        'browser' => 'Safari 17.2',
                        'ip_address' => "172.16." . rand(1, 255) . "." . rand(1, 255),
                        'first_seen' => now()->subHours(rand(1, 48))->toDateTimeString()
                    ]),
                    'detected_at' => now()->subHours(rand(1, 48)),
                    'status' => 'pending'
                ]);
                $count++;
            }
        }

        $this->command->info("✓ Generated {$count} user activity anomalies");
    }

    private function showSummary()
    {
        $this->command->newLine();
        $this->command->info('=== ANOMALY DETECTION SUMMARY ===');
        $this->command->newLine();

        $stats = [
            ['Type', 'Count'],
            ['Suspicious Login', AnomalyDetection::where('anomaly_type', 'suspicious_login')->count()],
            ['Unusual Shopping', AnomalyDetection::where('anomaly_type', 'unusual_shopping')->count()],
            ['Abnormal Seller Activity', AnomalyDetection::where('anomaly_type', 'abnormal_seller_activity')->count()],
        ];
        $this->command->table($stats[0], array_slice($stats, 1));

        $this->command->newLine();
        $statusStats = [
            ['Status', 'Count'],
            ['Pending', AnomalyDetection::where('status', 'pending')->count()],
            ['Reviewed', AnomalyDetection::where('status', 'reviewed')->count()],
            ['Resolved', AnomalyDetection::where('status', 'resolved')->count()],
            ['False Positive', AnomalyDetection::where('status', 'false_positive')->count()],
        ];
        $this->command->table($statusStats[0], array_slice($statusStats, 1));

        $this->command->newLine();
        $severityStats = [
            ['Severity', 'Count'],
            ['Critical', AnomalyDetection::where('severity', 'critical')->count()],
            ['High', AnomalyDetection::where('severity', 'high')->count()],
            ['Medium', AnomalyDetection::where('severity', 'medium')->count()],
            ['Low', AnomalyDetection::where('severity', 'low')->count()],
        ];
        $this->command->table($severityStats[0], array_slice($severityStats, 1));
    }
}
