<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'positions',
        'deadline',
        'requirements'
    ];

    protected $casts = [
        'type' => 'array',
        'requirements' => 'array',
        'deadline' => 'date',
        'positions' => 'integer'
    ];
}