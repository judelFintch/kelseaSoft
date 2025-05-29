<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Company;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Tax;
use App\Models\AgencyFee;
use App\Models\ExtraFee;

class GenerateInvoice extends Component
{

    public $company_id;
    public $invoice_date;
    public $product;
    public $weight;
    public $operation_code;
    public $fob_amount;
    public $insurance_amount;
    public $freight_amount;
    public $cif_amount;
    public $payment_mode = 'provision';
    public $taxes = [], $agencyFees = [], $extraFees = [];
    public $currency_id = 1;
    public $exchange_rate = 1.0;
    public $converted_total = 0;
    public $currencies = [];

    public $items = [
        ['label' => '', 'category' => 'import_tax', 'amount_usd' => 0],
    ];
    public function mount()
    {
        $this->invoice_date = now()->toDateString();
        $this->items = [
            ['label' => '', 'category' => 'import_tax', 'amount_usd' => 0, 'tax_id' => null, 'agency_fee_id' => null, 'extra_fee_id' => null],
        ];

        $this->taxes = Tax::orderBy('label')->get();
        $this->agencyFees = AgencyFee::orderBy('label')->get();
        $this->extraFees = ExtraFee::orderBy('label')->get();
    }

    public function getConvertedTotalProperty()
    {
        return $this->total_usd * $this->exchange_rate;
    }

    public function updated($property, $value)
    {
        if (str_contains($property, 'tax_id')) {
            $this->updateAmountFromReference($property, 'tax');
        }

        if (str_contains($property, 'agency_fee_id')) {
            $this->updateAmountFromReference($property, 'agency');
        }

        if (str_contains($property, 'extra_fee_id')) {
            $this->updateAmountFromReference($property, 'extra');
        }
    }

    public function updateAmountFromReference($property, $type)
    {
        $parts = explode('.', $property); // ex: items.0.tax_id
        $index = $parts[1] ?? null;

        if (!is_numeric($index)) return;

        if ($type === 'tax' && $this->items[$index]['tax_id']) {
            $model = \App\Models\Tax::find($this->items[$index]['tax_id']);
        } elseif ($type === 'agency' && $this->items[$index]['agency_fee_id']) {
            $model = \App\Models\AgencyFee::find($this->items[$index]['agency_fee_id']);
        } elseif ($type === 'extra' && $this->items[$index]['extra_fee_id']) {
            $model = \App\Models\ExtraFee::find($this->items[$index]['extra_fee_id']);
        } else {
            $model = null;
        }

        if ($model && isset($model->default_amount)) {
            $this->items[$index]['amount_usd'] = $model->default_amount;
            $this->dispatch('$refresh'); // rafraîchir le total
        }
    }



    public function downloadPdf($invoiceId): StreamedResponse
    {
        $invoice = \App\Models\Invoice::with('company', 'items')->findOrFail($invoiceId);

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'facture-' . $invoice->invoice_number . '.pdf'
        );
    }

    public function addItem()
    {
        $this->items[] = ['label' => '', 'category' => 'import_tax', 'amount_usd' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Réindexation
    }

    public function generateInvoiceNumber(): string
    {
        $lastId = Invoice::max('id') + 1;
        return 'MDBKCCGL' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate([
            'company_id' => 'required|exists:companies,id',
            'invoice_date' => 'required|date',
            'items.*.label' => 'required|string|max:255',
            'items.*.category' => 'required|in:import_tax,agency_fee,extra_fee',
            'items.*.amount_usd' => 'required|numeric|min:0',
        ]);

        $total = collect($this->items)->sum('amount_usd');

        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
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
            'total_usd' => $total,
            'currency_id' => $this->currency_id,
            'exchange_rate' => $this->exchange_rate,
            'converted_total' => $this->converted_total,
        ]);

        foreach ($this->items as $item) {
            $invoice->items()->create($item);
        }

        $this->dispatch('notify', message: 'Facture générée avec succès.');
        return redirect()->route('invoices.index');
    }

    public function render()
    {
        return view('livewire.admin.invoices.generate-invoice', [
            'companies' => Company::all(),
        ]);
    }
}
