# Anomaly Detection System - Quick Start Guide

## ✅ Installation Complete!

Your e-commerce platform now has a fully functional semi-supervised anomaly detection system.

## 🎯 What Was Installed

### 1. Database Tables
- ✅ `user_activities` - Tracks all user actions
- ✅ `behavior_baselines` - Stores learned normal behavior
- ✅ `anomaly_detections` - Records detected anomalies

### 2. Core Components
- ✅ `AnomalyDetectionService` - Machine learning detection engine
- ✅ `AnomalyDetectionController` - Admin interface
- ✅ `DetectLoginAnomaly` - Automatic login monitoring
- ✅ `TrackUserActivity` - Activity tracking middleware

### 3. Admin Interface
- ✅ Dashboard at `/admin/anomaly-detection`
- ✅ Filtering by status, severity, type
- ✅ Review workflow
- ✅ Statistics and insights

### 4. Commands
- ✅ `php artisan anomaly:detect` - Learn baselines

## 🚀 Quick Start

### Step 1: Access Admin Dashboard
```
http://localhost/admin/anomaly-detection
```
Login with your admin credentials:
- Email: admin@example.com
- Password: password

### Step 2: Learn Baselines (First Time)
Click the "Learn Baselines" button in the dashboard, or run:
```bash
php artisan anomaly:detect
```

### Step 3: Monitor Anomalies
The system will automatically detect:
- Suspicious logins (unusual times, unknown IPs)
- Unusual shopping patterns (large purchases, rapid buying)
- Abnormal seller activity (bulk operations)

## 📊 Test Results

We've already run tests and detected **2 anomalies**:
- ✓ Login from unknown IP address
- ✓ Unusually large purchase ($5000)

Visit the admin dashboard to review them!

## 🔄 Automatic Detection

The system automatically monitors:
- **Every login** - Checks IP, time, frequency
- **Every purchase** - Analyzes amount and frequency
- **Seller actions** - Monitors product operations

## 📈 How It Works

### Learning Phase
1. Collects 30 days of user activity
2. Calculates statistical baselines:
   - Average login times
   - Known IP addresses
   - Typical purchase amounts
   - Normal activity frequency

### Detection Phase
1. Compares new activity against baseline
2. Uses Z-score analysis (threshold: 3.0)
3. Assigns severity: Low, Medium, High, Critical
4. Creates anomaly record for admin review

## 🎨 Admin Features

### Dashboard View
- Total anomalies count
- Pending reviews count
- Critical anomalies count
- Filter by status/severity/type

### Anomaly Details
- User information
- Detection data (statistical evidence)
- Review workflow
- Add investigation notes

### Review Actions
- Mark as **Reviewed** - Acknowledged
- Mark as **Resolved** - Action taken
- Mark as **False Positive** - Not a real threat

## 🔧 Configuration

### Adjust Detection Sensitivity
Edit `app/Services/AnomalyDetectionService.php`:
```php
// More sensitive (detects more anomalies)
private const Z_SCORE_THRESHOLD = 2.0;

// Less sensitive (fewer false positives)
private const Z_SCORE_THRESHOLD = 4.0;
```

### Change Learning Period
```php
// Use 60 days instead of 30
->where('activity_at', '>=', now()->subDays(60))
```

## 📅 Daily Maintenance

### Setup Cron Job (Recommended)
Add to crontab to run daily at 2 AM:
```bash
0 2 * * * cd /path/to/EcommerceManagementSystem && php artisan anomaly:detect
```

This keeps baselines up-to-date with latest user behavior.

## 🧪 Testing

### Generate Sample Data
```bash
php artisan db:seed --class=UserActivitySeeder
```

### Run Detection Tests
```bash
php artisan db:seed --class=TestAnomalyDetectionSeeder
```

### Simulate Anomalies
1. Login at 3 AM
2. Login from different country/IP
3. Make purchase >$1000
4. Multiple rapid logins (within 1 minute)

## 📱 Anomaly Types

### Suspicious Login
- **Medium**: Login at unusual hour
- **High**: Login from unknown IP
- **Critical**: Multiple logins within 1 minute

### Unusual Shopping
- **High**: Purchase amount Z-score > 3
- **Critical**: Purchase amount Z-score > 5
- **High**: Rapid purchases (5x normal rate)

### Abnormal Seller Activity
- **Medium**: Bulk operations (10x normal rate)

## 🔐 Security Best Practices

1. **Review daily** - Check pending anomalies
2. **Investigate critical** - Immediate attention
3. **Mark false positives** - Improves accuracy
4. **Document findings** - Add review notes
5. **Take action** - Suspend suspicious accounts if needed

## 📊 Statistics

The system tracks:
- Total anomalies detected
- Pending reviews
- Critical severity count
- Detection trends over time

## 🎓 Understanding Z-Score

Z-score measures how many standard deviations away from the mean:
- **Z < 2**: Normal behavior
- **Z = 3**: Unusual (our threshold)
- **Z > 5**: Highly suspicious

Example: If average purchase is $100 with std dev $30:
- $190 purchase: Z = 3.0 (flagged)
- $250 purchase: Z = 5.0 (critical)

## 🛠️ Troubleshooting

### No anomalies detected?
- Run `php artisan anomaly:detect` to learn baselines
- Ensure user has 10+ activities in last 30 days
- Check if activities are being tracked

### Too many false positives?
- Increase Z_SCORE_THRESHOLD to 4.0 or 5.0
- Review and mark false positives
- Adjust baseline learning period

### Activities not tracked?
- Verify event listener is registered
- Check middleware is applied to routes
- Ensure migrations are run

## 📚 Documentation

Full documentation: `ANOMALY_DETECTION.md`

## 🎉 You're All Set!

Your anomaly detection system is now:
- ✅ Installed and configured
- ✅ Learning user behavior
- ✅ Detecting anomalies automatically
- ✅ Ready for admin review

Visit: **http://localhost/admin/anomaly-detection**

---

**Need Help?**
- Check `ANOMALY_DETECTION.md` for detailed docs
- Review test results in admin dashboard
- Run test seeder to see examples
