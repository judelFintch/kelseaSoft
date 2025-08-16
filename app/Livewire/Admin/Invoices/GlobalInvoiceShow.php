<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\GlobalInvoice;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf; // Assurez-vous que Barryvdh DomPDF est installé et configuré
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GlobalInvoiceSummaryExport;
use App\Services\Enterprise\EnterpriseService;
use App\Services\Invoice\GlobalInvoiceService;

class GlobalInvoiceShow extends Component
{
    public GlobalInvoice $globalInvoice;

    /**
     * Vérifie si les factures partielles associées ont été modifiées.
     * Si c'est le cas, synchronise la facture globale.
     */
    public function checkPartialsUpdates(GlobalInvoiceService $service): void
    {
        if ($service->syncGlobalInvoice($this->globalInvoice)) {
            $this->globalInvoice->refresh()->load(['globalInvoiceItems', 'company', 'invoices']);
            session()->flash('success', 'Des mises à jour des factures partielles ont été détectées. La facture globale a été synchronisée.');
        }
    }

    public function mount(GlobalInvoice $globalInvoice): void
    {
        $this->globalInvoice = $globalInvoice;
        // Charge les relations nécessaires.
        // globalInvoiceItems est la relation définie dans le modèle GlobalInvoice
        // company est la relation pour la compagnie associée
        // invoices est la relation pour les factures individuelles (si vous voulez les lister)
        $this->globalInvoice->load(['globalInvoiceItems', 'company', 'invoices']);
    }

    public function downloadPdf1(): StreamedResponse
    {
        $filename = 'Facture_Globale_' . $this->globalInvoice->global_invoice_number . '_1.pdf';

        $pdf = Pdf::loadView('pdf.global_invoice', [
            'globalInvoice' => $this->globalInvoice,
            'categories' => [
                'import_tax' => 'A. IMPORT DUTY & TAXES',
            ],
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }

    public function downloadPdf2(): StreamedResponse
    {
        $filename = 'Facture_Globale_' . $this->globalInvoice->global_invoice_number . '_2.pdf';

        $pdf = Pdf::loadView('pdf.global_invoice', [
            'globalInvoice' => $this->globalInvoice,
            'categories' => [
                'agency_fee' => 'B. AGENCY FEES',
                'extra_fee' => 'C. AUTRES FRAIS',
            ],
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }

    public function downloadPdf3(): StreamedResponse
    {
        $filename = 'Facture_Globale_' . $this->globalInvoice->global_invoice_number . '_3.pdf';

        $pdf = Pdf::loadView('pdf.global_invoice', [
            'globalInvoice' => $this->globalInvoice,
            'categories' => [
                'import_tax' => 'A. IMPORT DUTY & TAXES',
                'agency_fee' => 'B. AGENCY FEES',
                'extra_fee' => 'C. AUTRES FRAIS',
            ],
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }

    public function exportSummary(): BinaryFileResponse
    {
        $filename = 'Global_Invoice_Summary_' . $this->globalInvoice->global_invoice_number . '.xlsx';

        return Excel::download(new GlobalInvoiceSummaryExport($this->globalInvoice), $filename);
    }

    public function markAsPaid(): void
    {
        $this->globalInvoice->update(['status' => 'paid']);
        $this->globalInvoice->invoices()->update(['status' => 'paid']);
        session()->flash('success', 'Facture globale marquée comme payée.');
    }

    public function markAsPending(): void
    {
        $this->globalInvoice->update(['status' => 'pending']);
        $this->globalInvoice->invoices()->update(['status' => 'pending']);
        session()->flash('success', 'Facture globale marquée comme en attente.');
    }

    /**
     * Régénère la facture globale en se basant sur les factures partielles actives.
     * Le numéro de facture reste inchangé.
     */
    public function regenerate(GlobalInvoiceService $service): void
    {
        if ($service->syncGlobalInvoice($this->globalInvoice)) {
            $this->globalInvoice->refresh()->load(['globalInvoiceItems', 'company', 'invoices']);
            session()->flash('success', 'Facture globale régénérée avec succès.');
        } else {
            session()->flash('success', 'Aucune mise à jour nécessaire.');
        }
    }

    public function render()
    {
        return view('livewire.admin.invoices.global-invoice-show'); // Supposant une layout admin existante
    }
}
