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
            ->map(fn($item) => [
                'id' => $item->id,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'category' => $item->category,
            ])
            ->toArray();
    }

    public function updateItem(int $index): void
    {
        $item = $this->items[$index];

        $existing = isset($item['id']) ? GlobalInvoiceItem::find($item['id']) : null;

        $oldQuantity = $existing?->quantity ?? 0;
        $unitPrice   = $item['unit_price'];
        $newQuantity = $item['quantity'];
        $diffQty     = $newQuantity - $oldQuantity;

        // Calcul de l'ajustement : différence * prix unitaire
        $adjustment = $diffQty * $unitPrice;

        // Mise à jour ou création de la ligne
        $updated = GlobalInvoiceItem::updateOrCreate(
            ['id' => $item['id']],
            [
                'description'       => $item['description'],
                'quantity'          => $newQuantity,
                'unit_price'        => $unitPrice,
                'category'          => $item['category'],
                'global_invoice_id' => $this->globalInvoice->id,
            ]
        );

        // Ajustement intelligent du total global
        $this->globalInvoice->increment('total_amount', $adjustment);

        session()->flash('success', "Ligne #{$updated->id} mise à jour. Ajustement : " . number_format($adjustment, 2) . " USD.");
    }

    public function removeItem(int $index): void
    {
        $item = $this->items[$index];

        if (isset($item['id'])) {
            $existing = GlobalInvoiceItem::find($item['id']);
            if ($existing) {
                $reduction = $existing->quantity * $existing->unit_price;
                $existing->delete();
                $this->globalInvoice->decrement('total_amount', $reduction);
            }
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
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

    public function save(): void
    {
        foreach ($this->items as $index => $item) {
            $this->updateItem($index);
        }

        session()->flash('success', 'Toutes les lignes ont été mises à jour avec ajustement du total.');
        redirect()->route('admin.global-invoices.show', $this->globalInvoice->id);
    }

    public function render()
    {
        return view('livewire.admin.invoices.edit-global-invoice');
    }
}
