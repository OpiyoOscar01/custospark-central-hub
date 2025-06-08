<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class PaymentRepository
{
    /**
     * Store a new payment in the database.
     *
     * @param  array  $data
     * @return Payment
     */
    public function store(array $data): Payment
    {
        try {
            return Payment::create($data);
        } catch (Exception $e) {
            // Handle any exception that occurs while storing payment
            throw new Exception("Error storing payment: " . $e->getMessage());
        }
    }

    /**
     * Retrieve all payments.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Payment::with(['user', 'subscription'])->latest()->get();
    }

    /**
     * Find a payment by its ID.
     *
     * @param  string  $id
     * @return Payment|null
     */
    public function findById(string $id): ?Payment
    {
        return Payment::find($id);
    }
}


