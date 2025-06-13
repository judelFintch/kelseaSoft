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
     * New format: MDB{ACRONYM}[GL]{NN}{mmyy}
     */
    public static function generateInvoiceNumber(int $companyId, bool $global = false): string
    {
        $company = Company::notDeleted()->findOrFail($companyId);
        $acronym = strtoupper($company->acronym);
        $prefix = 'MDB' . $acronym . ($global ? 'GL' : '');

        $column = $global ? 'global_invoice_number' : 'invoice_number';
        $table = $global ? (new GlobalInvoice)->getTable() : (new Invoice)->getTable();

        $like = $prefix . '%';
        $lastNumber = DB::table($table)
            ->where($column, 'like', $like)
            ->orderBy($column, 'desc')
            ->value($column);

        $start = $global
            ? config('invoice.global_start_number', 57)
            : config('invoice.start_number', 335);
        $next = $start;
        if ($lastNumber) {
            $numPart = substr($lastNumber, strlen($prefix), -4);
            if (is_numeric($numPart)) {
                $next = (int)$numPart + 1;
            }
        }
        $padLength = max(3, strlen((string) $start));
        $sequential = str_pad($next, $padLength, '0', STR_PAD_LEFT);
        $suffix = Carbon::now()->format('my');
        return $prefix . $sequential . $suffix;
    }
}
