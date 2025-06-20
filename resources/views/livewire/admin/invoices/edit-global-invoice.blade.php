<div class="container mx-auto px-4 py-6">
    <x-ui.flash-message />
    <x-ui.error-message />

    <h1 class="text-2xl font-semibold mb-4">
        Éditer Facture Globale {{ $globalInvoice->global_invoice_number }}
    </h1>

    <div class="space-y-4">
        @foreach ($items as $index => $item)
            <div class="border p-4 rounded-lg shadow-sm">
                <div class="grid grid-cols-7 gap-2 items-center">
                    <div class="col-span-2">
                        <input type="text"
                               wire:model.defer="items.{{ $index }}.description"
                               placeholder="Description"
                               class="w-full border rounded p-1" />
                    </div>

                    <div>
                        <input type="number" step="0.01"
                               wire:model.defer="items.{{ $index }}.quantity"
                               class="w-full border rounded p-1" />
                    </div>

                    <div>
                        <input type="number" step="0.01"
                               wire:model.defer="items.{{ $index }}.unit_price"
                               class="w-full border rounded p-1" />
                    </div>

                    <div class="text-right font-medium">
                        {{ number_format($item['quantity'] * $item['unit_price'], 2) }}
                    </div>

                    <div>
                        <button wire:click="updateItem({{ $index }})"
                                class="text-green-600 hover:underline">Mettre à jour</button>
                    </div>

                    <div>
                        <button wire:click="removeItem({{ $index }})"
                                class="text-red-600 hover:underline">Supprimer</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <button wire:click="addItem('import_tax')"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Ajouter Taxe
        </button>
    </div>

    <div class="mt-6 text-right">
        <p class="font-semibold mb-2">
            Total: {{ number_format($globalInvoice->total_amount, 2) }} USD
        </p>
        <button wire:click="save"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Enregistrer tout
        </button>
    </div>
</div>
