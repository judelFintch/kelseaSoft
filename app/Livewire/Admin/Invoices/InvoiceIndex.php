<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use Livewire\WithPagination;

use App\Services\Invoice\GlobalInvoiceService; // Ajout du service
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log; // Pour le débogage potentiel
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Validation\ValidationException; // Pour les erreurs de validation du service

class InvoiceIndex extends Component
{
    use WithPagination;

    public $search = '';
    public array $selectedInvoices = [];
    public ?int $companyIdForGlobalInvoice = null;

    /**
     * Hook exécuté lorsque la propriété $selectedInvoices est mise à jour.
     *
     * @param mixed $value
     * @return void
     */
    public function updatedSelectedInvoices($value): void
    {
        if (!empty($this->selectedInvoices)) {
            $firstInvoiceId = $this->selectedInvoices[0];
            $firstInvoice = Invoice::find($firstInvoiceId);
            if ($firstInvoice) {
                $this->companyIdForGlobalInvoice = $firstInvoice->company_id;
            }
        } else {
            $this->companyIdForGlobalInvoice = null;
        }
    }

    /**
     * Crée une facture globale à partir des factures sélectionnées.
     *
     * @param GlobalInvoiceService $globalInvoiceService
     * @return void
     */
    public function createGlobalInvoice(GlobalInvoiceService $globalInvoiceService): void
    {
        if (empty($this->selectedInvoices)) {
            session()->flash('error', 'Aucune facture sélectionnée.');
            return;
        }

        if (is_null($this->companyIdForGlobalInvoice)) {
            // Cela ne devrait pas arriver si updatedSelectedInvoices fonctionne correctement
            session()->flash('error', 'L\'ID de la compagnie n\'est pas défini.');
            return;
        }

        // Validation supplémentaire: toutes les factures doivent appartenir à la même compagnie
        $invoicesToProcess = Invoice::whereIn('id', $this->selectedInvoices)->get();
        foreach ($invoicesToProcess as $invoice) {
            if ($invoice->company_id !== $this->companyIdForGlobalInvoice) {
                session()->flash('error', 'Toutes les factures sélectionnées doivent appartenir à la même compagnie.');
                return;
            }
            if (!is_null($invoice->global_invoice_id)) {
                session()->flash('error', "La facture {$invoice->invoice_number} est déjà incluse dans une facture globale.");
                return;
            }
        }

        try {
            $globalInvoice = $globalInvoiceService->createGlobalInvoice(
                $this->selectedInvoices,
                $this->companyIdForGlobalInvoice
            );

            session()->flash('success', 'Facture globale ' . $globalInvoice->global_invoice_number . ' créée avec succès.');
            $this->selectedInvoices = [];
            $this->companyIdForGlobalInvoice = null;
            // On pourrait vouloir forcer un rafraîchissement des données ici,
            // mais Livewire devrait le faire automatiquement avec la réinitialisation des propriétés.
            // $this->render(); // ou une méthode spécifique pour recharger les factures
        } catch (ValidationException $e) {
            session()->flash('error', 'Erreur de validation: ' . $e->getMessage() . ' (Détails: ' . implode(', ', array_map(fn($errors) => implode(', ', $errors), $e->errors())) . ')');
            Log::error('ValidationException during global invoice creation: ' . $e->getMessage(), $e->errors());
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création de la facture globale: ' . $e->getMessage());
            Log::error('Exception during global invoice creation: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }


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
