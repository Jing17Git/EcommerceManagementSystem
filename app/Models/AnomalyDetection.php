<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnomalyDetection extends Model
{
    protected $fillable = [
        'user_id',
        'anomaly_type',
        'severity',
        'description',
        'detection_data',
        'status',
        'detected_at',
        'reviewed_by',
        'reviewed_at',
        'review_notes'
    ];

    protected $casts = [
        'detection_data' => 'array',
        'detected_at' => 'datetime',
        'reviewed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
