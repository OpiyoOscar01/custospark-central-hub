<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'app_id',
        'referral_id',
        'amount',
        'payment_method',
        'payment_details',
        'approved_by',
        'paid_at',
        'status',
        'currency',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * The user who will receive the payout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The app under which this referral reward occurred.
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * The referral that triggered this payout.
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    /**
     * The admin/user who approved the payout.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if the payout has been marked as paid.
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }
}
