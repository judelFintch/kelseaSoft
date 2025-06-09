<?php

namespace App\Services\Invoice;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\GlobalInvoice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceService
{
    /**
     * Generate a unique invoice number.
     * Format: MDB{ACRONYM}[GLO-]{NNN}-{mmyy}
     */
    public static function generateInvoiceNumber(int $companyId, bool $global = false): string
    {
        $company = Company::findOrFail($companyId);
        $acronym = strtoupper($company->acronym);
        $prefix = 'MDB' . $acronym . ($global ? 'GLO-' : '');

        $column = $global ? 'global_invoice_number' : 'invoice_number';
        $table = $global ? (new GlobalInvoice)->getTable() : (new Invoice)->getTable();

        $like = $prefix . '%';
        $lastNumber = DB::table($table)
            ->where($column, 'like', $like)
            ->orderBy($column, 'desc')
            ->value($column);

        $next = 1;
        if ($lastNumber) {
            $numPart = substr($lastNumber, strlen($prefix), 3);
            if (is_numeric($numPart)) {
                $next = (int)$numPart + 1;
            }
        }

        $sequential = str_pad($next, 3, '0', STR_PAD_LEFT);
        $suffix = Carbon::now()->format('my');
        return $prefix . $sequential . '-' . $suffix;
    }
}
