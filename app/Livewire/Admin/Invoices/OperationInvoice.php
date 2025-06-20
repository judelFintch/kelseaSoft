<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Tax;

class OperationInvoice extends Component
{
    public string $invoiceNumber = '';
    public ?Invoice $invoice = null;
    public array $items = [];
    public array $taxes = [];

    public function loadInvoice(): void
    {
        $this->validate([
            'invoiceNumber' => 'required|string',
        ]);

        $this->invoice = Invoice::where('invoice_number', $this->invoiceNumber)
            ->with('items')
            ->first();

        $this->taxes = Tax::orderBy('label')->get();

        if (!$this->invoice) {
            $this->items = [];
            session()->flash('error', 'Facture introuvable.');
            return;
        }

        $this->items = $this->invoice->items->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->label,
                'amount_usd' => $item->amount_usd,
                'tax_id' => $item->tax_id,
            ];
        })->toArray();
    }

    public function updateItem(int $index): void
    {
        $this->validate([
            'items.' . $index . '.label' => 'required|string',
            'items.' . $index . '.amount_usd' => 'required|numeric',
            'items.' . $index . '.tax_id' => 'nullable|exists:taxes,id',
        ]);

        $data = $this->items[$index];
        $item = InvoiceItem::find($data['id']);
        if ($item) {
            $item->update([
                'label' => $data['label'],
                'amount_usd' => $data['amount_usd'],
                'tax_id' => $data['tax_id'] ?? null,
            ]);

            $this->invoice->total_usd = $this->invoice->items()->sum('amount_usd');
            $this->invoice->save();

            session()->flash('success', 'Ligne mise à jour.');
        }
    }

    public function validateInvoice(): void
    {
        if (!$this->invoice) {
            session()->flash('error', 'Aucune facture chargée.');
            return;
        }

        $this->invoice->total_usd = $this->invoice->items()->sum('amount_usd');
        $this->invoice->status = 'approved';
        $this->invoice->save();

        session()->flash('success', 'Opération validée et total mis à jour.');
        $this->loadInvoice();
    }

    public function render()
    {
        return view('livewire.admin.invoices.operation-invoice');
    }
}
