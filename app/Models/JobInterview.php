<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobInterview extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'interviewer_id',
        'scheduled_at',
        'type',
        'location',
        'status',
        'notes',
        'feedback',
        'rating'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class, 'application_id');
    }

    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(InterviewResponse::class, 'interview_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                    ->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}