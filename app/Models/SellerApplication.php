<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SellerApplication extends Model
{
    use HasFactory;

    // Status Constants (Clean Code Practice)
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
    ];

    protected $fillable = [
        'user_id',
        'business_name',
        'business_email',
        'business_phone',
        'business_address',
        'business_permit',
        'business_permit_name',
        'permit_expiry_date',
        'id_card',
        'id_card_name',
        'status',
        'rejection_reason',
        'approved_at',
        'rejected_at',
        'reviewed_by',
    ];

    protected $casts = [
        'permit_expiry_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SellerApplicationDocument::class);
    }

    // Status Check Methods
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    // Business Logic Methods
    public function isPermitExpired(): bool
    {
        return $this->permit_expiry_date && $this->permit_expiry_date->isPast();
    }

    public function namesMatch(): bool
    {
        $businessName = strtolower(trim($this->business_name ?? ''));
        $permitName = strtolower(trim($this->business_permit_name ?? ''));
        $idCardName = strtolower(trim($this->id_card_name ?? ''));

        return $businessName === $permitName && $businessName === $idCardName;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }
}