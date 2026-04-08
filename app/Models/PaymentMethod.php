<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'instructions',
        'account_name',
        'account_number',
        'qr_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
