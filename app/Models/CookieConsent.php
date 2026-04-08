<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CookieConsent extends Model
{
    protected $table = 'cookie_consent';
    
    protected $fillable = [
        'title',
        'message',
        'accept_button_text',
        'decline_button_text',
        'is_enabled'
    ];

    protected $casts = [
        'is_enabled' => 'boolean'
    ];
}
