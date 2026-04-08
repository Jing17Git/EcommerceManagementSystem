<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehaviorBaseline extends Model
{
    protected $fillable = [
        'user_id',
        'behavior_type',
        'baseline_data',
        'learned_at'
    ];

    protected $casts = [
        'baseline_data' => 'array',
        'learned_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
