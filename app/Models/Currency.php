<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code', 'name', 'exchange_rate', 'symbol', 'is_active',
    ];

    public static function usd()
    {
        return static::where('code', 'USD')->first();
    }

    public function format($amount)
    {
        return $this->symbol . number_format($amount * $this->exchange_rate, 2);
    }
}

