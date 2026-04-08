# Login Security - Deployment Checklist

## ✅ Pre-Deployment Checklist

### 1. Configuration
- [ ] Add email configuration to `.env`
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=your-smtp-host
  MAIL_PORT=587
  MAIL_USERNAME=your-username
  MAIL_PASSWORD=your-password
  MAIL_FROM_ADDRESS=noreply@yourdomain.com
  MAIL_FROM_NAME="${APP_NAME}"
  ```

- [ ] (Optional) Customize login security settings in `.env`
  ```env
  LOGIN_MAX_ATTEMPTS=5
  LOGIN_LOCKOUT_DURATION=5
  LOGIN_ATTEMPT_WINDOW=15
  LOGIN_NOTIFY_ON_LOCKOUT=true
  ```

- [ ] Clear configuration cache
  ```bash
  php artisan config:clear
  ```

### 2. Database
- [ ] Verify migrations exist
  ```bash
  php artisan migrate:status
  ```
  Should show:
  - `2026_04_03_154740_create_login_attempts_table`
  - `2026_04_03_154825_create_login_lockouts_table`

- [ ] Ensure migrations are run
  ```bash
  php artisan migrate
  ```

### 3. Testing
- [ ] Run test seeder
  ```bash
  php artisan db:seed --class=TestLockoutNotificationSeeder
  ```

- [ ] Verify email is sent (check inbox or logs)
  ```bash
  # If using log driver
  tail -f storage/logs/laravel.log
  ```

- [ ] Test manual lockout clearing
  ```bash
  php artisan login:clear-lockouts --email=lockout.test@example.com
  ```

- [ ] Test actual login flow
  - [ ] Attempt login with wrong password 5 times
  - [ ] Verify lockout message appears
  - [ ] Check email received
  - [ ] Wait 5 minutes or clear lockout
  - [ ] Verify successful login works

### 4. Code Verification
- [ ] Verify files exist:
  - [ ] `app/Notifications/AccountLockedNotification.php`
  - [ ] `app/Services/LoginSecurityService.php`
  - [ ] `app/Console/Commands/ClearLoginLockouts.php`
  - [ ] `config/login_security.php`

- [ ] Verify command is registered
  ```bash
  php artisan list | grep login
  ```
  Should show: `login:clear-lockouts`

### 5. Security Review
- [ ] Review lockout thresholds (5 attempts is reasonable)
- [ ] Verify lockout duration (5 minutes is standard)
- [ ] Confirm email notifications are enabled
- [ ] Check that IP tracking is working
- [ ] Verify time window is appropriate (15 minutes)

## 🚀 Deployment Steps

### Step 1: Deploy Code
```bash
# Pull latest code
git pull origin main

# Install dependencies (if needed)
composer install --no-dev --optimize-autoloader
```

### Step 2: Update Configuration
```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 3: Run Migrations
```bash
# Run migrations (if not already run)
php artisan migrate --force
```

### Step 4: Verify Deployment
```bash
# Check artisan commands
php artisan list | grep login

# Test configuration loading
php artisan tinker
>>> config('login_security.max_attempts')
>>> exit
```

## 📊 Post-Deployment Monitoring

### Day 1: Initial Monitoring
- [ ] Monitor login attempts
  ```sql
  SELECT COUNT(*) FROM login_attempts WHERE DATE(attempted_at) = CURDATE();
  ```

- [ ] Check for lockouts
  ```sql
  SELECT * FROM login_lockouts WHERE locked_until > NOW();
  ```

- [ ] Verify emails are being sent
  - Check mail logs
  - Monitor mail service dashboard

### Week 1: Performance Check
- [ ] Review failed login patterns
  ```sql
  SELECT email, COUNT(*) as attempts 
  FROM login_attempts 
  WHERE successful = 0 
  GROUP BY email 
  ORDER BY attempts DESC 
  LIMIT 10;
  ```

- [ ] Check for false positives (legitimate users locked out)
- [ ] Monitor email delivery rates
- [ ] Review lockout duration effectiveness

### Ongoing Maintenance
- [ ] Set up scheduled cleanup (optional)
  ```php
  // In app/Console/Kernel.php
  protected function schedule(Schedule $schedule)
  {
      $schedule->call(function () {
          app(LoginSecurityService::class)->cleanupOldAttempts();
      })->daily();
  }
  ```

- [ ] Monitor database table sizes
  ```sql
  SELECT 
    table_name,
    table_rows,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
  FROM information_schema.TABLES
  WHERE table_schema = DATABASE()
  AND table_name IN ('login_attempts', 'login_lockouts');
  ```

## 🔧 Troubleshooting Guide

### Issue: Emails Not Sending
**Check:**
1. `.env` mail configuration is correct
2. Mail service is accessible from server
3. `MAIL_MAILER` is not set to 'log' in production
4. Firewall allows outbound SMTP connections

**Test:**
```bash
php artisan tinker
>>> Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
```

### Issue: Lockouts Not Working
**Check:**
1. Migrations have run successfully
2. `LoginSecurityService` is injected in controller
3. Configuration cache is cleared
4. Database tables exist and are accessible

**Verify:**
```bash
php artisan migrate:status
php artisan config:clear
```

### Issue: Users Locked Out Permanently
**Check:**
1. Server time is correct
2. `locked_until` timestamps in database
3. Timezone configuration in `config/app.php`

**Fix:**
```bash
# Clear specific user
php artisan login:clear-lockouts --email=user@example.com

# Or clear all
php artisan login:clear-lockouts --all
```

### Issue: Too Many False Positives
**Adjust:**
```env
# Increase max attempts
LOGIN_MAX_ATTEMPTS=10

# Increase lockout duration
LOGIN_LOCKOUT_DURATION=10

# Increase attempt window
LOGIN_ATTEMPT_WINDOW=30
```

## 📈 Success Metrics

### Security Metrics
- [ ] Number of brute force attempts blocked
- [ ] Number of accounts protected
- [ ] Average lockout duration before unlock
- [ ] Percentage of users who reset password after notification

### Performance Metrics
- [ ] Database query performance (should be < 50ms)
- [ ] Email delivery rate (should be > 95%)
- [ ] False positive rate (should be < 1%)
- [ ] User complaint rate (should be minimal)

### Monitoring Queries
```sql
-- Lockouts today
SELECT COUNT(*) FROM login_lockouts 
WHERE DATE(created_at) = CURDATE() 
AND locked_until IS NOT NULL;

-- Failed attempts today
SELECT COUNT(*) FROM login_attempts 
WHERE DATE(attempted_at) = CURDATE() 
AND successful = 0;

-- Success rate
SELECT 
  (SUM(CASE WHEN successful = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) as success_rate
FROM login_attempts
WHERE DATE(attempted_at) = CURDATE();
```

## 🎯 Rollback Plan

If issues arise, you can disable the feature:

### Option 1: Disable Notifications Only
```env
LOGIN_NOTIFY_ON_LOCKOUT=false
```

### Option 2: Increase Thresholds
```env
LOGIN_MAX_ATTEMPTS=100  # Effectively disables lockout
```

### Option 3: Clear All Lockouts
```bash
php artisan login:clear-lockouts --all
```

### Option 4: Full Rollback
The feature is non-breaking. Simply:
1. Set high thresholds in `.env`
2. Clear all lockouts
3. Disable notifications

No code changes needed for rollback.

## ✅ Sign-Off

- [ ] All tests passed
- [ ] Configuration verified
- [ ] Email sending confirmed
- [ ] Documentation reviewed
- [ ] Team trained on management commands
- [ ] Monitoring set up
- [ ] Rollback plan understood

**Deployed By:** _________________
**Date:** _________________
**Environment:** [ ] Development [ ] Staging [ ] Production

---

**Status:** Ready for Production ✅
