<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    // Tell Eloquent the primary key is a string (UUID) and non-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    // If you want, you can explicitly set the primary key column (default is 'id')
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'subscription_id', 'amount', 'currency', 'method',
        'status', 'transaction_id', 'paid_at', 'prorated_amount', 'prorated_extra_days',
    ];

    public static function boot()
    {
        parent::boot();

        // Automatically generate UUID when creating a Payment
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}


