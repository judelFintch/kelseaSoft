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

class GlobalInvoiceShow extends Component
{
    public GlobalInvoice $globalInvoice;

    public function mount(GlobalInvoice $globalInvoice): void
    {
        $this->globalInvoice = $globalInvoice;
        // Charge les relations nécessaires.
        // globalInvoiceItems est la relation définie dans le modèle GlobalInvoice
        // company est la relation pour la compagnie associée
        // invoices est la relation pour les factures individuelles (si vous voulez les lister)
        $this->globalInvoice->load(['globalInvoiceItems', 'company', 'invoices']);
    }

    public function downloadPdf(): StreamedResponse
    {
        $filename = 'Facture_Globale_' . $this->globalInvoice->global_invoice_number . '.pdf';


        $pdf = Pdf::loadView('pdf.global_invoice', [
            'globalInvoice' => $this->globalInvoice,
        ]);
        // La vue 'pdf.global_invoice' doit être créée.
        // Elle recevra la variable $globalInvoice contenant l'objet GlobalInvoice avec ses relations chargées.

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

    public function render()
    {
        return view('livewire.admin.invoices.global-invoice-show'); // Supposant une layout admin existante
    }
}
