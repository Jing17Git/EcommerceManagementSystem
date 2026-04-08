# Login Security Flow Diagram

## Complete Login Flow with Lockout & Notification

```
┌─────────────────────────────────────────────────────────────────┐
│                     USER ATTEMPTS LOGIN                          │
│                  (Email + Password Submitted)                    │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              CHECK: Is Account/IP Locked?                        │
│         (LoginSecurityService::isLocked())                       │
└────────────┬────────────────────────────────┬───────────────────┘
             │                                │
         YES │                                │ NO
             ▼                                ▼
┌──────────────────────────┐    ┌────────────────────────────────┐
│   SHOW LOCKOUT MESSAGE   │    │    ATTEMPT AUTHENTICATION      │
│                          │    │    (Validate Credentials)      │
│ "Too many failed login   │    └──────────┬─────────────────────┘
│  attempts. Try again     │               │
│  after X minutes"        │               │
│                          │    ┌──────────┴──────────┐
│ Return to login page     │    │                     │
└──────────────────────────┘    │                     │
                            SUCCESS                FAILURE
                                │                     │
                                ▼                     ▼
                    ┌───────────────────┐  ┌──────────────────────┐
                    │ RECORD SUCCESS    │  │  RECORD FAILURE      │
                    │                   │  │                      │
                    │ • Log attempt     │  │ • Log attempt        │
                    │ • Clear lockouts  │  │ • Increment counter  │
                    │ • Regenerate      │  │ • Check threshold    │
                    │   session         │  └──────────┬───────────┘
                    └─────────┬─────────┘             │
                              │                       │
                              ▼                       ▼
                    ┌───────────────────┐  ┌──────────────────────┐
                    │ REDIRECT TO       │  │ Failed Count >= 5?   │
                    │ DASHBOARD         │  └──────┬───────────┬───┘
                    │                   │         │           │
                    │ Based on role:    │        YES         NO
                    │ • Admin           │         │           │
                    │ • Seller          │         ▼           ▼
                    │ • Buyer           │  ┌──────────┐  ┌────────────┐
                    └───────────────────┘  │  LOCKOUT │  │   SHOW     │
                                           │  ACCOUNT │  │  WARNING   │
                                           └────┬─────┘  └────────────┘
                                                │         "X attempts
                                                │          remaining"
                                                ▼
                                    ┌───────────────────────┐
                                    │  UPDATE DATABASE      │
                                    │                       │
                                    │ • Set locked_until    │
                                    │   (now + 5 minutes)   │
                                    │ • Update lockout      │
                                    │   record              │
                                    └───────────┬───────────┘
                                                │
                                                ▼
                                    ┌───────────────────────┐
                                    │  SEND EMAIL           │
                                    │  NOTIFICATION         │
                                    │                       │
                                    │ To: user@email.com    │
                                    │ Subject: Account      │
                                    │          Locked       │
                                    │                       │
                                    │ Contains:             │
                                    │ • Failed attempts: 5  │
                                    │ • IP: 192.168.1.1     │
                                    │ • Duration: 5 min     │
                                    │ • Reset password link │
                                    └───────────┬───────────┘
                                                │
                                                ▼
                                    ┌───────────────────────┐
                                    │  SHOW ERROR MESSAGE   │
                                    │                       │
                                    │ "Too many failed      │
                                    │  login attempts.      │
                                    │  Try again after      │
                                    │  5 minutes"           │
                                    │                       │
                                    │ Return to login page  │
                                    └───────────────────────┘
```

## Database Tables Interaction

```
┌─────────────────────────────────────────────────────────────────┐
│                        login_attempts                            │
├─────────────────────────────────────────────────────────────────┤
│ • email                                                          │
│ • ip_address                                                     │
│ • user_agent                                                     │
│ • successful (boolean)                                           │
│ • failure_reason                                                 │
│ • attempted_at (timestamp)                                       │
└─────────────────────────────────────────────────────────────────┘
                             │
                             │ Records every login attempt
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                        login_lockouts                            │
├─────────────────────────────────────────────────────────────────┤
│ • identifier (email or IP)                                       │
│ • type ('email' or 'ip')                                         │
│ • failed_attempts (count)                                        │
│ • locked_until (timestamp or null)                               │
│ • last_attempt_at (timestamp)                                    │
└─────────────────────────────────────────────────────────────────┘
                             │
                             │ Manages lockout state
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                            users                                 │
├─────────────────────────────────────────────────────────────────┤
│ • email (used to find user for notification)                    │
│ • name                                                           │
│ • ... other fields                                               │
└─────────────────────────────────────────────────────────────────┘
```

## Configuration Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                          .env File                               │
├─────────────────────────────────────────────────────────────────┤
│ LOGIN_MAX_ATTEMPTS=5                                             │
│ LOGIN_LOCKOUT_DURATION=5                                         │
│ LOGIN_ATTEMPT_WINDOW=15                                          │
│ LOGIN_NOTIFY_ON_LOCKOUT=true                                     │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                  config/login_security.php                       │
├─────────────────────────────────────────────────────────────────┤
│ return [                                                         │
│     'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),              │
│     'lockout_duration' => env('LOGIN_LOCKOUT_DURATION', 5),      │
│     'attempt_window' => env('LOGIN_ATTEMPT_WINDOW', 15),         │
│     'notify_on_lockout' => env('LOGIN_NOTIFY_ON_LOCKOUT', true), │
│ ];                                                               │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              LoginSecurityService::__construct()                 │
├─────────────────────────────────────────────────────────────────┤
│ $this->maxAttempts = config('login_security.max_attempts', 5);  │
│ $this->lockoutDuration = config('login_security.lockout_...);   │
│ $this->attemptWindow = config('login_security.attempt_...);     │
│ $this->notifyOnLockout = config('login_security.notify_...);    │
└─────────────────────────────────────────────────────────────────┘
```

## Time-Based Lockout Logic

```
Timeline (15-minute attempt window):

Time: 00:00  ──────────────────────────────────────────> 00:15
              │                                           │
              │  Failed Attempts Counted in This Window  │
              │                                           │
              ▼                                           ▼
         Attempt 1                                   Window End
         Attempt 2
         Attempt 3
         Attempt 4
         Attempt 5 ──> LOCKOUT TRIGGERED
                       │
                       ▼
                  Locked Until: 00:05 (5 minutes from now)
                       │
                       ▼
Time: 00:05  ──────────────────────────────────────────>
              │
              ▼
         AUTOMATIC UNLOCK
         User can try again
```

## Email Notification Content

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                  │
│  📧 Account Temporarily Locked - Security Alert                 │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Your account has been temporarily locked due to multiple       │
│  failed login attempts.                                         │
│                                                                  │
│  Failed attempts: 5                                             │
│  IP Address: 192.168.1.1                                        │
│  Lockout duration: 5 minutes                                    │
│                                                                  │
│  If this wasn't you, please reset your password immediately.    │
│                                                                  │
│  ┌──────────────────────────────────────┐                       │
│  │       [Reset Password Button]        │                       │
│  └──────────────────────────────────────┘                       │
│                                                                  │
│  Your account will be automatically unlocked after the          │
│  lockout period.                                                │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

## Management Commands

```
┌─────────────────────────────────────────────────────────────────┐
│  php artisan login:clear-lockouts --email=user@example.com      │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│  UPDATE login_lockouts                                           │
│  SET failed_attempts = 0, locked_until = NULL                    │
│  WHERE identifier = 'user@example.com' AND type = 'email'        │
└─────────────────────────────────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│  ✓ Cleared lockout for user@example.com                         │
└─────────────────────────────────────────────────────────────────┘
```

## Security Layers

```
┌─────────────────────────────────────────────────────────────────┐
│                        Layer 1: Email                            │
│  Tracks failed attempts per email address                       │
│  Prevents account-specific brute force                          │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                        Layer 2: IP Address                       │
│  Tracks failed attempts per IP                                  │
│  Prevents distributed attacks from same source                  │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                     Layer 3: Time Window                         │
│  Only counts attempts within 15-minute window                   │
│  Prevents slow brute force attacks                              │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    Layer 4: User Notification                    │
│  Alerts user of suspicious activity                             │
│  Enables user to take action (password reset)                   │
└─────────────────────────────────────────────────────────────────┘
```

---

This visual guide helps understand the complete flow of the login security system with temporary lockout and email notifications.
