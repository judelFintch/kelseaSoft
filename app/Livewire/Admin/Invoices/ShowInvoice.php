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
    public function mount(Invoice $invoice): void // Utilisation du Route Model Binding de Livewire
    {
        // Charge les relations nécessaires, y compris 'folder'
        $this->invoice = $invoice->load(['company', 'items', 'folder']);
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
