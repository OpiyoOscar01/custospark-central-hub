<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'app_id',
        'type',
        'message',
        'complaint_categories',
        'attachments',
        'rating',
        'status',
        'admin_response',
        'responded_at',
        'source',
        'admin_id',
    ];

    protected $casts = [
        'complaint_categories' => 'array',
        'attachments' => 'array',
        'responded_at' => 'datetime',
    ];

    /**
     * The user who submitted the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The application this feedback is related to.
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * The admin who responded to or handled the feedback.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
