<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvoiceIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function exportPdf($invoiceId)
    {
        $invoice = Invoice::with([
            'company',
            'items.tax',
            'items.agencyFee',
            'items.extraFee',
        ])->findOrFail($invoiceId);

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Facture_' . $invoice->invoice_number . '.pdf'
        );
    }

    
    public function render()
    {
        $invoices = Invoice::with('company')
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', "%{$this->search}%")
                    ->orWhereHas('company', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.invoices.invoice-index', [
            'invoices' => $invoices,
        ]);
    }
}
