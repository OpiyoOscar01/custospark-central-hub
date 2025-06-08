<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    /** @use HasFactory<\Database\Factories\AppFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'base_url',
        'icon_url',
        'description',
        'status',
    ];

    // Define relationships if any (e.g. One-to-many with plans, features)
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
    public function coupons()
{
    return $this->hasMany(Coupon::class);
}
  public function referralLinks()
{
    return $this->hasMany(ReferralLink::class);
}


    public function features()
    {
        return $this->hasMany(Feature::class);
    }
    public function roles(){
        return $this->hasMany(Role::class);
    }
    public function permissions(){
        return $this->hasMany(Permission::class);
    }
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

}
