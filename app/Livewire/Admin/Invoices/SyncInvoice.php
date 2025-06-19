<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;

class SyncInvoice extends Component
{
    public Invoice $invoice;
    public float $itemsTotal = 0;
    public float $difference = 0;

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice->load('items');
        $this->calculateTotals();
    }

    public function calculateTotals(): void
    {
        $this->itemsTotal = $this->invoice->items->sum('amount_usd');
        $this->difference = round($this->itemsTotal - $this->invoice->total_usd, 2);
    }

    public function synchronize(): void
    {
        $this->calculateTotals();
        $this->invoice->total_usd = $this->itemsTotal;
        $this->invoice->save();
        $this->difference = 0;
        session()->flash('success', 'Facture synchronisée avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.invoices.sync-invoice');
    }
}
