# Semi-Supervised Anomaly Detection System

## Overview
This system implements semi-supervised machine learning to detect anomalous behavior in your e-commerce platform. It learns what "normal behavior" looks like for each user and automatically flags deviations.

## Features

### 1. **Login Behavior Detection**
- Monitors login times and patterns
- Detects logins from unknown IP addresses
- Flags rapid successive login attempts
- Identifies unusual login hours

### 2. **Shopping Pattern Detection**
- Tracks purchase amounts and frequency
- Detects unusually large purchases (using Z-score analysis)
- Identifies rapid purchase patterns
- Monitors product viewing behavior

### 3. **Seller Activity Detection**
- Monitors product additions/updates/deletions
- Detects bulk operations
- Flags abnormal seller activity patterns

## How It Works

### Learning Phase (Semi-Supervised)
The system automatically learns normal behavior by analyzing:
- **30 days of historical data** minimum
- **Statistical patterns**: averages, standard deviations, percentiles
- **Behavioral baselines**: common hours, known IPs, typical amounts

### Detection Phase
Uses **Z-score analysis** (threshold: 3.0) to identify outliers:
- Compares current behavior against learned baselines
- Calculates statistical deviation
- Assigns severity levels: Low, Medium, High, Critical

## Database Tables

### `user_activities`
Tracks all user actions:
- Login/logout events
- Product views
- Cart additions
- Purchases
- Seller operations

### `behavior_baselines`
Stores learned normal patterns:
- Login patterns (hours, IPs, frequency)
- Shopping patterns (amounts, frequency)
- Seller activity patterns

### `anomaly_detections`
Records detected anomalies:
- Type, severity, description
- Detection data (statistical evidence)
- Review status and notes

## Admin Interface

### Dashboard (`/admin/anomaly-detection`)
- View all detected anomalies
- Filter by status, severity, type
- Statistics: Total, Pending, Critical
- Quick review actions

### Anomaly Details
- Full detection information
- Statistical evidence
- User context
- Review workflow

### Actions
- **Learn Baselines**: Manually trigger learning for all users
- **Review**: Mark as reviewed, resolved, or false positive
- **Add Notes**: Document investigation findings

## Automatic Detection

### Event Listeners
- **Login Event**: Automatically detects login anomalies
- Triggers on every user login
- Compares against learned baseline

### Middleware (Optional)
- `TrackUserActivity`: Tracks all user actions
- Can be added to route groups for comprehensive tracking

## Commands

### Learn Baselines
```bash
php artisan anomaly:detect
```
- Analyzes all user activities
- Updates behavior baselines
- Should be run daily via cron

### Cron Setup
Add to your crontab:
```
0 2 * * * cd /path/to/project && php artisan anomaly:detect
```

## Severity Levels

- **Critical**: Immediate attention required (e.g., multiple rapid logins, Z-score > 5)
- **High**: Suspicious activity (e.g., unknown IP, large purchase, Z-score > 3)
- **Medium**: Unusual but not necessarily malicious (e.g., unusual hours, bulk operations)
- **Low**: Minor deviations from normal behavior

## Anomaly Types

### `suspicious_login`
- Login from unknown IP
- Login at unusual hour
- Rapid successive logins

### `unusual_shopping`
- Purchase amount significantly higher than normal
- Unusually high number of purchases in short time

### `abnormal_seller_activity`
- Bulk product operations
- Unusually high activity rate

## Configuration

### Thresholds (in `AnomalyDetectionService.php`)
```php
Z_SCORE_THRESHOLD = 3.0          // Statistical deviation threshold
MIN_BASELINE_ACTIVITIES = 10     // Minimum activities to establish baseline
```

### Baseline Learning Period
- Default: 30 days of historical data
- Adjustable in service methods

## Usage Examples

### Manual Detection
```php
use App\Services\AnomalyDetectionService;

$service = app(AnomalyDetectionService::class);

// Learn behavior for specific user
$service->learnUserBehavior($userId);

// Detect anomalies for specific activity
$service->detectAnomalies($userId, 'login', [
    'ip_address' => '1.2.3.4',
    'user_agent' => 'Mozilla/5.0...'
]);
```

### Track Custom Activity
```php
use App\Models\UserActivity;

UserActivity::create([
    'user_id' => auth()->id(),
    'activity_type' => 'custom_action',
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
    'metadata' => ['key' => 'value'],
    'activity_at' => now()
]);
```

## Testing

### Generate Sample Data
```bash
php artisan db:seed --class=UserActivitySeeder
```
This creates 30 days of normal activity patterns for testing.

### Simulate Anomalies
1. Login from different IP
2. Login at 3 AM (unusual hour)
3. Make large purchase (>$1000)
4. Multiple rapid logins

## Best Practices

1. **Run baseline learning daily** via cron
2. **Review anomalies regularly** to reduce false positives
3. **Mark false positives** to improve accuracy over time
4. **Monitor critical severity** anomalies immediately
5. **Adjust thresholds** based on your business needs

## Security Considerations

- Anomalies are **indicators**, not proof of malicious activity
- Always investigate before taking action
- Consider user context (travel, device changes, etc.)
- Use as part of broader security strategy

## Performance

- Baseline learning: ~1-2 seconds per user
- Real-time detection: <100ms per activity
- Database indexes optimize query performance
- Consider queueing for high-traffic sites

## Future Enhancements

- Machine learning model integration
- Automated response actions
- Email notifications for critical anomalies
- User behavior clustering
- Predictive anomaly detection
- Integration with fraud prevention systems

## Support

For issues or questions:
1. Check anomaly detection logs
2. Review baseline data in database
3. Verify event listeners are registered
4. Ensure migrations are run
5. Check cron job execution

## API Routes

- `GET /admin/anomaly-detection` - List all anomalies
- `GET /admin/anomaly-detection/{id}` - View anomaly details
- `PUT /admin/anomaly-detection/{id}/review` - Review anomaly
- `POST /admin/anomaly-detection/learn-baselines` - Trigger learning

## Models

- `UserActivity` - Activity tracking
- `BehaviorBaseline` - Learned patterns
- `AnomalyDetection` - Detected anomalies

## Service

- `AnomalyDetectionService` - Core detection logic
  - `learnUserBehavior($userId)` - Learn patterns
  - `detectAnomalies($userId, $type, $data)` - Detect deviations
  - `standardDeviation($values)` - Statistical helper

## Middleware

- `TrackUserActivity` - Automatic activity tracking
  - Add to route groups for comprehensive monitoring
  - Automatically determines activity type from route

## Events & Listeners

- `Login` event → `DetectLoginAnomaly` listener
  - Automatically tracks and analyzes every login
  - No manual intervention required
