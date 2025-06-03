<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\AgencyFee;
use App\Models\Company;
use App\Models\Currency;
use App\Models\ExtraFee;
use App\Models\Invoice;
use App\Models\Tax;
use App\Models\Folder; // Ajout du modèle Folder
use Illuminate\Support\Carbon;
use Livewire\Component;

class GenerateInvoice extends Component
{
    public $step = 1;

    // Propriétés pour la sélection de dossier
    public $folder_id = null; // Sera rempli par Livewire depuis la query string si présent
    public ?Folder $selectedFolder = null;

    // public string $searchTermFolder = ''; // Supprimé
    // public array $searchableFolders = []; // Supprimé

    public $company_id;
    public $invoice_date;
    public $product = 'SOUFFRE';
    public $weight = '9000';
    public $operation_code = 'MBDKCCGL';

    public $fob_amount = 0;
    public $insurance_amount = 0;
    public $freight_amount = 0;
    public $cif_amount = 0;

    public $payment_mode = 'provision';
    public $currency_id = 1;
    public $exchange_rate = 1.0;

    public $items = [];

    public $taxes = [], $agencyFees = [], $extraFees = [], $currencies = [];

    public array $categorySteps = [];

    public function mount($folder_id = null) // Livewire injectera la valeur de la query string ici
    {
        // Initialisation des données de base du formulaire
        $this->invoice_date = now()->toDateString();
        $this->taxes = Tax::all();
        $this->agencyFees = AgencyFee::all();
        $this->extraFees = ExtraFee::all();
        $this->currencies = Currency::all();
        $this->initCategorySteps();
        // $this->addItem(); // L'ajout initial d'item sera géré après le pré-remplissage du dossier

        $this->folder_id = $folder_id; // Assigner le folder_id reçu
        $this->selectedFolder = null; // S'assurer que selectedFolder est null initialement

        if (!is_null($this->folder_id)) {
            $folder = Folder::with('company', 'invoice')->find($this->folder_id);

            if (!$folder) {
                session()->flash('error', 'Dossier non trouvé.');
                $this->folder_id = null; // Réinitialiser si non trouvé
            } elseif ($folder->invoice()->exists()) { // Vérifier si le dossier a déjà une facture liée
                session()->flash('error', "Le dossier N° {$folder->folder_number} est déjà facturé (Facture N° {$folder->invoice->invoice_number}). Impossible de créer une nouvelle facture pour ce dossier.");
                $this->folder_id = null; // Réinitialiser pour éviter la liaison
            } else {
                // Dossier valide et non facturé, on peut pré-remplir
                $this->selectedFolder = $folder;
                $this->company_id = $folder->company_id;
                $this->fob_amount = $folder->fob_amount ?? 0;
                $this->insurance_amount = $folder->insurance_amount ?? 0;
                $this->cif_amount = $folder->cif_amount ?? 0;
                $this->weight = $folder->weight;
                $this->product = $folder->description ?? ('Prestation selon dossier ' . $folder->folder_number);

                $calculated_freight = ($this->cif_amount ?? 0) - ($this->fob_amount ?? 0) - ($this->insurance_amount ?? 0);
                $this->freight_amount = $folder->freight_amount ?? ($calculated_freight > 0 ? $calculated_freight : 0);

                // Réinitialiser et pré-remplir les items
                $this->items = [];
                $this->addItem('import_tax'); // Ajoute un item de base
                if (count($this->items) > 0 && $this->items[0] !== null) {
                    $this->items[0]['label'] = $this->product;
                    $this->items[0]['amount_local'] = $this->fob_amount;
                    $usdCurrency = Currency::where('code', 'USD')->first();
                    if ($usdCurrency) {
                        $this->items[0]['currency_id'] = $usdCurrency->id;
                    }
                    $this->updatedItems($this->items[0]['amount_local'], "0.amount_local");
                }
            }
        }

        // Si aucun dossier n'est sélectionné ou valide, initialiser un item vide par défaut
        if (is_null($this->selectedFolder)) {
            $this->items = []; // S'assurer que les items sont vides si aucun dossier
            $this->addItem();
        }

        // Appelé pour s'assurer que les propriétés liées au dossier sont nulles si folder_id est null
        // Ou pour initialiser $searchTermFolder et $searchableFolders si on les gardait.
        // $this->resetFolderSelection(); // Pas nécessaire ici car $selectedFolder est déjà géré.
    }

    protected function resetFolderSelection(): void
    {
        $this->folder_id = null;
        $this->selectedFolder = null;
    }

    public function initCategorySteps(): void
    {
        $this->categorySteps = ['import_tax', 'agency_fee', 'extra_fee'];
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
                $rate = $selectedCurrency->exchange_rate ?: 1;
                $item['exchange_rate'] = $rate;
                if (strtoupper($selectedCurrency->code) === 'USD') {
                    $item['amount_usd'] = $localAmount;
                    $item['amount_cdf'] = round($localAmount * $rate, 2);
                } elseif (strtoupper($selectedCurrency->code) === 'CDF') {
                    $item['amount_usd'] = round($localAmount / $rate, 2);
                    $item['amount_cdf'] = $localAmount;
                } else {
                    $item['amount_usd'] = round($localAmount / $rate, 2);
                    $item['amount_cdf'] = round($localAmount, 2); // fallback
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
            'currency_id' => $this->currency_id ?? 1,
            'exchange_rate' => 1.0,
            'amount_local' => $this->fob_amount,
            'amount_usd' => 0,
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
        $this->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'invoice_date' => 'required|date',
            'product' => 'required|string|max:255',
            'weight' => 'nullable|numeric',
            'operation_code' => 'nullable|string|max:255',
            'fob_amount' => 'required|numeric|min:0',
            'insurance_amount' => 'nullable|numeric|min:0',
            'freight_amount' => 'nullable|numeric|min:0',
            'cif_amount' => 'nullable|numeric|min:0',
            'payment_mode' => 'required|string',
            'currency_id' => 'required|integer|exists:currencies,id', // Devise principale de la facture
            'exchange_rate' => 'required|numeric|min:0', // Taux de la devise principale (ex: USD vers CDF)

            'items' => 'present|array|min:1', // Doit avoir au moins un item
            'items.*.label' => 'required_if:items.*.category,extra_fee|string|max:255',
            'items.*.amount_local' => 'required|numeric|min:0',
            'items.*.currency_id' => 'required|integer|exists:currencies,id', // Devise de l'item
            'items.*.tax_id' => 'nullable|integer|exists:taxes,id',
            'items.*.agency_fee_id' => 'nullable|integer|exists:agency_fees,id',
            'items.*.extra_fee_id' => 'nullable|integer|exists:extra_fees,id',

            // Validation pour folder_id
            // unique:invoices,folder_id,NULL,id,deleted_at,NULL -> Un dossier ne peut avoir qu'une facture (non soft-deleted)
            // Si folder_id peut être null (facture non liée à un dossier), utiliser 'nullable'
            'folder_id' => ['nullable', 'integer', 'exists:folders,id', \Illuminate\Validation\Rule::unique('invoices', 'folder_id')->whereNull('deleted_at')->ignore($this->invoice_id ?? null)],
        ]);

        // Prépare et valide les labels des items
        foreach ($this->items as $index => &$itemRef) { // Utiliser une référence différente
            if (empty($itemRef['currency_id'])) {
                $this->addError("items.{$index}.currency_id", "La devise pour l'item est requise.");
                return; // Arrête la sauvegarde si une devise d'item est manquante
            }

            if (empty($itemRef['label'])) { // Utilise le label entré par l'utilisateur pour extra_fee si dispo
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
                         // Le label pour extra_fee est validé comme 'required_if'
                         // donc il devrait être présent. Sinon, fallback.
                        $itemRef['label'] = $itemRef['label'] ?: 'Frais divers';
                        break;
                    default:
                        $itemRef['label'] = 'Item inconnu'; // Fallback général
                }
            }
        }
        unset($itemRef); // Important après la boucle par référence

        // Recalcul et conversion finale des montants des items
        $processedItems = [];
        $totalUsdFromItems = 0;

        foreach ($this->items as $itemArray) {
            $localAmount = (float)($itemArray['amount_local'] ?? 0);
            $itemCurrencyId = (int)($itemArray['currency_id'] ?? $this->currency_id);
            $itemCurrency = Currency::find($itemCurrencyId);

            $itemArray['currency_id'] = $itemCurrencyId; // Assurer que l'ID est bien dans l'array

            if ($itemCurrency) {
                $itemExchangeRate = $itemCurrency->exchange_rate ?: 1.0; // Taux de la devise de l'item vers la devise de référence (supposée USD)
                $itemArray['exchange_rate'] = $itemExchangeRate;

                if ($itemCurrency->code === 'USD') {
                    $itemArray['amount_usd'] = $localAmount;
                } elseif ($itemExchangeRate != 0) {
                    $itemArray['amount_usd'] = round($localAmount / $itemExchangeRate, 2);
                } else {
                    $itemArray['amount_usd'] = 0; // Taux de change nul, impossible de convertir
                }

                // Conversion de amount_usd en amount_cdf pour l'item
                $cdfCurrency = Currency::where('code', 'CDF')->first();
                // Utilise le taux de change principal de la facture (USD -> CDF) pour convertir l'amount_usd de l'item en CDF
                $usdToCdfRate = $this->exchange_rate; // Taux principal de la facture
                if ($cdfCurrency && $this->currency_id == $cdfCurrency->id) { // Si la devise principale est CDF
                    // Alors le taux principal est CDF vers USD. On a besoin de USD vers CDF.
                    // Ceci devient complexe. Simplifions: this->exchange_rate est TOUJOURS USD_TO_CDF_RATE
                    // Si la devise principale de la facture est USD, this->exchange_rate est le taux USD->CDF
                    // Si la devise principale est CDF, this->exchange_rate est aussi le taux USD->CDF (stocké pour référence)
                }
                 $itemArray['amount_cdf'] = round($itemArray['amount_usd'] * $usdToCdfRate, 2);

            } else { // Devise de l'item non trouvée
                $itemArray['amount_usd'] = 0;
                $itemArray['amount_cdf'] = 0;
                $itemArray['exchange_rate'] = 1.0;
            }
            $totalUsdFromItems += $itemArray['amount_usd'];
            $processedItems[] = $itemArray;
        }
        $this->items = $processedItems; // Mettre à jour les items avec les montants recalculés

        // Le total_usd de la facture est la somme des amount_usd des items
        $this->total_usd = $totalUsdFromItems;

        $invoiceData = [
            'invoice_number' => 'MDBKCCGL' . str_pad((Invoice::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT),
            'company_id' => $this->company_id,
            'invoice_date' => Carbon::parse($this->invoice_date),
            'product' => $this->product,
            'weight' => $this->weight,
            'operation_code' => $this->operation_code,
            'fob_amount' => $this->fob_amount,
            'insurance_amount' => $this->insurance_amount,
            'freight_amount' => $this->freight_amount,
            'cif_amount' => $this->cif_amount,
            'payment_mode' => $this->payment_mode,
            'currency_id' => $this->currency_id,       // Devise principale de la facture
            'exchange_rate' => $this->exchange_rate,   // Taux de change principal (USD vers CDF)
            'total_usd' => $this->total_usd,           // Total en USD, calculé à partir des items
            // 'converted_total' => $this->total_usd * $this->exchange_rate, // Si la facture doit avoir un total converti en CDF
            'folder_id' => $this->folder_id,
            'status' => 'pending', // Statut initial par défaut
        ];

        $invoice = Invoice::create($invoiceData);

        foreach ($this->items as $itemData) {
            $invoice->items()->create([
                'label' => $itemData['label'],
                'category' => $itemData['category'],
                'amount_usd' => $itemData['amount_usd'],
                'amount_cdf' => $itemData['amount_cdf'],
                'currency_id' => $itemData['currency_id'],
                'exchange_rate' => $itemData['exchange_rate'],
                'tax_id' => $itemData['tax_id'] ?? null,
                'agency_fee_id' => $itemData['agency_fee_id'] ?? null,
                'extra_fee_id' => $itemData['extra_fee_id'] ?? null,
            ]);
        }

        session()->flash('success', 'Facture enregistrée avec succès: ' . $invoice->invoice_number);
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $defaultValues = [
            'step' => 1,
            'invoice_date' => now()->toDateString(),
            'product' => 'SOUFFRE',
            'weight' => '9000',
            'operation_code' => 'MBDKCCGL',
            'payment_mode' => 'provision',
            'currency_id' => Currency::where('code', 'USD')->first()?->id ?? 1, // Default to USD
            // Taux de change principal (USD vers CDF). À ajuster si la devise de référence change.
            'exchange_rate' => Currency::where('code', 'CDF')->first()?->exchange_rate ?? $this->exchange_rate ?? 2800,
            'items' => [],
            'company_id' => null,
            'fob_amount' => 0,
            'insurance_amount' => 0,
            'freight_amount' => 0,
            'cif_amount' => 0,
            'total_usd' => 0, // Assurer la réinitialisation du total
        ];

        foreach ($defaultValues as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->resetFolderSelection();
        $this->addItem();
        $this->clearValidation();
    }

    public function render()
    {
        return view('livewire.admin.invoices.generate-invoice', [
            'companies' => Company::all(),
        ]);
    }

    // ======================================================================
    // Les méthodes liées à la recherche de dossier interne sont supprimées
    // updatedSearchTermFolder()
    // selectFolder() -> la logique de pré-remplissage sera dans mount() ou une méthode appelée par mount()
    // ======================================================================

    /**
     * Réinitialise la sélection du dossier et les champs de facture associés.
     * Appelé si l'utilisateur veut explicitement délier un dossier,
     * ou si le dossier passé en paramètre est invalide.
     */
    public function clearSelectedFolder(): void
    {
        $this->resetFolderSelection(); // Réinitialise folder_id et selectedFolder
        $this->resetInvoiceFieldsFromFolder(); // Réinitialise les champs de la facture
    }

    /**
     * Réinitialise les champs de la facture qui ont été pré-remplis à partir d'un dossier,
     * ou à leurs valeurs par défaut si aucun dossier n'était sélectionné.
     */
    protected function resetInvoiceFieldsFromFolder(): void
    {
        // Réinitialiser aux valeurs par défaut du composant
        $this->company_id = null; // Important de réinitialiser si le dossier le définissait
        $this->fob_amount = 0;
        $this->insurance_amount = 0;
        $this->cif_amount = 0;
        $this->weight = '9000';
        $this->product = 'SOUFFRE';
        $this->freight_amount = 0;

        $this->items = [];
        $this->addItem();
    }
}
