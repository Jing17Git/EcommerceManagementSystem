<?php

namespace App\Console\Commands;

use App\Models\LoginLockout;
use Illuminate\Console\Command;

class ClearLoginLockouts extends Command
{
    protected $signature = 'login:clear-lockouts {--email= : Clear lockout for specific email} {--all : Clear all lockouts}';
    protected $description = 'Clear login lockouts for users';

    public function handle()
    {
        if ($this->option('all')) {
            $count = LoginLockout::query()->update([
                'failed_attempts' => 0,
                'locked_until' => null
            ]);
            $this->info("Cleared {$count} lockout(s)");
            return 0;
        }

        if ($email = $this->option('email')) {
            $lockout = LoginLockout::where('identifier', $email)
                ->where('type', 'email')
                ->first();

            if ($lockout) {
                $lockout->update([
                    'failed_attempts' => 0,
                    'locked_until' => null
                ]);
                $this->info("Cleared lockout for {$email}");
            } else {
                $this->warn("No lockout found for {$email}");
            }
            return 0;
        }

        $this->error('Please specify --email or --all');
        return 1;
    }
}
