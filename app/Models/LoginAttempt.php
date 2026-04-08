<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'successful',
        'failure_reason',
        'attempted_at'
    ];

    protected $casts = [
        'successful' => 'boolean',
        'attempted_at' => 'datetime'
    ];
}
