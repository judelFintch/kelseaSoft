<?php

namespace App\Services\Invoice;

use App\Models\GlobalInvoice;
use App\Models\GlobalInvoiceItem;
use App\Models\Invoice;
use App\Models\Company; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Services\Invoice\InvoiceService;


class GlobalInvoiceService
{
    /**
     * Génère un numéro unique pour la facture globale en utilisant le service commun.
     */
    public function generateGlobalInvoiceNumber(int $companyId): string
    {
        return InvoiceService::generateInvoiceNumber($companyId, true);
    }

    /**
     * Crée une facture globale à partir de factures individuelles sélectionnées.
     *
     * @param array $invoiceIds IDs des factures à regrouper.
     * @param int $companyId ID de la compagnie.
     * @return GlobalInvoice
     * @throws ValidationException|Exception
     */
    public function createGlobalInvoice(array $invoiceIds, int $companyId): GlobalInvoice
    {
        if (empty($invoiceIds)) {
            throw ValidationException::withMessages(['invoice_ids' => 'La liste des IDs de facture ne peut pas être vide.']);
        }

        // Valide que companyId correspond à une compagnie existante (optionnel, dépend de la logique métier)
        // $company = Company::findOrFail($companyId); // Décommenter si nécessaire

        $invoices = Invoice::with('items') // Eager load items pour l'agrégation
                            ->whereIn('id', $invoiceIds)
                            ->where('company_id', $companyId)
                            ->get();

        if (count($invoices) !== count($invoiceIds)) {
            throw ValidationException::withMessages(['invoice_ids' => 'Une ou plusieurs factures n\'ont pas été trouvées ou n\'appartiennent pas à la compagnie spécifiée.']);
        }

        foreach ($invoices as $invoice) {
            if (!is_null($invoice->global_invoice_id)) {
                throw ValidationException::withMessages(['invoice_ids' => "La facture #{$invoice->invoice_number} est déjà regroupée dans une facture globale."]);
            }
            // Supposons que 'pending' ou 'approved' sont des statuts valides pour le regroupement.
            // À adapter selon les statuts réels de l'application.
            // if (!in_array($invoice->status, ['pending', 'approved'])) {
            //     throw ValidationException::withMessages(['invoice_ids' => "La facture #{$invoice->invoice_number} a un statut ({$invoice->status}) qui ne permet pas le regroupement."]);
            // }
        }

        return DB::transaction(function () use ($invoices, $companyId) {
            $aggregated = [];

            foreach ($invoices as $invoice) {
                foreach ($invoice->items as $item) {
                    if (is_null($item->label) || trim($item->label) === '') {
                        throw ValidationException::withMessages([
                            'items' => "L'article {$item->id} n'a pas de libellé",
                        ]);
                    }

                    $key = $item->label;

                    if (!isset($aggregated[$key])) {
                        $aggregated[$key] = [
                            'description' => $item->label,
                            'quantity' => 0,
                            'unit_price' => $item->amount_usd,
                            'total_price' => 0,
                            'original_item_ids' => [],
                        ];
                    }

                    $aggregated[$key]['quantity'] += 1;
                    $aggregated[$key]['total_price'] += $item->amount_usd;
                    $aggregated[$key]['unit_price'] = $item->amount_usd; // in case amounts vary
                    $aggregated[$key]['original_item_ids'][] = $item->id;
                }
            }

            $itemsToCopy = array_values($aggregated);
            $totalGlobalAmount = array_sum(array_column($itemsToCopy, 'total_price'));

            $globalInvoiceNumber = $this->generateGlobalInvoiceNumber($companyId);

            $globalInvoice = GlobalInvoice::create([
                'global_invoice_number' => $globalInvoiceNumber,
                'company_id' => $companyId,
                'issue_date' => Carbon::today(),
                'due_date' => null, // À définir selon la logique métier
                'total_amount' => $totalGlobalAmount,
                'notes' => 'Facture globale générée automatiquement.',
            ]);

            foreach ($itemsToCopy as $itemData) {
                $globalInvoice->globalInvoiceItems()->create($itemData);
            }

            $invoiceStatusForGrouped = 'grouped_in_global_invoice'; // Ou une constante/enum
            foreach ($invoices as $invoice) {
                $invoice->global_invoice_id = $globalInvoice->id;
                $invoice->status = $invoiceStatusForGrouped;
                $invoice->save();
            }

            return $globalInvoice;
        });
    }
}
