<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShowInvoice extends Component
{
    public Invoice $invoice;

    /**
     * Initialisation du composant avec chargement des relations.
     */
    public function mount($invoice): void
    {
        //$this->invoice = Invoice::with(['company', 'items'])->findOrFail($invoice);
    }

    /**
     * Téléchargement de la facture au format PDF.
     */
    

    /**
     * Rendu du composant.
     */
    public function render()
    {
        return view('livewire.admin.invoices.show-invoice');
    }
}
