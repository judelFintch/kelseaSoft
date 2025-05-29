<?php

declare(strict_types=1);

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

    public $company_id, $invoice_date, $product, $weight, $operation_code;
    public $fob_amount, $insurance_amount, $freight_amount, $cif_amount;
    public $payment_mode = 'provision';
    public $currency_id = 1;
    public $exchange_rate = 1.0;
    public $converted_total = 0;

    public $items = [];

    public $taxes = [], $agencyFees = [], $extraFees = [], $currencies = [], $companies = [];

    public function mount()
    {
        $this->invoice_date = now()->toDateString();
        $this->items = [];

        $this->taxes = Tax::all();
        $this->agencyFees = AgencyFee::all();
        $this->extraFees = ExtraFee::all();
        $this->currencies = Currency::all();
        $this->companies = Company::all();
    }

    public function goToStep($targetStep)
    {
        if ($targetStep === 2) {
            $this->validate([
                'company_id' => 'required|exists:companies,id',
                'invoice_date' => 'required|date',
                'operation_code' => 'required|string',
                'fob_amount' => 'required|numeric|min:0',
                'insurance_amount' => 'nullable|numeric|min:0',
                'freight_amount' => 'nullable|numeric|min:0',
                'cif_amount' => 'required|numeric|min:0',
                'currency_id' => 'required|exists:currencies,id',
                'exchange_rate' => 'required|numeric|min:0',
                'payment_mode' => 'required|in:provision,comptant',
            ]);
        }

        $this->step = $targetStep;
    }

    public function updated($property)
    {
        if (str_contains($property, 'tax_id')) $this->updateItemAmount($property, 'tax');
        if (str_contains($property, 'agency_fee_id')) $this->updateItemAmount($property, 'agency');
        if (str_contains($property, 'extra_fee_id')) $this->updateItemAmount($property, 'extra');
    }

    public function updateItemAmount($property, $type)
    {
        $index = explode('.', $property)[1] ?? null;
        if (!is_numeric($index)) return;

        $item =& $this->items[$index];
        if ($type === 'tax') $model = Tax::find($item['tax_id']);
        elseif ($type === 'agency') $model = AgencyFee::find($item['agency_fee_id']);
        elseif ($type === 'extra') $model = ExtraFee::find($item['extra_fee_id']);
        else $model = null;

        if ($model) {
            $item['label'] = $model->label ?? '';
            $item['amount_usd'] = $model->default_amount ?? 0;
            $item['currency_id'] = $model->currency_id ?? 1;
            $item['exchange_rate'] = $model->exchange_rate ?? 1.0;
            $item['converted_amount'] = $model->default_converted_amount ?? $model->default_amount;
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'label' => '',
            'category' => 'import_tax',
            'amount_usd' => 0,
            'currency_id' => 1,
            'exchange_rate' => 1.0,
            'converted_amount' => 0,
            'tax_id' => null,
            'agency_fee_id' => null,
            'extra_fee_id' => null
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $total = collect($this->items)->sum('amount_usd');
        $convertedTotal = collect($this->items)->sum('converted_amount');

        $invoice = Invoice::create([
            'invoice_number' => 'MDBKCCGL' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT),
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
            'converted_total' => $convertedTotal,
        ]);

        foreach ($this->items as $item) {
            $invoice->items()->create($item);
        }

        session()->flash('success', 'Facture créée avec succès.');
        return redirect()->route('invoices.index');
    }

    public function render()
    {
        return view('livewire.admin.invoices.generate-invoice');
    }
}
