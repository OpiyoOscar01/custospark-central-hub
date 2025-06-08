<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'level',
        'name',
        'slug',
        'price',
        'plan_type',
        'trial_days',
        'billing_cycle',
        'description',
        'is_popular',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_plans')
                    ->withPivot('value')
                    ->withTimestamps();
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
