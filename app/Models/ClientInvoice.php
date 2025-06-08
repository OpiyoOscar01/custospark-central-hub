<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'client_id',
        'invoice_number',
        'amount',
        'due_date',
        'status',
        'notes',
        'approved_at',
        'paid_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function generateInvoiceNumber(): void
    {
        $latestInvoice = self::latest()->first();
        $nextNumber = $latestInvoice ? (int)substr($latestInvoice->invoice_number, 3) + 1 : 1;
        $this->invoice_number = 'INV' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function calculateAmount(): void
    {
        $this->amount = $this->items->sum('amount');
        $this->save();
    }

    public function markAsOverdue(): void
    {
        if ($this->due_date < now() && $this->status !== 'paid') {
            $this->status = 'overdue';
            $this->save();
        }
    }
}