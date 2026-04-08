# Login Behavior Security with Temporary Lockout and Notification

## Overview
This feature protects user accounts from brute-force attacks by temporarily locking accounts after multiple failed login attempts and sending email notifications to users.

## Features

### 1. **Temporary Account Lockout**
- Locks accounts after configurable failed login attempts (default: 5 attempts)
- Lockout duration is configurable (default: 5 minutes)
- Tracks attempts within a time window (default: 15 minutes)
- Locks by both email and IP address

### 2. **Email Notifications**
- Sends automatic email alerts when an account is locked
- Includes lockout details: duration, IP address, attempt count
- Provides quick access to password reset

### 3. **Progressive Warnings**
- Shows remaining attempts when 3 or fewer remain
- Clear error messages for users

## Configuration

### Environment Variables
Add to your `.env` file:

```env
# Login Security Settings
LOGIN_MAX_ATTEMPTS=5
LOGIN_LOCKOUT_DURATION=5
LOGIN_ATTEMPT_WINDOW=15
LOGIN_NOTIFY_ON_LOCKOUT=true

# Mail Configuration (required for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Configuration File
Settings are in `config/login_security.php`:

```php
return [
    'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
    'lockout_duration' => env('LOGIN_LOCKOUT_DURATION', 5), // minutes
    'attempt_window' => env('LOGIN_ATTEMPT_WINDOW', 15), // minutes
    'notify_on_lockout' => env('LOGIN_NOTIFY_ON_LOCKOUT', true),
];
```

## Database Tables

### login_attempts
Tracks all login attempts:
- `email` - User email
- `ip_address` - Request IP
- `user_agent` - Browser info
- `successful` - Boolean
- `failure_reason` - Why it failed
- `attempted_at` - Timestamp

### login_lockouts
Manages lockout state:
- `identifier` - Email or IP
- `type` - 'email' or 'ip'
- `failed_attempts` - Count
- `locked_until` - Unlock time
- `last_attempt_at` - Last attempt timestamp

## How It Works

### Login Flow
1. User submits login credentials
2. System checks if account/IP is locked
3. If locked, shows lockout message with remaining time
4. If not locked, attempts authentication
5. On success: clears lockout records
6. On failure:
   - Records failed attempt
   - Increments failure count
   - If threshold reached: locks account and sends email
   - Shows remaining attempts if ≤ 3

### Lockout Logic
```
Failed Attempts in Window >= Max Attempts → Lockout
```

Example with defaults:
- 5 failed attempts within 15 minutes = 5-minute lockout

### Notification Trigger
Email sent when:
- Failed attempts reach max threshold
- `LOGIN_NOTIFY_ON_LOCKOUT=true`
- User exists in database

## Usage Examples

### Check Lockout Status
```php
$loginSecurity = app(LoginSecurityService::class);
$lockInfo = $loginSecurity->isLocked('user@example.com');

if ($lockInfo['locked']) {
    echo "Locked until: " . $lockInfo['locked_until'];
    echo "Remaining: " . $lockInfo['remaining_seconds'] . " seconds";
}
```

### Get Remaining Attempts
```php
$remaining = $loginSecurity->getRemainingAttempts('user@example.com');
echo "You have {$remaining} attempts remaining";
```

### Manual Lockout Clear
```php
// Clear by email
LoginLockout::where('identifier', 'user@example.com')
    ->where('type', 'email')
    ->update(['failed_attempts' => 0, 'locked_until' => null]);

// Clear by IP
LoginLockout::where('identifier', '192.168.1.1')
    ->where('type', 'ip')
    ->update(['failed_attempts' => 0, 'locked_until' => null]);
```

## Testing

### Test Lockout Behavior
1. Attempt login with wrong password 5 times
2. Verify lockout message appears
3. Check email for notification
4. Wait 5 minutes or clear lockout manually
5. Verify login works again

### Test Email Notification
```bash
# Use Mailtrap or similar for testing
# Check logs if using log driver
tail -f storage/logs/laravel.log
```

### Artisan Commands
```bash
# Clear old attempts (30+ days)
php artisan tinker
>>> app(App\Services\LoginSecurityService::class)->cleanupOldAttempts();

# View recent attempts
>>> App\Models\LoginAttempt::latest()->take(10)->get();

# View active lockouts
>>> App\Models\LoginLockout::whereNotNull('locked_until')->get();
```

## Security Best Practices

1. **Rate Limiting**: Already implemented via lockout mechanism
2. **IP Tracking**: Prevents distributed attacks
3. **Time Windows**: Prevents slow brute-force attacks
4. **Email Alerts**: Users aware of unauthorized access attempts
5. **Automatic Cleanup**: Old records removed to save space

## Customization

### Change Lockout Duration
```env
LOGIN_LOCKOUT_DURATION=15  # 15 minutes instead of 5
```

### Change Max Attempts
```env
LOGIN_MAX_ATTEMPTS=3  # More strict
```

### Disable Notifications
```env
LOGIN_NOTIFY_ON_LOCKOUT=false
```

### Custom Notification
Modify `app/Notifications/AccountLockedNotification.php`:
```php
public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Custom Subject')
        ->line('Custom message')
        // ... customize as needed
}
```

## Troubleshooting

### Emails Not Sending
1. Check `.env` mail configuration
2. Verify `MAIL_MAILER` is not 'log' in production
3. Test mail config: `php artisan tinker` → `Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });`

### Lockout Not Working
1. Verify migrations ran: `php artisan migrate:status`
2. Check service is injected in controller
3. Verify config cache: `php artisan config:clear`

### Users Locked Out Permanently
1. Check `locked_until` timestamps in database
2. Verify server time is correct
3. Manually clear: See "Manual Lockout Clear" above

## Maintenance

### Scheduled Cleanup
Add to `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        app(LoginSecurityService::class)->cleanupOldAttempts();
    })->daily();
}
```

### Monitor Lockouts
```sql
-- Active lockouts
SELECT * FROM login_lockouts WHERE locked_until > NOW();

-- Failed attempts today
SELECT COUNT(*) FROM login_attempts 
WHERE successful = 0 AND DATE(attempted_at) = CURDATE();

-- Most targeted emails
SELECT email, COUNT(*) as attempts 
FROM login_attempts 
WHERE successful = 0 
GROUP BY email 
ORDER BY attempts DESC 
LIMIT 10;
```

## API Response Examples

### Locked Account
```json
{
    "message": "Too many failed login attempts. Please try again after 4 minute(s).",
    "errors": {
        "email": ["Too many failed login attempts. Please try again after 4 minute(s)."]
    }
}
```

### Failed with Warning
```json
{
    "message": "Invalid credentials. You have 2 attempt(s) remaining before temporary lockout.",
    "errors": {
        "email": ["Invalid credentials. You have 2 attempt(s) remaining before temporary lockout."]
    }
}
```

## Files Modified/Created

### Created
- `app/Notifications/AccountLockedNotification.php`
- `config/login_security.php`
- `LOGIN_LOCKOUT_NOTIFICATION.md` (this file)

### Modified
- `app/Services/LoginSecurityService.php` - Added notification support

### Existing (Already in place)
- `app/Models/LoginAttempt.php`
- `app/Models/LoginLockout.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- Database migrations for login_attempts and login_lockouts tables

## Support
For issues or questions, check:
1. Laravel logs: `storage/logs/laravel.log`
2. Database records in `login_attempts` and `login_lockouts` tables
3. Mail logs if using log driver
