<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'app_id',
        'referral_url',
        'status',
        'rewarded_at',
        'earned_amount',
        'source',
        'medium',
    ];

    protected $casts = [
        'rewarded_at' => 'datetime',
        'earned_amount' => 'float',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referredUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
    }

    // Helpful status checkers
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConverted(): bool
    {
        return $this->status === 'converted';
    }

    public function isRewarded(): bool
    {
        return $this->status === 'rewarded';
    }
}
