<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientInvoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

    class InvoiceController extends Controller
    {
    use AuthorizesRequests;
    public function index(): View
    {
        $invoices = Auth::user()->client->invoices()
            ->with(['project'])
            ->latest()
            ->get();

        return view('client.invoices.index', compact('invoices'));
    }

    public function show(ClientInvoice $invoice): View
    {
        $this->authorize('view', $invoice);
        
        $invoice->load(['items', 'project']);
        
        if ($invoice->status === 'sent') {
            $invoice->status = 'viewed';
            $invoice->save();
        }

        return view('client.invoices.show', compact('invoice'));
    }

    public function approve(ClientInvoice $invoice): RedirectResponse
    {
        $this->authorize('approve', $invoice);

        $invoice->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        return redirect()->route('client.invoices.show', $invoice)
            ->with('success', 'Invoice approved successfully.');
    }

    public function download(ClientInvoice $invoice)
    {
        $this->authorize('view', $invoice);
        return $invoice->generatePdf()->download("invoice-{$invoice->invoice_number}.pdf");
    }
}