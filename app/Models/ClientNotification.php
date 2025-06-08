<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientNotification extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'content',
        'type',
        'link',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function markAsRead(): void
    {
        $this->read_at = now();
        $this->save();
    }
}