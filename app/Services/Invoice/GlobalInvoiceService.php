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


class GlobalInvoiceService
{
    /**
     * Génère un numéro unique pour la facture globale.
     * Format: GLOB-YYYY-XXXX (XXXX est un numéro séquentiel)
     *
     * @return string
     * @throws Exception
     */
    public function generateGlobalInvoiceNumber(): string
    {
        $year = Carbon::now()->year;
        $prefix = "GLOB-{$year}-";

        do {
            // Récupère le dernier numéro de facture globale pour l'année en cours
            $lastInvoice = GlobalInvoice::where('global_invoice_number', 'like', $prefix . '%')
                ->orderBy('global_invoice_number', 'desc')
                ->first();

            $nextSequentialNumber = 1;
            if ($lastInvoice) {
                // Extrait le numéro séquentiel et l'incrémente
                // Exemple: GLOB-2023-0001 -> 0001
                $lastSequentialPart = substr($lastInvoice->global_invoice_number, strlen($prefix));
                if (is_numeric($lastSequentialPart)) {
                    $nextSequentialNumber = intval($lastSequentialPart) + 1;
                } else {
                    // Cas de secours si le format n'est pas comme attendu, bien que peu probable
                    // ou si le dernier numéro était GLOB-YYYY- (sans partie numérique)
                    // On cherche le max des numéros existants qui ont un suffixe numérique
                    $maxNumber = GlobalInvoice::where('global_invoice_number', 'like', $prefix . '%')
                        ->get()
                        ->map(function ($gi) use ($prefix) {
                            $numPart = str_replace($prefix, '', $gi->global_invoice_number);
                            return is_numeric($numPart) ? intval($numPart) : 0;
                        })
                        ->max();
                    $nextSequentialNumber = ($maxNumber ?? 0) + 1;
                }
            }

            // Formate le numéro séquentiel sur 4 chiffres (ex: 0001, 0010, 0100, 1000)
            $sequentialFormatted = str_pad($nextSequentialNumber, 4, '0', STR_PAD_LEFT);
            $newInvoiceNumber = $prefix . $sequentialFormatted;

            // Vérifie si ce numéro existe déjà (pour gérer les rares cas de concurrence)
            $exists = GlobalInvoice::where('global_invoice_number', $newInvoiceNumber)->exists();

        } while ($exists); // Si le numéro existe, on régénère

        return $newInvoiceNumber;
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
            $aggregatedItems = [];
            $totalGlobalAmount = 0;

            foreach ($invoices as $invoice) {
                foreach ($invoice->items as $item) {
                    // Clé d'agrégation: description et prix unitaire.
                    // Pourrait être affiné (ex: normaliser la description, ajouter la devise si multi-devises)
                    $aggregationKey = md5(strtolower(trim($item->description)) . '_' . $item->unit_price);

                    if (!isset($aggregatedItems[$aggregationKey])) {
                        $aggregatedItems[$aggregationKey] = [
                            'description' => $item->description,
                            'quantity' => 0,
                            'unit_price' => $item->unit_price,
                            'total_price' => 0,
                            'original_item_ids' => [],
                        ];
                    }

                    $aggregatedItems[$aggregationKey]['quantity'] += $item->quantity;
                    $aggregatedItems[$aggregationKey]['total_price'] += $item->total_price; // ou recalculer: $item->quantity * $item->unit_price
                    $aggregatedItems[$aggregationKey]['original_item_ids'][] = $item->id;
                }
            }
            
            // Recalculer total_price pour chaque item agrégé et le total global
            foreach ($aggregatedItems as &$aggItem) { // Notez le '&' pour modifier l'array directement
                // S'assurer que total_price est bien la somme des (quantité * prix unitaire) si la logique originale des items le fait
                // Ici, on suppose que $item->total_price était déjà correct.
                // Si on veut recalculer: $aggItem['total_price'] = $aggItem['quantity'] * $aggItem['unit_price'];
                $totalGlobalAmount += $aggItem['total_price'];
            }
            unset($aggItem); // Important après une boucle avec référence


            $globalInvoiceNumber = $this->generateGlobalInvoiceNumber();

            $globalInvoice = GlobalInvoice::create([
                'global_invoice_number' => $globalInvoiceNumber,
                'company_id' => $companyId,
                'issue_date' => Carbon::today(),
                'due_date' => null, // À définir selon la logique métier, ex: issue_date + 30 jours
                'total_amount' => $totalGlobalAmount,
                'notes' => 'Facture globale générée automatiquement.', // Optionnel
            ]);

            foreach ($aggregatedItems as $aggItemData) {
                $globalInvoice->globalInvoiceItems()->create([
                    'description' => $aggItemData['description'],
                    'quantity' => $aggItemData['quantity'],
                    'unit_price' => $aggItemData['unit_price'],
                    'total_price' => $aggItemData['total_price'],
                    'original_item_ids' => json_encode($aggItemData['original_item_ids']),
                ]);
            }

            // Mettre à jour les factures originales
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
