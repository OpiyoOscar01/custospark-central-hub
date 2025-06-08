<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $table = 'coupon_user';

    protected $fillable = [
        'coupon_id',
        'user_id',
        'app_id',
        'used_at',
        'times_used',
        'max_uses_per_user',
    ];

    public $timestamps = true;
}

