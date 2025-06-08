<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'app_id',
        'referral_url',
    ];

    /**
     * Get the user who owns this referral link.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the app associated with this referral link.
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * Accessor: Return referral_code from the user (optional convenience).
     */
    public function getReferralCodeAttribute()
    {
        return $this->user->referral_code;
    }
}

