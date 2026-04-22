<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_email',
        'business_phone',
        'business_address',
        'documents',
        'business_permit',
        'business_permit_name',
        'permit_expiry_date',
        'id_card',
        'id_card_name',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'permit_expiry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}