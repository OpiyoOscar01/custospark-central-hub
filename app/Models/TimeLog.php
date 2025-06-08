<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeLog extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'task_id',
        'user_id',
        'hours_worked',
        'date_logged',
        'description',
        'is_billable',
        'status',
        'approved_by',
        'approved_at',
        'start_time',
        'end_time',
        'break_duration'
    ];

    protected $casts = [
        'date_logged' => 'date',
        'hours_worked' => 'decimal:2',
        'is_billable' => 'boolean',
        'approved_at' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'break_duration' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getActualHoursWorkedAttribute(): float
    {
        if ($this->start_time && $this->end_time) {
            $minutes = $this->end_time->diffInMinutes($this->start_time);
            $breakMinutes = $this->break_duration ?? 0;
            return round(($minutes - $breakMinutes) / 60, 2);
        }
        return $this->hours_worked;
    }
}