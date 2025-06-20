<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Éditer Facture Globale {{ $globalInvoice->global_invoice_number }}</h1>

    <div class="space-y-4">
        @foreach ($items as $index => $item)
            <div class="border p-4 rounded-lg shadow-sm">
                <div class="grid grid-cols-6 gap-2 items-center">
                    <div class="col-span-2">
                        <input type="text" class="w-full border rounded p-1" wire:model.defer="items.{{ $index }}.description" placeholder="Description" />
                    </div>
                    <div>
                        <input type="number" step="0.01" class="w-full border rounded p-1" wire:model.defer="items.{{ $index }}.quantity" />
                    </div>
                    <div>
                        <input type="number" step="0.01" class="w-full border rounded p-1" wire:model.defer="items.{{ $index }}.unit_price" />
                    </div>
                    <div class="text-right">
                        {{ number_format($item['quantity'] * $item['unit_price'], 2) }}
                    </div>
                    <div class="text-right">
                        <button type="button" wire:click="removeItem({{ $index }})" class="text-red-600">Supprimer</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <button type="button" wire:click="addItem('import_tax')" class="px-4 py-2 bg-gray-200 rounded">Ajouter Taxe</button>
    </div>

    <div class="mt-6 text-right">
        <p class="font-semibold mb-2">Total: {{ number_format($this->totalAmount, 2) }} USD</p>
        <button wire:click="save" class="px-6 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
    </div>
</div>
