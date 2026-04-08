<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountLockedNotification extends Notification
{
    use Queueable;

    public $lockoutMinutes;
    public $ipAddress;
    public $attemptCount;

    public function __construct($lockoutMinutes, $ipAddress, $attemptCount)
    {
        $this->lockoutMinutes = $lockoutMinutes;
        $this->ipAddress = $ipAddress;
        $this->attemptCount = $attemptCount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Temporarily Locked - Security Alert')
            ->line('Your account has been temporarily locked due to multiple failed login attempts.')
            ->line("Failed attempts: {$this->attemptCount}")
            ->line("IP Address: {$this->ipAddress}")
            ->line("Lockout duration: {$this->lockoutMinutes} minutes")
            ->line('If this wasn\'t you, please reset your password immediately.')
            ->action('Reset Password', url('/forgot-password'))
            ->line('Your account will be automatically unlocked after the lockout period.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'lockout_minutes' => $this->lockoutMinutes,
            'ip_address' => $this->ipAddress,
            'attempt_count' => $this->attemptCount,
        ];
    }
}
