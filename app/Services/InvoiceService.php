<?php

// app/Services/InvoiceService.php

namespace App\Services;

use App\Repositories\InvoiceRepository;
use App\Models\Invoice;
use Exception;

class InvoiceService
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository
    ) {}

    /**
     * Store a new invoice.
     *
     * @param  array  $data
     * @return Invoice
     */
    public function createInvoice(array $data): Invoice
    {
        try {
            // Create the invoice using the repository
            return $this->invoiceRepository->store($data);
        } catch (Exception $e) {
            // Handle exception if any error occurs
            throw new Exception("Error creating invoice: " . $e->getMessage());
        }
    }

    /**
     * Get all invoices.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllInvoices()
    {
        return $this->invoiceRepository->all();
    }

    /**
     * Get an invoice by ID.
     *
     * @param  string  $id
     * @return Invoice|null
     */
    public function getInvoiceById(string $id): ?Invoice
    {
        return $this->invoiceRepository->findById($id);
    }
}

