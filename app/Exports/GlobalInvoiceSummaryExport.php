<?php

namespace App\Exports;

use App\Models\GlobalInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class GlobalInvoiceSummaryExport implements FromCollection
{
    protected GlobalInvoice $globalInvoice;

    public function __construct(GlobalInvoice $globalInvoice)
    {
        // Ensure invoices relation is loaded for totals
        $this->globalInvoice = $globalInvoice->load('invoices');
    }

    public function collection()
    {
        $rows = [];

        // En-têtes et récapitulatif
        $rows[] = ['Type', 'Numéro', 'Date', 'Montant (USD)', ''];
        $rows[] = ['Facture Globale', $this->globalInvoice->global_invoice_number, optional($this->globalInvoice->issue_date)->format('Y-m-d'), $this->globalInvoice->total_amount, ''];

        foreach ($this->globalInvoice->invoices as $invoice) {
            $rows[] = ['Facture Partielle', $invoice->invoice_number, optional($invoice->invoice_date)->format('Y-m-d'), $invoice->total_usd, ''];
        }

        $totalPartial = $this->globalInvoice->invoices->sum('total_usd');
        $balance = $this->globalInvoice->total_amount - $totalPartial;

        $rows[] = ['Solde', '', '', $balance, ''];

        // Ligne vide de séparation
        $rows[] = ['', '', '', '', ''];

        // Détails des éléments agrégés
        $rows[] = ['Réf.', 'Libellé', 'Qté', 'P.U (USD)', 'Total (USD)'];

        foreach ($this->globalInvoice->globalInvoiceItems as $item) {
            $rows[] = [
                $item->ref_code,
                $item->description,
                number_format($item->quantity, 2),
                number_format($item->unit_price, 2),
                number_format($item->total_price, 2),
            ];
        }

        return collect($rows);
    }

}
