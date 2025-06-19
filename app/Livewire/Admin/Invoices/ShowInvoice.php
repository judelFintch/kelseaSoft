<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\Enterprise\EnterpriseService;

class ShowInvoice extends Component
{
    public Invoice $invoice;

    public float $itemsTotal = 0;
    public float $difference = 0;
    public bool $showSyncPrompt = false;

    /**
     * Initialisation du composant avec chargement des relations.
     */
    public function mount(Invoice $invoice): void // Utilisation du Route Model Binding de Livewire
    {
        // Charge les relations nécessaires, y compris 'folder'
        $this->invoice = $invoice->load(['company', 'items', 'folder']);
        $this->calculateTotals();
    }

    public function calculateTotals(): void
    {
        $this->itemsTotal = $this->invoice->items->sum('amount_usd');
        $this->difference = round($this->itemsTotal - $this->invoice->total_usd, 2);
    }

    public function checkTotals(): void
    {
        $this->invoice->refresh()->load('items');
        $this->calculateTotals();

        if ($this->difference != 0) {
            $this->showSyncPrompt = true;
        } else {
            session()->flash('success', 'Les totaux sont déjà synchronisés.');
        }
    }

    public function synchronize(): void
    {
        $this->calculateTotals();
        $this->invoice->total_usd = $this->itemsTotal;
        $this->invoice->save();
        $this->showSyncPrompt = false;
        $this->difference = 0;
        session()->flash('success', 'Facture synchronisée avec succès.');
    }

    /**
     * Téléchargement de la facture au format PDF.
     */

    public function downloadPdf(): StreamedResponse
    {
        $filename = 'Facture_' . $this->invoice->invoice_number . '.pdf';

        $enterprise = EnterpriseService::getEnterprise();
        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $this->invoice,
            'enterprise' => $enterprise,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename
        );
    }
    

    /**
     * Rendu du composant.
     */
    public function render()
    {
        return view('livewire.admin.invoices.show-invoice');
    }
}