<?php

namespace App\Services;

use App\Models\UserActivity;
use App\Models\BehaviorBaseline;
use App\Models\AnomalyDetection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnomalyDetectionService
{
    // Z-score threshold for anomaly detection
    private const Z_SCORE_THRESHOLD = 3.0;
    
    // Minimum activities required to establish baseline
    private const MIN_BASELINE_ACTIVITIES = 10;

    public function learnUserBehavior($userId)
    {
        $this->learnLoginPattern($userId);
        $this->learnShoppingPattern($userId);
        $this->learnSellerActivity($userId);
    }

    private function learnLoginPattern($userId)
    {
        $logins = UserActivity::where('user_id', $userId)
            ->where('activity_type', 'login')
            ->where('activity_at', '>=', now()->subDays(30))
            ->get();

        if ($logins->count() < self::MIN_BASELINE_ACTIVITIES) {
            return;
        }

        $hourlyDistribution = $logins->groupBy(fn($activity) => $activity->activity_at->hour);
        $ipAddresses = $logins->pluck('ip_address')->unique()->values();
        $timeBetweenLogins = [];

        $sortedLogins = $logins->sortBy('activity_at')->values();
        for ($i = 1; $i < $sortedLogins->count(); $i++) {
            $diff = $sortedLogins[$i]->activity_at->diffInMinutes($sortedLogins[$i - 1]->activity_at);
            $timeBetweenLogins[] = $diff;
        }

        $baselineData = [
            'avg_logins_per_day' => $logins->count() / 30,
            'common_hours' => $hourlyDistribution->map->count()->sortDesc()->take(5)->keys()->toArray(),
            'known_ips' => $ipAddresses->toArray(),
            'avg_time_between_logins' => !empty($timeBetweenLogins) ? array_sum($timeBetweenLogins) / count($timeBetweenLogins) : 0,
            'std_dev_time_between_logins' => !empty($timeBetweenLogins) ? $this->standardDeviation($timeBetweenLogins) : 0,
        ];

        BehaviorBaseline::updateOrCreate(
            ['user_id' => $userId, 'behavior_type' => 'login_pattern'],
            ['baseline_data' => $baselineData, 'learned_at' => now()]
        );
    }

    private function learnShoppingPattern($userId)
    {
        $activities = UserActivity::where('user_id', $userId)
            ->whereIn('activity_type', ['view_product', 'add_to_cart', 'purchase'])
            ->where('activity_at', '>=', now()->subDays(30))
            ->get();

        if ($activities->count() < self::MIN_BASELINE_ACTIVITIES) {
            return;
        }

        $purchases = $activities->where('activity_type', 'purchase');
        $amounts = $purchases->pluck('metadata')->map(fn($m) => $m['amount'] ?? 0)->filter()->values()->toArray();
        
        $baselineData = [
            'avg_views_per_day' => $activities->where('activity_type', 'view_product')->count() / 30,
            'avg_cart_additions_per_day' => $activities->where('activity_type', 'add_to_cart')->count() / 30,
            'avg_purchases_per_day' => $purchases->count() / 30,
            'avg_purchase_amount' => !empty($amounts) ? array_sum($amounts) / count($amounts) : 0,
            'std_dev_purchase_amount' => !empty($amounts) ? $this->standardDeviation($amounts) : 0,
            'max_purchase_amount' => !empty($amounts) ? max($amounts) : 0,
        ];

        BehaviorBaseline::updateOrCreate(
            ['user_id' => $userId, 'behavior_type' => 'shopping_pattern'],
            ['baseline_data' => $baselineData, 'learned_at' => now()]
        );
    }

    private function learnSellerActivity($userId)
    {
        $activities = UserActivity::where('user_id', $userId)
            ->whereIn('activity_type', ['add_product', 'update_product', 'delete_product', 'process_order'])
            ->where('activity_at', '>=', now()->subDays(30))
            ->get();

        if ($activities->count() < self::MIN_BASELINE_ACTIVITIES) {
            return;
        }

        $baselineData = [
            'avg_products_added_per_day' => $activities->where('activity_type', 'add_product')->count() / 30,
            'avg_products_updated_per_day' => $activities->where('activity_type', 'update_product')->count() / 30,
            'avg_orders_processed_per_day' => $activities->where('activity_type', 'process_order')->count() / 30,
        ];

        BehaviorBaseline::updateOrCreate(
            ['user_id' => $userId, 'behavior_type' => 'seller_activity'],
            ['baseline_data' => $baselineData, 'learned_at' => now()]
        );
    }

    public function detectAnomalies($userId, $activityType, $activityData = [])
    {
        switch ($activityType) {
            case 'login':
                return $this->detectLoginAnomaly($userId, $activityData);
            case 'purchase':
                return $this->detectShoppingAnomaly($userId, $activityData);
            case 'add_product':
            case 'update_product':
            case 'delete_product':
                return $this->detectSellerAnomaly($userId, $activityType);
        }
    }

    private function detectLoginAnomaly($userId, $activityData)
    {
        $baseline = BehaviorBaseline::where('user_id', $userId)
            ->where('behavior_type', 'login_pattern')
            ->first();

        if (!$baseline) {
            return;
        }

        $data = $baseline->baseline_data;
        
        // Safety check: ensure data is an array
        if (!is_array($data)) {
            return;
        }
        
        $currentHour = now()->hour;
        $currentIp = $activityData['ip_address'] ?? null;

        // Check for unusual login time
        if (isset($data['common_hours']) && is_array($data['common_hours']) && !in_array($currentHour, $data['common_hours'])) {
            $this->createAnomaly($userId, 'suspicious_login', 'medium', 
                'Login at unusual hour: ' . $currentHour . ':00',
                ['hour' => $currentHour, 'common_hours' => $data['common_hours']]
            );
        }

        // Check for unknown IP address
        if ($currentIp && isset($data['known_ips']) && is_array($data['known_ips']) && !in_array($currentIp, $data['known_ips'])) {
            $this->createAnomaly($userId, 'suspicious_login', 'high', 
                'Login from unknown IP address: ' . $currentIp,
                ['ip_address' => $currentIp, 'known_ips' => $data['known_ips']]
            );
        }

        // Check for rapid successive logins
        $recentLogin = UserActivity::where('user_id', $userId)
            ->where('activity_type', 'login')
            ->where('activity_at', '>=', now()->subMinutes(5))
            ->where('activity_at', '<', now())
            ->latest('activity_at')
            ->first();

        if ($recentLogin) {
            $minutesSinceLastLogin = now()->diffInMinutes($recentLogin->activity_at);
            if ($minutesSinceLastLogin < 1) {
                $this->createAnomaly($userId, 'suspicious_login', 'critical', 
                    'Multiple login attempts within 1 minute',
                    ['minutes_since_last' => $minutesSinceLastLogin]
                );
            }
        }
    }

    private function detectShoppingAnomaly($userId, $activityData)
    {
        $baseline = BehaviorBaseline::where('user_id', $userId)
            ->where('behavior_type', 'shopping_pattern')
            ->first();

        if (!$baseline) {
            return;
        }

        $data = $baseline->baseline_data;
        
        // Safety check: ensure data is an array
        if (!is_array($data)) {
            return;
        }
        
        $amount = $activityData['amount'] ?? 0;

        // Check for unusually large purchase
        if (isset($data['std_dev_purchase_amount']) && $data['std_dev_purchase_amount'] > 0) {
            $zScore = ($amount - $data['avg_purchase_amount']) / $data['std_dev_purchase_amount'];
            
            if ($zScore > self::Z_SCORE_THRESHOLD) {
                $severity = $zScore > 5 ? 'critical' : 'high';
                $this->createAnomaly($userId, 'unusual_shopping', $severity, 
                    'Purchase amount significantly higher than normal: $' . number_format($amount, 2),
                    ['amount' => $amount, 'avg_amount' => $data['avg_purchase_amount'], 'z_score' => $zScore]
                );
            }
        }

        // Check for rapid purchases
        $recentPurchases = UserActivity::where('user_id', $userId)
            ->where('activity_type', 'purchase')
            ->where('activity_at', '>=', now()->subHour())
            ->count();

        $expectedPurchasesPerHour = isset($data['avg_purchases_per_day']) ? $data['avg_purchases_per_day'] / 24 : 0;
        if ($recentPurchases > ($expectedPurchasesPerHour * 5)) {
            $this->createAnomaly($userId, 'unusual_shopping', 'high', 
                'Unusually high number of purchases in short time',
                ['purchases_last_hour' => $recentPurchases, 'expected' => $expectedPurchasesPerHour]
            );
        }
    }

    private function detectSellerAnomaly($userId, $activityType)
    {
        $baseline = BehaviorBaseline::where('user_id', $userId)
            ->where('behavior_type', 'seller_activity')
            ->first();

        if (!$baseline) {
            return;
        }

        $data = $baseline->baseline_data;
        
        // Safety check: ensure data is an array
        if (!is_array($data)) {
            return;
        }
        
        // Check for bulk operations
        $recentActivities = UserActivity::where('user_id', $userId)
            ->where('activity_type', $activityType)
            ->where('activity_at', '>=', now()->subHour())
            ->count();

        $expectedPerHour = ($data['avg_products_added_per_day'] ?? 0) / 24;
        
        if ($recentActivities > ($expectedPerHour * 10)) {
            $this->createAnomaly($userId, 'abnormal_seller_activity', 'medium', 
                'Unusually high number of ' . str_replace('_', ' ', $activityType) . ' operations',
                ['activities_last_hour' => $recentActivities, 'expected' => $expectedPerHour]
            );
        }
    }

    private function createAnomaly($userId, $type, $severity, $description, $detectionData)
    {
        // Avoid duplicate anomalies within 1 hour
        $existing = AnomalyDetection::where('user_id', $userId)
            ->where('anomaly_type', $type)
            ->where('detected_at', '>=', now()->subHour())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return;
        }

        AnomalyDetection::create([
            'user_id' => $userId,
            'anomaly_type' => $type,
            'severity' => $severity,
            'description' => $description,
            'detection_data' => $detectionData,
            'detected_at' => now(),
            'status' => 'pending'
        ]);
    }

    private function standardDeviation($values)
    {
        if (count($values) < 2) {
            return 0;
        }

        $mean = array_sum($values) / count($values);
        $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $values)) / count($values);
        return sqrt($variance);
    }
}
