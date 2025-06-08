<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'app_id',
        'code',
        'type', // percentage, fixed, free_trial, custom
        'value',
        'starts_at',
        'expires_at',
        'max_uses',
        'max_uses_per_user',
        'active',
        'created_by_admin',
        'creator_id',
        'description',
        'conditions',
        'metadata',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'active' => 'boolean',
        'created_by_admin' => 'boolean',
        'value' => 'float',
        'conditions' => 'array',
        'metadata' => 'array',
    ];

    /** App that owns this coupon */
    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
    }
        public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }


    /** Admin or user who created the coupon */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /** Users who have used the coupon */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_users')
                    ->withPivot('used_at')
                    ->withTimestamps();
    }

    /** Check if coupon is expired */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /** Check if coupon is active and within valid time range */
    public function getIsValidAttribute(): bool
    {
        $now = Carbon::now();

        return $this->active &&
               (!$this->starts_at || $this->starts_at <= $now) &&
               (!$this->expires_at || $this->expires_at >= $now);
    }

    /** Remaining total uses across the system */
    public function getRemainingUsesAttribute(): ?int
    {
        if (is_null($this->max_uses)) return null;

        // Assumes 'coupon_users' has one record per use
        return $this->max_uses - $this->users()->count();
    }
}
