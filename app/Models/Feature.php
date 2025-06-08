<?php
// app/Models/Feature.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $table='features';

    protected $fillable = [
        'app_id',
        'min_plan_level',
        'name',
        'code',
        'description',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function plans()
{
    return $this->belongsToMany(Plan::class, 'feature_plans')
                ->withPivot('value')
                ->withTimestamps();
}

}

