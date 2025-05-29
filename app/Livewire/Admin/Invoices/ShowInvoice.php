<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShowInvoice extends Component
{

    public Invoice $invoice;

    public function mount($invoice)
    {
        $this->invoice = Invoice::with('company', 'items')->findOrFail($invoice);
    }

    public function downloadPdf(): StreamedResponse
    {
        $pdf = Pdf::loadView('pdf.invoice', ['invoice' => $this->invoice]);
        return response()->streamDownload(
            fn() => print($pdf->output()),
            'facture-' . $this->invoice->invoice_number . '.pdf'
        );
    }
    public function render()
    {
        return view('livewire.admin.invoices.show-invoice');
    }
}
