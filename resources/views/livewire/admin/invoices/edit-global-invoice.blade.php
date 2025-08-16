<div class="container mx-auto px-4 py-8">
    {{-- Messages --}}
    <x-ui.flash-message />
    <x-ui.error-message />

    {{-- En-tête --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Éditer Facture Globale : <span class="text-blue-600">{{ $globalInvoice->global_invoice_number }}</span>
        </h1>
        <button wire:click="save"
                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            💾 Enregistrer tout
        </button>
    </div>

    {{-- Champ Produit avec bouton --}}
    <div class="mb-8 max-w-xl flex items-end gap-4">
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700 mb-1">Produit</label>
            <input type="text" wire:model.defer="product"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
        </div>
        <button wire:click="updateProduct"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            🔄 Mettre à jour
        </button>
    </div>

    {{-- Liste des items --}}
    <div class="space-y-4">
        @foreach ($items as $index => $item)
            <div class="border rounded-lg shadow-sm p-4 bg-white">
                <div class="grid grid-cols-12 gap-3 items-center">
                    {{-- Description --}}
                    <div class="col-span-4">
                        <input type="text"
                               wire:model.defer="items.{{ $index }}.description"
                               placeholder="Description"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
                    </div>

                    {{-- Quantité --}}
                    <div class="col-span-2">
                        <input type="number" step="0.01"
                               wire:model.defer="items.{{ $index }}.quantity"
                               placeholder="Qté"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-right" />
                    </div>

                    {{-- Prix unitaire --}}
                    <div class="col-span-2">
                        <input type="number" step="0.01"
                               wire:model.defer="items.{{ $index }}.unit_price"
                               placeholder="Prix"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-right" />
                    </div>

                    {{-- Total ligne --}}
                    <div class="col-span-2 text-right font-semibold text-gray-700">
                        {{ number_format($item['quantity'] * $item['unit_price'], 2) }} USD
                    </div>

                    {{-- Actions --}}
                    <div class="col-span-1 text-center">
                        <button wire:click="updateItem({{ $index }})"
                                class="text-green-600 hover:text-green-800" title="Mettre à jour">
                            🔄
                        </button>
                    </div>
                    <div class="col-span-1 text-center">
                        <button wire:click="removeItem({{ $index }})"
                                class="text-red-600 hover:text-red-800" title="Supprimer">
                            ❌
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Ajouter un élément --}}
    <div class="mt-6">
        <button wire:click="addItem('import_tax')"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-200 transition">
            ➕ Ajouter une taxe
        </button>
    </div>

    {{-- Total général --}}
    <div class="mt-8 text-right">
        <p class="text-lg font-bold text-gray-900">
            Total général : {{ number_format($globalInvoice->total_amount, 2) }} USD
        </p>
    </div>
</div>
