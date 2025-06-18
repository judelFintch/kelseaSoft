<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tax;
use App\Models\AgencyFee;
use App\Models\ExtraFee;

class AddInvoiceItems extends Component
{
    public Invoice $invoice;

    public array $taxItems = [];
    public array $agencyFeeItems = [];
    public array $extraFeeItems = [];

    public $taxes = [];
    public $agencyFees = [];
    public $extraFees = [];

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load('items');
        $this->taxes = Tax::orderBy('label')->get();
        $this->agencyFees = AgencyFee::orderBy('label')->get();
        $this->extraFees = ExtraFee::orderBy('label')->get();
    }

    public function addTaxItem(): void
    {
        $this->taxItems[] = ['tax_id' => null, 'amount_usd' => 0];
    }

    public function addAgencyFeeItem(): void
    {
        $this->agencyFeeItems[] = ['agency_fee_id' => null, 'amount_usd' => 0];
    }

    public function addExtraFeeItem(): void
    {
        $this->extraFeeItems[] = ['extra_fee_id' => null, 'amount_usd' => 0];
    }

    public function removeItem(string $group, int $index): void
    {
        if ($group === 'tax') {
            unset($this->taxItems[$index]);
            $this->taxItems = array_values($this->taxItems);
        } elseif ($group === 'agency') {
            unset($this->agencyFeeItems[$index]);
            $this->agencyFeeItems = array_values($this->agencyFeeItems);
        } elseif ($group === 'extra') {
            unset($this->extraFeeItems[$index]);
            $this->extraFeeItems = array_values($this->extraFeeItems);
        }
    }

    public function save(): void
    {
        $this->validate([
            'taxItems.*.tax_id' => 'required|exists:taxes,id',
            'taxItems.*.amount_usd' => 'required|numeric|min:0',
            'agencyFeeItems.*.agency_fee_id' => 'required|exists:agency_fees,id',
            'agencyFeeItems.*.amount_usd' => 'required|numeric|min:0',
            'extraFeeItems.*.extra_fee_id' => 'required|exists:extra_fees,id',
            'extraFeeItems.*.amount_usd' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            foreach ($this->taxItems as $item) {
                $label = Tax::find($item['tax_id'])?->label;
                $this->invoice->items()->create([
                    'label' => $label,
                    'category' => 'import_tax',
                    'amount_usd' => $item['amount_usd'],
                    'tax_id' => $item['tax_id'],
                ]);
            }

            foreach ($this->agencyFeeItems as $item) {
                $label = AgencyFee::find($item['agency_fee_id'])?->label;
                $this->invoice->items()->create([
                    'label' => $label,
                    'category' => 'agency_fee',
                    'amount_usd' => $item['amount_usd'],
                    'agency_fee_id' => $item['agency_fee_id'],
                ]);
            }

            foreach ($this->extraFeeItems as $item) {
                $label = ExtraFee::find($item['extra_fee_id'])?->label;
                $this->invoice->items()->create([
                    'label' => $label,
                    'category' => 'extra_fee',
                    'amount_usd' => $item['amount_usd'],
                    'extra_fee_id' => $item['extra_fee_id'],
                ]);
            }

            $this->invoice->total_usd = $this->invoice->items()->sum('amount_usd');
            $this->invoice->save();

            DB::commit();
            session()->flash('success', 'Éléments ajoutés à la facture.');
            redirect()->route('invoices.show', $this->invoice->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error while adding invoice items: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', "Une erreur est survenue lors de l'ajout des éléments.");
        }
    }

    public function render()
    {
        return view('livewire.admin.invoices.add-invoice-items');
    }
}
