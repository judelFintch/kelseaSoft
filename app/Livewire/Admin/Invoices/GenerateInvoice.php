<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\AgencyFee;
use App\Models\Company;
use App\Models\Currency;
use App\Models\ExtraFee;
use App\Models\Invoice;
use App\Models\Tax;
use App\Models\Folder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\Folder\FolderService;
use App\Services\Invoice\InvoiceService;
use Livewire\Component;

class GenerateInvoice extends Component
{
    public $step = 1;

    public $folder_id;
    public $company_id;
    public $invoice_date;
    public $product;
    public $weight;
    public $operation_code;
    public $default_fob_amount = 0;
    public $insurance_amount = 0;
    public $freight_amount = 0;
    public $cif_amount = 0;
    public $payment_mode = 'provision';
    public $currency_id = 1;
    public $exchange_rate = 500;
    public $items = [];
    public $taxes = [], $agencyFees = [], $extraFees = [], $currencies = [];
    public array $categorySteps = [];
    public array $stepLabels = [];
    public $selectedFolder = null;
    public $generatedInvoiceLabel = null;
    public $previewInvoiceNumber = null;

    public function mount(Folder $folder)
    {
        $folder = FolderService::getFolder($folder->id);

        if ($folder->invoice()->exists()) {
            session()->flash('error', "Le dossier N° {$folder->folder_number} est déjà facturé (Facture N° {$folder->invoice->invoice_number}). Impossible de créer une nouvelle facture.");
            $this->resetForm();
            return;
        }

        $this->taxes = Tax::all();
        $this->agencyFees = AgencyFee::all();
        $this->extraFees = ExtraFee::all();
        $this->currencies = Currency::all();
        $this->invoice_date = now()->toDateString();
        $this->initCategorySteps();

        $this->folder_id = $folder->id;
        $this->selectedFolder = $folder;
        $this->company_id = $folder->company_id;

        // Correction : on n'appelle plus la génération ici
        $this->previewInvoiceNumber = 'Numéro généré lors de l’enregistrement';

        $this->default_fob_amount = $folder->fob_amount ?? 0;
        $this->insurance_amount = $folder->insurance_amount ?? 0;
        $this->cif_amount = $folder->cif_amount ?? 0;
        $this->weight = $folder->weight;
        $this->product = $folder->description ?? ('Prestation selon dossier ' . $folder->folder_number);

        $calculated_freight = $this->cif_amount - $this->default_fob_amount - $this->insurance_amount;
        $this->freight_amount = $folder->freight_amount ?? max($calculated_freight, 0);

        $this->items = [];
        $this->addItem('import_tax');
    }

    protected function resetFolderSelection(): void
    {
        $this->folder_id = null;
        $this->selectedFolder = null;
    }

    public function initCategorySteps(): void
    {
        $this->categorySteps = ['import_tax', 'agency_fee', 'extra_fee'];

        $categoryLabels = [
            'import_tax' => "Taxes d'import",
            'agency_fee' => "Frais d'agence",
            'extra_fee' => 'Frais divers',
        ];

        $this->stepLabels = [1 => 'Informations générales'];

        foreach ($this->categorySteps as $index => $category) {
            $this->stepLabels[$index + 2] = $categoryLabels[$category] ?? ucfirst(str_replace('_', ' ', $category));
        }
    }

    public function updatedItems($value, $key): void
    {
        if (preg_match('/^(\d+)\.(amount_local|currency_id)$/', $key, $matches)) {
            $index = (int)$matches[1];
            $item = &$this->items[$index];
            $localAmount = (float)($item['amount_local'] ?? 0);
            $selectedCurrencyId = (int)($item['currency_id'] ?? 1);
            $selectedCurrency = Currency::find($selectedCurrencyId);

            if ($selectedCurrency) {
                $rate = $this->exchange_rate ?: 1;
                $item['exchange_rate'] = $rate;

                if (strtoupper($selectedCurrency->code) === 'USD') {
                    $item['amount_usd'] = $localAmount;
                    $item['amount_cdf'] = round($localAmount * $rate, 2);
                } elseif (strtoupper($selectedCurrency->code) === 'CDF') {
                    $item['amount_usd'] = round($localAmount / $rate, 2);
                    $item['amount_cdf'] = $localAmount;
                } else {
                    $item['amount_usd'] = round($localAmount / $rate, 2);
                    $item['amount_cdf'] = round($localAmount, 2);
                }
            }
        }
    }

    public function updatedExchangeRate($value): void
    {
        foreach ($this->items as $index => &$item) {
            $amountUsd = $item['amount_usd'] ?? 0;
            $item['converted_amount'] = round($amountUsd * (float)$value, 2);
        }
    }

    public function addItem($category = 'import_tax'): void
    {
        $this->items[] = [
            'label' => '',
            'category' => $category,
            'quantity' => 1,
            'currency_id' => $this->currency_id ?? 1,
            'exchange_rate' => $this->exchange_rate,
            'amount_local' => 0,
            'amount_usd' => 0.00,
            'converted_amount' => 0,
            'tax_id' => null,
            'agency_fee_id' => null,
            'extra_fee_id' => null,
        ];
    }

    public function removeItem($index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function nextStep(): void
    {
        if ($this->step < count($this->categorySteps) + 1) {
            $this->step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function save(): void
    {
        try {
            $validated = $this->validate([
                'company_id' => 'required|integer|exists:companies,id',
                'invoice_date' => 'required|date',
                'product' => 'required|string|max:255',
                'weight' => 'nullable|numeric',
                'operation_code' => 'nullable|string|max:255',
                'default_fob_amount' => 'required|numeric|min:0',
                'insurance_amount' => 'nullable|numeric|min:0',
                'freight_amount' => 'nullable|numeric|min:0',
                'cif_amount' => 'nullable|numeric|min:0',
                'payment_mode' => 'required|string',
                'currency_id' => 'required|integer|exists:currencies,id',
                'exchange_rate' => 'required|numeric|min:0',
                'items' => 'present|array|min:1',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.amount_local' => 'required|numeric|min:0',
                'items.*.currency_id' => 'required|integer|exists:currencies,id',
                'folder_id' => [
                    'nullable',
                    'integer',
                    'exists:folders,id',
                ],
            ]);

            foreach ($this->items as $index => $item) {
                if ($item['category'] === 'import_tax' && empty($item['tax_id'])) {
                    $this->addError("items.{$index}.tax_id", "Le champ Taxe est requis.");
                }
                if ($item['category'] === 'agency_fee' && empty($item['agency_fee_id'])) {
                    $this->addError("items.{$index}.agency_fee_id", "Le champ Frais agence est requis.");
                }
                if ($item['category'] === 'extra_fee' && empty($item['extra_fee_id'])) {
                    $this->addError("items.{$index}.extra_fee_id", "Le champ Frais divers est requis.");
                }
            }

            $this->items = array_values(array_filter($this->items, function ($item) {
                if ($item['category'] === 'import_tax' && empty($item['tax_id'])) return false;
                if ($item['category'] === 'agency_fee' && empty($item['agency_fee_id'])) return false;
                if ($item['category'] === 'extra_fee' && empty($item['extra_fee_id'])) return false;
                return true;
            }));

            foreach ($this->items as $index => &$itemRef) {
                if (empty($itemRef['currency_id'])) {
                    $this->addError("items.{$index}.currency_id", "La devise pour l'item est requise.");
                    return;
                }
                if (empty($itemRef['label'])) {
                    switch ($itemRef['category']) {
                        case 'import_tax':
                            $tax = Tax::find($itemRef['tax_id']);
                            $itemRef['label'] = $tax?->label ?? 'Taxe inconnue';
                            break;
                        case 'agency_fee':
                            $agency = AgencyFee::find($itemRef['agency_fee_id']);
                            $itemRef['label'] = $agency?->label ?? 'Frais agence inconnu';
                            break;
                        case 'extra_fee':
                            $extra = ExtraFee::find($itemRef['extra_fee_id']);
                            $itemRef['label'] = $extra?->label ?? 'Frais divers inconnu';
                            break;
                        default:
                            $itemRef['label'] = 'Item inconnu';
                    }
                }
            }
            unset($itemRef);

            $processedItems = [];
            $totalUsdFromItems = 0;

            foreach ($this->items as $itemArray) {
                $localAmount = (float)($itemArray['amount_local'] ?? 0);
                $itemCurrencyId = (int)($itemArray['currency_id'] ?? $this->currency_id);
                $itemCurrency = Currency::find($itemCurrencyId);

                $itemArray['currency_id'] = $itemCurrencyId;
                $itemArray['exchange_rate'] = $this->exchange_rate;

                if ($itemCurrency && strtoupper($itemCurrency->code) === 'USD') {
                    $itemArray['amount_usd'] = $localAmount;
                } elseif ($this->exchange_rate != 0) {
                    $itemArray['amount_usd'] = round($localAmount / $this->exchange_rate, 2);
                } else {
                    $itemArray['amount_usd'] = 0;
                }

                $itemArray['amount_cdf'] = round($itemArray['amount_usd'] * $this->exchange_rate, 2);

                $totalUsdFromItems += $itemArray['amount_usd'];
                $processedItems[] = $itemArray;
            }

            $this->items = $processedItems;
            $this->total_usd = $totalUsdFromItems;

            $invoiceData = [
                'company_id' => $this->company_id,
                'invoice_date' => Carbon::parse($this->invoice_date),
                'product' => $this->product,
                'weight' => $this->weight,
                'operation_code' => $this->operation_code,
                'fob_amount' => $this->default_fob_amount,
                'insurance_amount' => $this->insurance_amount,
                'freight_amount' => $this->freight_amount,
                'cif_amount' => $this->cif_amount,
                'payment_mode' => $this->payment_mode,
                'currency_id' => $this->currency_id,
                'exchange_rate' => $this->exchange_rate,
                'total_usd' => $this->total_usd,
                'folder_id' => $this->folder_id,
                'status' => 'pending',
            ];

            $invoice = DB::transaction(function () use ($invoiceData) {
                // ✅ Génération du numéro ici uniquement
                $invoiceData['invoice_number'] = InvoiceService::generateInvoiceNumber($this->company_id);
                $invoice = Invoice::create($invoiceData);

                foreach ($this->items as $itemData) {
                    $invoice->items()->create([
                        'label' => $itemData['label'],
                        'category' => $itemData['category'],
                        'quantity' => $itemData['quantity'] ?? 1,
                        'amount_usd' => $itemData['amount_usd'],
                        'amount_cdf' => $itemData['amount_cdf'],
                        'currency_id' => $itemData['currency_id'],
                        'exchange_rate' => $itemData['exchange_rate'],
                        'tax_id' => $itemData['tax_id'] ?? null,
                        'agency_fee_id' => $itemData['agency_fee_id'] ?? null,
                        'extra_fee_id' => $itemData['extra_fee_id'] ?? null,
                    ]);
                }

                return $invoice;
            });

            $this->generatedInvoiceLabel = $invoice->invoice_number;
            session()->flash('success', 'Facture enregistrée avec succès: ' . $this->generatedInvoiceLabel);
            $this->resetForm();

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
    }

    public function render()
    {
        return view('livewire.admin.invoices.generate-invoice', [
            'companies' => Company::notDeleted()->get(),
        ]);
    }
    protected function resetForm(): void
{
    $this->step = 1;
    $this->invoice_date = now()->toDateString();
    $this->product = '';
    $this->weight = null;
    $this->operation_code = null;
    $this->default_fob_amount = 0;
    $this->insurance_amount = 0;
    $this->freight_amount = 0;
    $this->cif_amount = 0;
    $this->payment_mode = 'provision';
    $this->currency_id = 1;
    $this->exchange_rate = 500;
    $this->items = [];
    $this->generatedInvoiceLabel = null;
    $this->previewInvoiceNumber = 'Numéro généré lors de l’enregistrement';
    $this->folder_id = null;
    $this->company_id = null;
    $this->selectedFolder = null;
    $this->clearValidation();
}

}
