# Login Lockout & Notification - Quick Start Guide

## ✅ What's Implemented

Your Laravel application now has:
- ✓ Automatic account lockout after 5 failed login attempts
- ✓ Email notifications when accounts are locked
- ✓ Progressive warnings showing remaining attempts
- ✓ Configurable settings via environment variables
- ✓ Artisan commands for management

## 🚀 Quick Setup (3 Steps)

### Step 1: Configure Email (Required for Notifications)

Add to `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

**For Testing**: Use [Mailtrap.io](https://mailtrap.io) (free) or keep `MAIL_MAILER=log` to log emails.

### Step 2: Optional Configuration

Add to `.env` (optional, defaults shown):
```env
LOGIN_MAX_ATTEMPTS=5
LOGIN_LOCKOUT_DURATION=5
LOGIN_ATTEMPT_WINDOW=15
LOGIN_NOTIFY_ON_LOCKOUT=true
```

### Step 3: Clear Config Cache

```bash
php artisan config:clear
```

## 🧪 Test It

### Option 1: Run Test Seeder
```bash
php artisan db:seed --class=TestLockoutNotificationSeeder
```

### Option 2: Manual Test
1. Go to login page
2. Enter valid email with wrong password 5 times
3. See lockout message
4. Check email (or `storage/logs/laravel.log` if using log driver)

## 📧 Email Notification Preview

When locked, users receive:
```
Subject: Account Temporarily Locked - Security Alert

Your account has been temporarily locked due to multiple failed login attempts.

Failed attempts: 5
IP Address: 192.168.1.1
Lockout duration: 5 minutes

If this wasn't you, please reset your password immediately.

[Reset Password Button]

Your account will be automatically unlocked after the lockout period.
```

## 🛠️ Management Commands

### Clear Specific User Lockout
```bash
php artisan login:clear-lockouts --email=user@example.com
```

### Clear All Lockouts
```bash
php artisan login:clear-lockouts --all
```

### View Active Lockouts
```bash
php artisan tinker
>>> App\Models\LoginLockout::whereNotNull('locked_until')->get();
```

### View Recent Failed Attempts
```bash
php artisan tinker
>>> App\Models\LoginAttempt::where('successful', false)->latest()->take(10)->get();
```

## 🎯 How It Works

1. **User tries to login** → System checks if locked
2. **Wrong password** → Records attempt, shows remaining tries
3. **5th failed attempt** → Account locked for 5 minutes + email sent
4. **Successful login** → Clears all lockout records
5. **After 5 minutes** → Automatic unlock

## ⚙️ Customization

### Change Lockout Duration to 15 Minutes
```env
LOGIN_LOCKOUT_DURATION=15
```

### More Strict (3 Attempts)
```env
LOGIN_MAX_ATTEMPTS=3
```

### Disable Email Notifications
```env
LOGIN_NOTIFY_ON_LOCKOUT=false
```

## 📊 User Experience

### Attempt 1-2 (Normal)
```
Error: These credentials do not match our records.
```

### Attempt 3-4 (Warning)
```
Error: Invalid credentials. You have 2 attempt(s) remaining before temporary lockout.
```

### Attempt 5 (Locked)
```
Error: Too many failed login attempts. Please try again after 5 minute(s).
```

## 🔍 Troubleshooting

### Emails Not Sending?
```bash
# Test mail configuration
php artisan tinker
>>> Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
```

### Check if migrations ran:
```bash
php artisan migrate:status
```

### Clear lockout manually:
```bash
php artisan login:clear-lockouts --email=user@example.com
```

## 📁 Files Created/Modified

### New Files
- `app/Notifications/AccountLockedNotification.php` - Email notification
- `config/login_security.php` - Configuration
- `app/Console/Commands/ClearLoginLockouts.php` - Management command
- `database/seeders/TestLockoutNotificationSeeder.php` - Test seeder

### Modified Files
- `app/Services/LoginSecurityService.php` - Added notification support

### Existing Files (Already Working)
- `app/Models/LoginAttempt.php`
- `app/Models/LoginLockout.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

## 📖 Full Documentation

See `LOGIN_LOCKOUT_NOTIFICATION.md` for complete documentation.

## ✨ That's It!

Your login security with notifications is ready to use. No additional setup required unless you want to customize the behavior.
