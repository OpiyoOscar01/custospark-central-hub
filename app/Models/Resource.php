<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use SoftDeletes;

    // protected $fillable = [
    //     'project_id',
    //     'name',
    //     'type',
    //     'quantity',
    //     'cost'
    // ];

    // protected $casts = [
    //     'cost' => 'decimal:2',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    //     'deleted_at' => 'datetime',
    // ];

    // public function project(): BelongsTo
    // {
    //     return $this->belongsTo(Project::class);
    // }

    // public function getTotalCostAttribute(): float
    // {
    //     return $this->quantity * $this->cost;
    // }

    protected $fillable = [
        'title',
        'description',
        'file_url',
        'resource_type',
        'visible_to_roles',
        'created_by',
    ];

    protected $casts = [
        'visible_to_roles' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}