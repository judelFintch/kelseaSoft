<?php

namespace App\Exports;

use App\Models\GlobalInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class GlobalInvoiceSummaryExport implements FromCollection, WithHeadings
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

        $rows[] = [
            'Type' => 'Facture Globale',
            'Numéro' => $this->globalInvoice->global_invoice_number,
            'Date' => optional($this->globalInvoice->issue_date)->format('Y-m-d'),
            'Montant' => $this->globalInvoice->total_amount,
        ];

        foreach ($this->globalInvoice->invoices as $invoice) {
            $rows[] = [
                'Type' => 'Facture Partielle',
                'Numéro' => $invoice->invoice_number,
                'Date' => optional($invoice->invoice_date)->format('Y-m-d'),
                'Montant' => $invoice->total_usd,
            ];
        }

        $totalPartial = $this->globalInvoice->invoices->sum('total_usd');
        $balance = $this->globalInvoice->total_amount - $totalPartial;

        $rows[] = [
            'Type' => 'Solde',
            'Numéro' => '',
            'Date' => '',
            'Montant' => $balance,
        ];

        return collect($rows);
    }

    public function headings(): array
    {
        return ['Type', 'Numéro', 'Date', 'Montant (USD)'];
    }
}
