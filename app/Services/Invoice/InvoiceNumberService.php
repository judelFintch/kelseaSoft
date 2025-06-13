<?php

namespace App\Services\Invoice;

use App\Models\Invoice;

class InvoiceNumberService
{
    /**
     * Génère un numéro unique pour une facture individuelle.
     * Le format est : MDBKCCGLXXXXXX où XXXXXX est un numéro séquentiel.
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'MDBKCCGL';

        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastInvoice) {
            $numericPart = substr($lastInvoice->invoice_number, strlen($prefix));
            if (is_numeric($numericPart)) {
                $nextNumber = (int) $numericPart + 1;
            }
        }

        return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
