# Login Security System - Documentation

## Overview
A comprehensive login security feature that tracks failed login attempts and enforces temporary restrictions to protect against brute-force attacks.

## Features

### 1. **Failed Attempt Tracking**
- Tracks every login attempt (successful and failed)
- Records: Email, IP address, User agent, Timestamp
- Stores failure reasons for analysis

### 2. **Automatic Lockout**
- **Threshold**: 5 consecutive failed attempts
- **Time Window**: 15 minutes
- **Lockout Duration**: 5 minutes
- **Tracking**: Both email AND IP address

### 3. **User Feedback**
- Shows remaining attempts (when ≤ 3)
- Clear lockout message with time remaining
- Prevents login even with correct credentials during lockout

### 4. **Admin Dashboard**
- View all login attempts
- Monitor active lockouts
- Manually unlock accounts
- Filter and search capabilities
- Statistics and insights

## How It Works

### Tracking System
```
User attempts login
    ↓
System records attempt (email, IP, timestamp)
    ↓
If failed → Count recent failures (last 15 min)
    ↓
If count ≥ 5 → Apply lockout for 5 minutes
    ↓
If successful → Clear lockout records
```

### Lockout Logic
1. **Email-based**: Locks specific email address
2. **IP-based**: Locks specific IP address
3. **Dual protection**: Both must be clear to login

### Time Windows
- **Attempt Window**: 15 minutes (counts failures in this period)
- **Lockout Duration**: 5 minutes (cannot login during this time)
- **Auto-unlock**: Lockout expires automatically

## Database Tables

### `login_attempts`
Tracks all login attempts:
```
- id
- email
- ip_address
- user_agent
- successful (boolean)
- failure_reason
- attempted_at
- created_at, updated_at
```

### `login_lockouts`
Manages lockout status:
```
- id
- identifier (email or IP)
- type (email or ip)
- failed_attempts (count)
- locked_until (timestamp)
- last_attempt_at
- created_at, updated_at
```

## Configuration

### Adjustable Constants
In `LoginSecurityService.php`:

```php
// Maximum failed attempts before lockout
private const MAX_FAILED_ATTEMPTS = 5;

// Lockout duration in minutes
private const LOCKOUT_DURATION = 5;

// Time window to count failed attempts (in minutes)
private const ATTEMPT_WINDOW = 15;
```

### Customization Examples

**More Strict (3 attempts, 10 min lockout):**
```php
private const MAX_FAILED_ATTEMPTS = 3;
private const LOCKOUT_DURATION = 10;
```

**More Lenient (10 attempts, 2 min lockout):**
```php
private const MAX_FAILED_ATTEMPTS = 10;
private const LOCKOUT_DURATION = 2;
```

## User Experience

### Normal Login Flow
1. User enters credentials
2. If correct → Login successful
3. If incorrect → Error message shown
4. Attempts 1-2: Generic error
5. Attempts 3-4: Warning with remaining attempts
6. Attempt 5: Lockout triggered

### Lockout Flow
1. After 5 failed attempts
2. User sees: "Too many failed login attempts. Please try again after 5 minutes."
3. Cannot login even with correct password
4. After 5 minutes → Lockout expires
5. Can attempt login again

### Messages

**Generic Error (attempts 1-2):**
```
"These credentials do not match our records."
```

**Warning (attempts 3-4):**
```
"Invalid credentials. You have 2 attempt(s) remaining before temporary lockout."
```

**Lockout:**
```
"Too many failed login attempts. Please try again after 5 minutes."
```

## Admin Interface

### Login Security Dashboard
**URL**: `/admin/login-security`

**Features**:
- Total attempts counter
- Failed attempts counter
- Successful logins counter
- Active lockouts counter
- Recent failed attempts (last hour)

**Filters**:
- Search by email
- Search by IP address
- Filter by status (success/failed)

### Lockouts Management
**URL**: `/admin/login-security/lockouts`

**Features**:
- View all lockouts (active and expired)
- See remaining lockout time
- Manually unlock accounts
- View lockout policy

**Actions**:
- **Unlock**: Remove lockout immediately
- **View Details**: See attempt history

### Statistics
- Total login attempts
- Failed vs successful ratio
- Active lockouts count
- Recent activity (last hour)

## API Methods

### LoginSecurityService

**recordAttempt($email, $successful, $failureReason)**
```php
// Record a login attempt
$service->recordAttempt('user@example.com', false, 'Invalid credentials');
```

**isLocked($email)**
```php
// Check if account is locked
$lockInfo = $service->isLocked('user@example.com');
if ($lockInfo['locked']) {
    echo $lockInfo['remaining_seconds']; // Time remaining
}
```

**getFailedAttempts($email)**
```php
// Get count of recent failed attempts
$count = $service->getFailedAttempts('user@example.com');
```

**getRemainingAttempts($email)**
```php
// Get remaining attempts before lockout
$remaining = $service->getRemainingAttempts('user@example.com');
```

**cleanupOldAttempts()**
```php
// Delete attempts older than 30 days
$service->cleanupOldAttempts();
```

## Security Features

### Protection Against
- ✅ Brute-force attacks
- ✅ Credential stuffing
- ✅ Password spraying
- ✅ Distributed attacks (IP tracking)
- ✅ Account enumeration (generic errors)

### Best Practices Implemented
- ✅ Rate limiting
- ✅ Temporary lockouts
- ✅ Dual tracking (email + IP)
- ✅ Automatic cleanup
- ✅ Admin monitoring
- ✅ Detailed logging

## Integration

### Automatic Integration
The system is automatically integrated into:
- Login controller (`AuthenticatedSessionController`)
- All login attempts are tracked
- Lockouts are enforced automatically

### Manual Integration
To use in custom authentication:

```php
use App\Services\LoginSecurityService;

$loginSecurity = app(LoginSecurityService::class);

// Check if locked
$lockInfo = $loginSecurity->isLocked($email);
if ($lockInfo['locked']) {
    return back()->withErrors([
        'email' => $loginSecurity->getLockoutMessage($lockInfo)
    ]);
}

// After authentication attempt
if ($authSuccess) {
    $loginSecurity->recordAttempt($email, true);
} else {
    $loginSecurity->recordAttempt($email, false, 'Invalid credentials');
}
```

## Maintenance

### Automatic Cleanup
Create a scheduled task in `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        app(LoginSecurityService::class)->cleanupOldAttempts();
    })->daily();
}
```

### Manual Cleanup
Admin can trigger cleanup from dashboard or via command:
```bash
# Via admin interface
POST /admin/login-security/cleanup

# Or programmatically
app(LoginSecurityService::class)->cleanupOldAttempts();
```

## Monitoring

### Key Metrics to Watch
1. **Failed Attempts Rate**: High rate may indicate attack
2. **Active Lockouts**: Sudden spike may indicate distributed attack
3. **Unique IPs**: Many IPs with failures = distributed attack
4. **Time Patterns**: Attacks often occur at specific times

### Alerts
Consider setting up alerts for:
- More than 10 active lockouts
- More than 100 failed attempts per hour
- Same IP with multiple email attempts

## Testing

### Test Lockout Mechanism
1. Attempt login with wrong password 5 times
2. Verify lockout message appears
3. Try correct password → Should still be locked
4. Wait 5 minutes
5. Try again → Should work

### Test Admin Interface
1. Go to `/admin/login-security`
2. View login attempts
3. Go to lockouts page
4. Manually unlock an account
5. Verify unlock works

## Troubleshooting

### User Can't Login (Not Locked)
- Check if lockout expired
- Verify credentials are correct
- Check database for lockout record

### Lockout Not Triggering
- Verify migrations ran successfully
- Check MAX_FAILED_ATTEMPTS constant
- Ensure service is injected in controller

### Admin Can't See Attempts
- Verify user has admin role
- Check route middleware
- Ensure migrations created tables

## Performance

### Database Indexes
Optimized queries with indexes on:
- `email + attempted_at`
- `ip_address + attempted_at`
- `identifier + locked_until`

### Cleanup Strategy
- Automatic deletion of attempts > 30 days
- Removes expired lockouts with 0 failed attempts
- Keeps database lean and performant

## Compliance

### GDPR Considerations
- Login attempts contain personal data (email, IP)
- Implement data retention policy (30 days default)
- Allow users to request deletion
- Document in privacy policy

### Logging
- All attempts are logged
- Includes timestamps for audit trail
- Admin actions are tracked
- Complies with security audit requirements

## Future Enhancements

Potential improvements:
- Email notifications on lockout
- CAPTCHA after 3 failed attempts
- Progressive delays (1 min, 5 min, 15 min)
- Whitelist trusted IPs
- Two-factor authentication integration
- Geolocation-based alerts
- Machine learning for anomaly detection

## Routes

### Public Routes
- `POST /login` - Login with security checks

### Admin Routes
- `GET /admin/login-security` - View attempts
- `GET /admin/login-security/lockouts` - View lockouts
- `POST /admin/login-security/unlock` - Unlock account
- `POST /admin/login-security/cleanup` - Cleanup old data

## Models

### LoginAttempt
- Tracks individual login attempts
- Fillable: email, ip_address, user_agent, successful, failure_reason, attempted_at
- Casts: successful (boolean), attempted_at (datetime)

### LoginLockout
- Manages lockout status
- Fillable: identifier, type, failed_attempts, locked_until, last_attempt_at
- Methods: isLocked(), getRemainingLockoutTime()

## Service

### LoginSecurityService
Core service handling all security logic:
- recordAttempt() - Log attempts
- isLocked() - Check lockout status
- handleFailedAttempt() - Process failures
- clearLockout() - Remove lockout
- getFailedAttempts() - Count failures
- getRemainingAttempts() - Calculate remaining
- cleanupOldAttempts() - Maintenance
- getLockoutMessage() - User-friendly message

## Summary

The login security system provides:
- ✅ Automatic brute-force protection
- ✅ User-friendly error messages
- ✅ Comprehensive admin monitoring
- ✅ Flexible configuration
- ✅ Performance optimized
- ✅ GDPR compliant
- ✅ Easy integration
- ✅ Detailed logging

**Default Settings**:
- 5 failed attempts → 5 minute lockout
- 15 minute attempt window
- Tracks both email and IP
- Auto-cleanup after 30 days
