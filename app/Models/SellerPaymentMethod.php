<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'method_type',
        'account_name',
        'account_number',
        'bank_name',
        'instructions',
        'is_active',
        'is_primary',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
