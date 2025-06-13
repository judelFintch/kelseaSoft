<?php

namespace App\Services\Invoice;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceSequence;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceService
{
    /**
     * Génère un numéro de facture unique basé sur la séquence par entreprise.
     */
    public static function generateInvoiceNumber(int $companyId, bool $global = false): string
    {

        $company = Company::notDeleted()->findOrFail($companyId);
        $acronym = strtoupper($company->acronym);
        $prefix = 'MDB' . $acronym . ($global ? 'GL' : '');
        $type = $global ? 'global' : 'normal';

        return DB::transaction(function () use ($companyId, $type, $prefix, $global) {

            // Ici tu définis ton démarrage de base
            $startNumber = $global ? 57 : 336;

            // Création de la séquence s'il n'existe pas encore
            $sequence = InvoiceSequence::firstOrCreate(
                ['company_id' => $companyId, 'type' => $type],
                ['current_number' => $startNumber - 1] // On démarre juste avant
            );

            // Incrémentation normale
            $sequence->increment('current_number');
            $sequence->refresh();

            $next = $sequence->current_number;

            $padLength = 3;
            $sequential = str_pad($next, $padLength, '0', STR_PAD_LEFT);
            $suffix = $global ? Carbon::now()->format('my') : Carbon::now()->format('y');

            return $prefix . $sequential . $suffix;
        });
    }
}
