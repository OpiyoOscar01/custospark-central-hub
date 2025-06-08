<?php

// app/Repositories/InvoiceRepository.php

namespace App\Repositories;

use App\Models\Invoice;
use Exception;

class InvoiceRepository
{
    /**
     * Store a new invoice.
     *
     * @param  array  $data
     * @return Invoice
     */
    public function store(array $data): Invoice
    {
        try {
            return Invoice::create($data);
        } catch (Exception $e) {
            throw new Exception("Error storing invoice: " . $e->getMessage());
        }
    }

    /**
     * Get all invoices.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Invoice::all();
    }

    /**
     * Find an invoice by ID.
     *
     * @param  string  $id
     * @return Invoice|null
     */
    public function findById(string $id): ?Invoice
    {
        return Invoice::find($id);
    }
}
