<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectRisk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'probability',
        'impact',
        'status',
        'mitigation_strategy',
        'contingency_plan',
        'assigned_to',
        'identified_date',
        'target_resolution_date',
        'actual_resolution_date'
    ];

    protected $casts = [
        'identified_date' => 'date',
        'target_resolution_date' => 'date',
        'actual_resolution_date' => 'date'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getRiskScoreAttribute(): int
    {
        $probabilityScore = match($this->probability) {
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        };

        $impactScore = match($this->impact) {
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        };

        return $probabilityScore * $impactScore;
    }

    public function getRiskLevelAttribute(): string
    {
        return match($this->risk_score) {
            1, 2 => 'low',
            3, 4 => 'medium',
            6, 9 => 'high',
        };
    }
}