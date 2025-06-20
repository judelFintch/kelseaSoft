<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\GlobalInvoice;
use App\Models\GlobalInvoiceItem;
use Illuminate\Support\Facades\DB;

class EditGlobalInvoice extends Component
{
    public GlobalInvoice $globalInvoice;

    public array $items = [];

    public function mount(GlobalInvoice $globalInvoice): void
    {
        $this->globalInvoice = $globalInvoice;
        $this->items = $globalInvoice->globalInvoiceItems
            ->map(function (GlobalInvoiceItem $item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'category' => $item->category,
                ];
            })->toArray();
    }

    public function getTotalAmountProperty(): float
    {
        return collect($this->items)
            ->sum(fn($item) => $item['quantity'] * $item['unit_price']);
    }

    public function addItem(string $category = 'import_tax'): void
    {
        $this->items[] = [
            'id' => null,
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'category' => $category,
        ];
    }

    public function removeItem(int $index): void
    {
        $item = $this->items[$index];
        if (isset($item['id'])) {
            GlobalInvoiceItem::find($item['id'])?->delete();
        }
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->updateGlobalTotal();
    }

    public function updateGlobalTotal(): void
    {
        $this->globalInvoice->update([
            'total_amount' => $this->totalAmount,
        ]);
    }

    public function save(): void
    {
        DB::transaction(function () {
            foreach ($this->items as $item) {
                GlobalInvoiceItem::updateOrCreate(
                    ['id' => $item['id']],
                    [
                        'global_invoice_id' => $this->globalInvoice->id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['quantity'] * $item['unit_price'],
                        'category' => $item['category'],
                    ]
                );
            }

            $this->updateGlobalTotal();
        });

        session()->flash('success', 'Facture globale mise à jour.');
        return redirect()->route('admin.global-invoices.show', $this->globalInvoice->id);
    }

    public function render()
    {
        return view('livewire.admin.invoices.edit-global-invoice');
    }
}
