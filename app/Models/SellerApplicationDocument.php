<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerApplicationDocument extends Model
{
    use HasFactory;

    // Document Type Constants
    public const TYPE_BUSINESS_PERMIT = 'business_permit';
    public const TYPE_ID_CARD = 'id_card';
    public const TYPE_OTHER = 'other';

    public const TYPES = [
        self::TYPE_BUSINESS_PERMIT,
        self::TYPE_ID_CARD,
        self::TYPE_OTHER,
    ];

    protected $fillable = [
        'seller_application_id',
        'document_type',
        'document_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'file_size' => 'integer',
    ];

    // Relationships
    public function application(): BelongsTo
    {
        return $this->belongsTo(SellerApplication::class, 'seller_application_id');
    }

    // Helper Methods
    public function isBusinessPermit(): bool
    {
        return $this->document_type === self::TYPE_BUSINESS_PERMIT;
    }

    public function isIdCard(): bool
    {
        return $this->document_type === self::TYPE_ID_CARD;
    }

    public function getFileUrl(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeFormatted(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
