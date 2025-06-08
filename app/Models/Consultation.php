<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'country_code',
        'custom_country_code',
        'phone',
        'timezone',
        'preferred_date',
        'preferred_start',
        'preferred_end',
        'meeting_type',
        'organization',
        'message',
        'status',
        'user_id'
    ];

    protected $casts = [
        'preferred_day' => 'date',
        'preferred_start' => 'datetime:H:i',
        'preferred_end' => 'datetime:H:i',
    ];
    public function assignedUser()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
