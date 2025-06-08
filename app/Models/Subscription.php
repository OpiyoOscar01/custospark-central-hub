<?php
// app/Models/Subscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'app_id',
        'plan_id',
        'status',
        'ends_at',
        'renews_at',
        'next_plan_id',
        'next_plan_payment_status',
        'next_plan_payment_id',
    ];
protected $casts = [
    'trial_ends_at' => 'datetime',
];


    public function user()   { return $this->belongsTo(User::class); }
    public function app()    { return $this->belongsTo(App::class); }
    public function plan()   { return $this->belongsTo(Plan::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
    // app/Models/Subscription.php

public function activate(): void
{
    $this->update([
        'status' => 'active',
        'ends_at' => now()->addMonth(), // or addYear() based on plan.billing_cycle
        'renews_at' => now()->addMonth(),
    ]);
}

public function cancel(): void
{
    $this->update(['status' => 'canceled']);
}

public function enterGracePeriod(): void
{
    $this->update(['status' => 'grace']);
}

}
