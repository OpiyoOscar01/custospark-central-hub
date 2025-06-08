<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $invoiceService
    ) {}

    /**
     * Store a new invoice.
     *
     * @param  StoreInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoiceData = $request->validated();
        
        // Call service to create an invoice
        $invoice = $this->invoiceService->createInvoice($invoiceData);

        return response()->json([
            'message' => 'Invoice created successfully.',
            'data' => $invoice
        ], 201);
    }

    /**
     * Get all invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();
        
        return response()->json([
            'data' => $invoices
        ]);
    }

    /**
     * Get an invoice by ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $invoice = $this->invoiceService->getInvoiceById($id);

        if (!$invoice) {
            return response()->json([
                'message' => 'Invoice not found.'
            ], 404);
        }

        return response()->json([
            'data' => $invoice
        ]);
    }
}

