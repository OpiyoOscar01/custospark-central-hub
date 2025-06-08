<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'salary_offered',
        'salary_currency',
        'start_date',
        'additional_benefits',
        'special_terms',
        'status',
        'sent_at',
        'response_at',
        'candidate_feedback',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'sent_at' => 'datetime',
        'response_at' => 'datetime',
        'salary_offered' => 'decimal:2'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['sent', 'negotiating']);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
}