<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class OperationInvoice extends Component
{
    public string $invoiceNumber = '';
    public ?Invoice $invoice = null;
    public array $items = [];

    public function loadInvoice(): void
    {
        $this->validate([
            'invoiceNumber' => 'required|string',
        ]);

        $this->invoice = Invoice::where('invoice_number', $this->invoiceNumber)
            ->with('items')
            ->first();

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
            ];
        })->toArray();
    }

    public function updateItem(int $index): void
    {
        $this->validate([
            'items.' . $index . '.label' => 'required|string',
            'items.' . $index . '.amount_usd' => 'required|numeric',
        ]);

        $data = $this->items[$index];
        $item = InvoiceItem::find($data['id']);
        if ($item) {
            $item->update([
                'label' => $data['label'],
                'amount_usd' => $data['amount_usd'],
            ]);

            $this->invoice->total_usd = $this->invoice->items()->sum('amount_usd');
            $this->invoice->save();

            session()->flash('success', 'Ligne mise à jour.');
        }
    }

    public function render()
    {
        return view('livewire.admin.invoices.operation-invoice');
    }
}
