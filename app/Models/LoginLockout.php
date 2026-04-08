<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLockout extends Model
{
    protected $fillable = [
        'identifier',
        'type',
        'failed_attempts',
        'locked_until',
        'last_attempt_at'
    ];

    protected $casts = [
        'locked_until' => 'datetime',
        'last_attempt_at' => 'datetime'
    ];

    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function getRemainingLockoutTime()
    {
        if (!$this->isLocked()) {
            return 0;
        }
        return $this->locked_until->diffInSeconds(now());
    }
}
