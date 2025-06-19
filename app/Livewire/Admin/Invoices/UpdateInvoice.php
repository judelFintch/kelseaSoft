<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Tax;
use App\Models\AgencyFee;
use App\Models\ExtraFee;

class UpdateInvoice extends Component
{
    public Invoice $invoice;

    public $company_id, $invoice_date, $product, $weight, $operation_code;
    public $fob_amount, $insurance_amount, $freight_amount, $cif_amount, $payment_mode;

    public $items = [];

    public $taxes = [], $agencyFees = [], $extraFees = [];

    protected function rules()
    {
        return [
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
            'items' => 'present|array|min:1',
            'items.*.label' => 'nullable|string|max:255',
            'items.*.amount_usd' => 'required|numeric|min:0',
            'items.*.category' => 'required|in:import_tax,agency_fee,extra_fee',
            'items.*.tax_id' => 'nullable|integer|exists:taxes,id',
            'items.*.agency_fee_id' => 'nullable|integer|exists:agency_fees,id',
            'items.*.extra_fee_id' => 'nullable|integer|exists:extra_fees,id',
        ];
    }

    public function mount(Invoice $invoice)
    {
        if ($invoice->global_invoice_id) {
            session()->flash('error', "La facture {$invoice->invoice_number} est déjà incluse dans une facture globale. Impossible de la modifier.");
            redirect()->route('invoices.show', $invoice->id);
        }

        $this->invoice = $invoice;
        $this->company_id = $invoice->company_id;
        $this->invoice_date = $invoice->invoice_date->format('Y-m-d');
        $this->product = $invoice->product;
        $this->weight = $invoice->weight;
        $this->operation_code = $invoice->operation_code;
        $this->fob_amount = $invoice->fob_amount;
        $this->insurance_amount = $invoice->insurance_amount;
        $this->freight_amount = $invoice->freight_amount;
        $this->cif_amount = $invoice->cif_amount;
        $this->payment_mode = $invoice->payment_mode;

        $this->items = $invoice->items->map(function ($item) {
            return [
                'label' => $item->label,
                'category' => $item->category,
                'amount_usd' => $item->amount_usd,
                'tax_id' => $item->tax_id,
                'agency_fee_id' => $item->agency_fee_id,
                'extra_fee_id' => $item->extra_fee_id,
                'item_id' => $item->id
            ];
        })->toArray();

        $this->taxes = Tax::orderBy('label')->get();
        $this->agencyFees = AgencyFee::orderBy('label')->get();
        $this->extraFees = ExtraFee::orderBy('label')->get();
    }

    public function updated($property)
    {
        if (str_contains($property, 'tax_id')) {
            $this->updateAmountFromReference($property, 'tax');
            $index = explode('.', $property)[1] ?? null;
            if (is_numeric($index)) {
                $this->items[$index]['category'] = 'import_tax';
                $this->items[$index]['agency_fee_id'] = null;
                $this->items[$index]['extra_fee_id'] = null;
            }
        }

        if (str_contains($property, 'agency_fee_id')) {
            $this->updateAmountFromReference($property, 'agency');
            $index = explode('.', $property)[1] ?? null;
            if (is_numeric($index)) {
                $this->items[$index]['category'] = 'agency_fee';
                $this->items[$index]['tax_id'] = null;
                $this->items[$index]['extra_fee_id'] = null;
            }
        }

        if (str_contains($property, 'extra_fee_id')) {
            $this->updateAmountFromReference($property, 'extra');
            $index = explode('.', $property)[1] ?? null;
            if (is_numeric($index)) {
                $this->items[$index]['category'] = 'extra_fee';
                $this->items[$index]['tax_id'] = null;
                $this->items[$index]['agency_fee_id'] = null;
            }
        }
    }

    public function updateAmountFromReference($property, $type)
    {
        $parts = explode('.', $property);
        $index = $parts[1] ?? null;
        if (!is_numeric($index)) return;

        if ($type === 'tax' && $this->items[$index]['tax_id']) {
            $model = Tax::find($this->items[$index]['tax_id']);
        } elseif ($type === 'agency' && $this->items[$index]['agency_fee_id']) {
            $model = AgencyFee::find($this->items[$index]['agency_fee_id']);
        } elseif ($type === 'extra' && $this->items[$index]['extra_fee_id']) {
            $model = ExtraFee::find($this->items[$index]['extra_fee_id']);
        } else {
            return;
        }

        if ($model && isset($model->default_amount)) {
            $this->items[$index]['amount_usd'] = $model->default_amount;
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'label' => '',
            'category' => 'import_tax',
            'amount_usd' => 0,
            'tax_id' => null,
            'agency_fee_id' => null,
            'extra_fee_id' => null,
        ];
    }

    public function removeItem($index)
    {
        $item = $this->items[$index];
        if (isset($item['item_id'])) {
            InvoiceItem::find($item['item_id'])?->delete();
        }
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function getTotalUsdProperty()
    {
        return collect($this->items)->sum('amount_usd');
    }

    public function updateInvoice()
    {
        $validated = $this->validate();

        foreach ($validated['items'] as $index => $item) {
            if ($item['category'] === 'import_tax' && empty($item['tax_id'])) {
                $this->addError("items.{$index}.tax_id", 'Le champ Taxe est requis.');
            }
            if ($item['category'] === 'agency_fee' && empty($item['agency_fee_id'])) {
                $this->addError("items.{$index}.agency_fee_id", 'Le champ Frais agence est requis.');
            }
            if ($item['category'] === 'extra_fee' && empty($item['extra_fee_id'])) {
                $this->addError("items.{$index}.extra_fee_id", 'Le champ Frais divers est requis.');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        $totalUsd = collect($validated['items'])->sum('amount_usd');

        $this->invoice->update([
            'company_id' => $validated['company_id'],
            'invoice_date' => $validated['invoice_date'],
            'product' => $validated['product'],
            'weight' => $validated['weight'],
            'operation_code' => $validated['operation_code'],
            'fob_amount' => $validated['fob_amount'],
            'insurance_amount' => $validated['insurance_amount'],
            'freight_amount' => $validated['freight_amount'],
            'cif_amount' => $validated['cif_amount'],
            'payment_mode' => $validated['payment_mode'],
            'total_usd' => $totalUsd,
        ]);

        foreach ($validated['items'] as $item) {
            InvoiceItem::updateOrCreate(
                ['id' => $item['item_id'] ?? null],
                [
                    'invoice_id' => $this->invoice->id,
                    'label' => $item['label'],
                    'category' => $item['category'],
                    'amount_usd' => $item['amount_usd'],
                    'tax_id' => $item['tax_id'] ?? null,
                    'agency_fee_id' => $item['agency_fee_id'] ?? null,
                    'extra_fee_id' => $item['extra_fee_id'] ?? null,
                ]
            );
        }

        session()->flash('success', 'Facture mise à jour avec succès.');
        return redirect()->route('invoices.show', $this->invoice->id);
    }

    public function validateInvoice(): void
    {
        if ($this->invoice->status === 'approved') {
            session()->flash('success', 'Cette facture est déjà validée.');
            return;
        }

        if ($this->invoice->items()->count() === 0) {
            session()->flash('error', 'Impossible de valider une facture sans lignes.');
            return;
        }

        $this->invoice->update(['status' => 'approved']);
        session()->flash('success', 'Facture validée avec succès.');
        redirect()->route('invoices.show', $this->invoice->id);
    }
    public function render()
    {
        return view('livewire.admin.invoices.update-invoice');
    }
}
