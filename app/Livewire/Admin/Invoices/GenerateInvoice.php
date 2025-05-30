<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\AgencyFee;
use App\Models\Company;
use App\Models\Currency;
use App\Models\ExtraFee;
use App\Models\Invoice;
use App\Models\Tax;
use Illuminate\Support\Carbon;
use Livewire\Component;

class GenerateInvoice extends Component
{
    public $step = 1;

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

    public function mount()
    {
        $this->invoice_date = now()->toDateString();
        $this->taxes = Tax::all();
        $this->agencyFees = AgencyFee::all();
        $this->extraFees = ExtraFee::all();
        $this->currencies = Currency::all();
        $this->initCategorySteps();
        $this->addItem();
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
        foreach ($this->items as $index => &$item) {
            if (empty($item['currency_id'])) {
                $this->addError("items.{$index}.currency_id", "La devise est requise.");
                return;
            }

            switch ($item['category']) {
                case 'import_tax':
                    $tax = Tax::find($item['tax_id']);
                    $item['label'] = $tax?->label ?? 'Taxe inconnue';
                    break;
                case 'agency_fee':
                    $agency = AgencyFee::find($item['agency_fee_id']);
                    $item['label'] = $agency?->label ?? 'Frais agence inconnu';
                    break;
                case 'extra_fee':
                    $extra = ExtraFee::find($item['extra_fee_id']);
                    $item['label'] = $extra?->label ?? 'Frais divers inconnu';
                    break;
                default:
                    $item['label'] = 'Inconnu';
            }
        }

        $total = collect($this->items)->sum('amount_usd');
        $totalCdf = collect($this->items)->sum('amount_cdf');

        $invoice = Invoice::create([
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
            'currency_id' => $this->currency_id,
            'exchange_rate' => $this->exchange_rate,
            'total_usd' => $total,
            'converted_total' => $totalCdf,
        ]);

        foreach ($this->items as $item) {
            $invoice->items()->create([
                'label' => $item['label'],
                'category' => $item['category'],
                'amount_usd' => $item['amount_usd'],
                'amount_cdf' => $item['amount_cdf'],
                'currency_id' => $item['currency_id'],
                'exchange_rate' => $item['exchange_rate'],
                'tax_id' => $item['tax_id'],
                'agency_fee_id' => $item['agency_fee_id'],
                'extra_fee_id' => $item['extra_fee_id'],
            ]);
        }

        session()->flash('success', 'Facture enregistrée avec succès.');
        $this->resetExcept(['step']);
        $this->step = 1;
    }

    public function render()
    {
        return view('livewire.admin.invoices.generate-invoice', [
            'companies' => Company::all(),
        ]);
    }
}
