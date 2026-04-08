<?php

namespace App\Services;

use App\Models\LoginAttempt;
use App\Models\LoginLockout;
use App\Models\User;
use App\Notifications\AccountLockedNotification;
use Carbon\Carbon;

class LoginSecurityService
{
    private $maxAttempts;
    private $lockoutDuration;
    private $attemptWindow;
    private $notifyOnLockout;

    public function __construct()
    {
        $this->maxAttempts = (int) config('login_security.max_attempts', 5);
        $this->lockoutDuration = (int) config('login_security.lockout_duration', 5);
        $this->attemptWindow = (int) config('login_security.attempt_window', 15);
        $this->notifyOnLockout = (bool) config('login_security.notify_on_lockout', true);
    }

    public function recordAttempt($email, $successful = false, $failureReason = null)
    {
        LoginAttempt::create([
            'email' => $email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'successful' => $successful,
            'failure_reason' => $failureReason,
            'attempted_at' => now()
        ]);

        if (!$successful) {
            $this->handleFailedAttempt($email);
        } else {
            $this->clearLockout($email);
            $this->clearLockout(request()->ip(), 'ip');
        }
    }

    public function isLocked($email)
    {
        // Check email lockout
        $emailLockout = LoginLockout::where('identifier', $email)
            ->where('type', 'email')
            ->first();

        if ($emailLockout && $emailLockout->isLocked()) {
            return [
                'locked' => true,
                'reason' => 'email',
                'remaining_seconds' => $emailLockout->getRemainingLockoutTime(),
                'locked_until' => $emailLockout->locked_until
            ];
        }

        // Check IP lockout
        $ipLockout = LoginLockout::where('identifier', request()->ip())
            ->where('type', 'ip')
            ->first();

        if ($ipLockout && $ipLockout->isLocked()) {
            return [
                'locked' => true,
                'reason' => 'ip',
                'remaining_seconds' => $ipLockout->getRemainingLockoutTime(),
                'locked_until' => $ipLockout->locked_until
            ];
        }

        return ['locked' => false];
    }

    private function handleFailedAttempt($email)
    {
        $ip = request()->ip();
        
        // Count recent failed attempts by email
        $emailFailedCount = LoginAttempt::where('email', $email)
            ->where('successful', false)
            ->where('attempted_at', '>=', now()->subMinutes($this->attemptWindow))
            ->count();

        // Count recent failed attempts by IP
        $ipFailedCount = LoginAttempt::where('ip_address', $ip)
            ->where('successful', false)
            ->where('attempted_at', '>=', now()->subMinutes($this->attemptWindow))
            ->count();

        // Update or create email lockout record
        $emailLockout = LoginLockout::updateOrCreate(
            ['identifier' => $email, 'type' => 'email'],
            [
                'failed_attempts' => $emailFailedCount,
                'last_attempt_at' => now()
            ]
        );

        // Update or create IP lockout record
        $ipLockout = LoginLockout::updateOrCreate(
            ['identifier' => $ip, 'type' => 'ip'],
            [
                'failed_attempts' => $ipFailedCount,
                'last_attempt_at' => now()
            ]
        );

        // Apply lockout if threshold reached
        if ($emailFailedCount >= $this->maxAttempts) {
            $emailLockout->update([
                'locked_until' => now()->addMinutes($this->lockoutDuration)
            ]);
            if ($this->notifyOnLockout) {
                $this->sendLockoutNotification($email, $emailFailedCount);
            }
        }

        if ($ipFailedCount >= $this->maxAttempts) {
            $ipLockout->update([
                'locked_until' => now()->addMinutes($this->lockoutDuration)
            ]);
        }
    }

    private function clearLockout($identifier, $type = 'email')
    {
        LoginLockout::where('identifier', $identifier)
            ->where('type', $type)
            ->update([
                'failed_attempts' => 0,
                'locked_until' => null
            ]);
    }

    public function getFailedAttempts($email)
    {
        return LoginAttempt::where('email', $email)
            ->where('successful', false)
            ->where('attempted_at', '>=', now()->subMinutes($this->attemptWindow))
            ->count();
    }

    public function getRemainingAttempts($email)
    {
        $failedCount = $this->getFailedAttempts($email);
        return max(0, $this->maxAttempts - $failedCount);
    }

    public function getRecentAttempts($email, $limit = 10)
    {
        return LoginAttempt::where('email', $email)
            ->orderBy('attempted_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function cleanupOldAttempts()
    {
        // Delete attempts older than 30 days
        LoginAttempt::where('attempted_at', '<', now()->subDays(30))->delete();
        
        // Delete expired lockouts
        LoginLockout::where('locked_until', '<', now())
            ->where('failed_attempts', 0)
            ->delete();
    }

    public function getLockoutMessage($lockInfo)
    {
        $minutes = ceil($lockInfo['remaining_seconds'] / 60);
        $seconds = $lockInfo['remaining_seconds'] % 60;
        
        if ($minutes > 0) {
            return "Too many failed login attempts. Please try again after {$minutes} minute(s).";
        } else {
            return "Too many failed login attempts. Please try again after {$seconds} second(s).";
        }
    }

    public function getMaxAttempts()
    {
        return $this->maxAttempts;
    }

    public function getLockoutDuration()
    {
        return $this->lockoutDuration;
    }

    private function sendLockoutNotification($email, $attemptCount)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->notify(new AccountLockedNotification(
                $this->lockoutDuration,
                request()->ip(),
                $attemptCount
            ));
        }
    }
}
