<div class="w-full max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg space-y-6">

    <!-- En-tête -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">🧾 Nouvelle Facture</h2>
            @if ($previewInvoiceNumber)
                <p class="text-sm text-gray-500 mt-1">Code facture prévisionnel : <span class="font-semibold text-gray-700">{{ $previewInvoiceNumber }}</span></p>
            @endif
        </div>
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow-sm">{{ session('success') }}</div>
        @endif
    </div>

    <!-- Barre de progression stylisée -->
    <div class="w-full pt-4">
        <div class="flex">
            @foreach ($stepLabels as $stepNumber => $stepLabel)
                <div class="w-1/{{ count($stepLabels) }} flex items-center">
                    <div class="flex-1">
                        <div class="w-full h-1 {{ $step >= $stepNumber ? 'bg-indigo-600' : 'bg-gray-300' }} rounded-l-full rounded-r-full"></div>
                    </div>
                    <div class="relative">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $step >= $stepNumber ? 'bg-indigo-600 text-white' : 'bg-gray-300 text-gray-600' }} transition-all duration-300">
                            {{ $stepNumber }}
                        </div>
                        <div class="absolute top-10 left-1/2 -translate-x-1/2 text-xs text-center w-24">{{ $stepLabel }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="pt-10">
        {{-- Étape 1 – Informations générales --}}
        @if ($step === 1)
            <div class="space-y-8">
                @if ($selectedFolder)
                    <div class="p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-800 rounded-r-lg">
                        <h3 class="text-lg font-semibold">Dossier : <span class="font-bold">{{ $selectedFolder->folder_number }}</span></h3>
                        <p><strong>Client :</strong> {{ $selectedFolder->company?->name ?? 'N/A' }}</p>
                        <p class="text-sm"><strong>Description :</strong> {{ $selectedFolder->description ?? 'N/A' }}</p>
                    </div>
                @endif

                <fieldset class="grid grid-cols-1 md:grid-cols-2 gap-6 border p-4 rounded-lg">
                    <legend class="text-lg font-semibold px-2">Client & Date</legend>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500">Société (Client)</label>
                        <p class="font-semibold text-gray-800">{{ $selectedFolder?->company?->name }}</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500">Acronyme</label>
                        <p class="font-semibold text-gray-800">{{ $selectedFolder?->company?->acronym }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label for="invoice_date" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Date de Facture</label>
                        <input type="date" id="invoice_date" wire:model.live="invoice_date" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('invoice_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </fieldset>

                <fieldset class="grid grid-cols-1 md:grid-cols-3 gap-6 border p-4 rounded-lg">
                    <legend class="text-lg font-semibold px-2">Détails de l'Opération</legend>
                    <div>
                        <label for="product" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Produit</label>
                        <input type="text" id="product" wire:model="product" placeholder="Ex : Cuivre" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('product') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Poids (kg)</label>
                        <input type="number" id="weight" step="0.01" wire:model.live="weight" placeholder="5000" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('weight') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="operation_code" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Code Opération</label>
                        <input type="text" id="operation_code" wire:model="operation_code" placeholder="OP-123" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('operation_code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </fieldset>

                <fieldset class="grid grid-cols-1 md:grid-cols-4 gap-6 border p-4 rounded-lg">
                    <legend class="text-lg font-semibold px-2">Montants</legend>
                    <div>
                        <label for="fob" class="block text-sm font-medium text-gray-700 dark:text-gray-400">FOB ($)</label>
                        <input type="number" id="fob" step="0.01" wire:model="default_fob_amount" placeholder="15000" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('default_fob_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="insurance" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Assurance ($)</label>
                        <input type="number" id="insurance" step="0.01" wire:model="insurance_amount" placeholder="500" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('insurance_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="freight" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Fret ($)</label>
                        <input type="number" id="freight" step="0.01" wire:model="freight_amount" placeholder="300" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('freight_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="cif" class="block text-sm font-medium text-gray-700 dark:text-gray-400">CIF ($)</label>
                        <input type="number" id="cif" step="0.01" wire:model.live="cif_amount" placeholder="15800" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('cif_amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </fieldset>

                <fieldset class="grid grid-cols-1 md:grid-cols-3 gap-6 border p-4 rounded-lg">
                    <legend class="text-lg font-semibold px-2">Conditions de Paiement</legend>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Devise principale</label>
                        <select id="currency" wire:model="currency_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                            @endforeach
                        </select>
                        @error('currency_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="exchange_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Taux de change</label>
                        <input type="text" id="exchange_rate" wire:model="exchange_rate" placeholder="2500" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        @error('exchange_rate') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="payment_mode" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Mode de paiement</label>
                        <select id="payment_mode" wire:model="payment_mode" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <option value="provision">Provision</option>
                            <option value="comptant">Comptant</option>
                        </select>
                        @error('payment_mode') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </fieldset>

                <div class="pt-4 flex justify-end">
                    <button wire:click="nextStep" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Étape suivante →
                    </button>
                </div>
            </div>
        @endif

        {{-- Étapes dynamiques par catégorie --}}
        @foreach ($categorySteps as $index => $category)
            @if ($step === $index + 2)
                <div class="space-y-6">
                    @foreach ($items as $i => $item)
                        @if ($item['category'] === $category)
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm border space-y-4 relative">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @if ($category === 'import_tax')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Taxe</label>
                                            <select wire:model="items.{{ $i }}.tax_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option value="">-- Choisir --</option>
                                                @foreach ($taxes as $t)
                                                    <option value="{{ $t->id }}">{{ $t->label }}</option>
                                                @endforeach
                                            </select>
                                            @error('items.' . $i . '.tax_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                        </div>
                                    @elseif ($category === 'agency_fee')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Frais agence</label>
                                            <select wire:model="items.{{ $i }}.agency_fee_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option value="">-- Choisir --</option>
                                                @foreach ($agencyFees as $f)
                                                    <option value="{{ $f->id }}">{{ $f->label }}</option>
                                                @endforeach
                                            </select>
                                            @error('items.' . $i . '.agency_fee_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                        </div>
                                    @elseif ($category === 'extra_fee')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Frais divers</label>
                                            <select wire:model="items.{{ $i }}.extra_fee_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option value="">-- Choisir --</option>
                                                @foreach ($extraFees as $e)
                                                    <option value="{{ $e->id }}">{{ $e->label }}</option>
                                                @endforeach
                                            </select>
                                            @error('items.' . $i . '.extra_fee_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                        </div>
                                    @endif
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Quantité</label>
                                        <input type="number" step="1" placeholder="1" wire:model.live="items.{{ $i }}.quantity" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        @error('items.' . $i . '.quantity') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Devise</label>
                                        <select wire:model.live="items.{{ $i }}.currency_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                            @foreach ($currencies as $c)
                                                <option value="{{ $c->id }}">{{ $c->code }}</option>
                                            @endforeach
                                        </select>
                                        @error('items.' . $i . '.currency_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Montant (devise locale)</label>
                                        <input type="number" step="0.01" placeholder="1000" wire:model.live="items.{{ $i }}.amount_local" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        @error('items.' . $i . '.amount_local') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="bg-gray-200 p-2 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500">Montant USD</label>
                                        <p class="font-semibold text-gray-800">{{ number_format($item['amount_usd'] ?? 0, 2) }} $</p>
                                    </div>
                                    <div class="bg-gray-200 p-2 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500">Montant CDF</label>
                                        <p class="font-semibold text-gray-800">{{ number_format($item['amount_cdf'] ?? 0, 2) }} F</p>
                                    </div>
                                </div>
                                <button wire:click.prevent="removeItem({{ $i }})" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        @endif
                    @endforeach

                    <button wire:click.prevent="addItem('{{ $category }}')" class="inline-flex items-center px-4 py-2 border border-dashed border-gray-400 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        ➕ Ajouter une ligne
                    </button>

                    <div class="pt-6 flex justify-between">
                        <button wire:click="previousStep" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            ← Retour
                        </button>
                        <button wire:click="nextStep" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Étape suivante →
                        </button>
                    </div>
                </div>
            @endif
        @endforeach

        @if ($step === $summaryStep)
            @php
                $totalUsd = collect($items)->sum('amount_usd');
                $totalCdf = collect($items)->sum('amount_cdf');
            @endphp
            <div class="space-y-6">
                <div class="p-4 bg-gray-50 rounded-lg border">
                    <h3 class="text-xl font-semibold mb-4">Récapitulatif</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <p><strong>Client :</strong> {{ $selectedFolder?->company?->name }}</p>
                        <p><strong>Produit :</strong> {{ $product }}</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">USD</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">CDF</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['label'] ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($item['amount_usd'] ?? 0, 2, '.', ' ') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($item['amount_cdf'] ?? 0, 2, '.', ' ') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun item ajouté.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr class="font-semibold text-gray-800">
                                <td class="px-6 py-3 text-left text-sm">Total</td>
                                <td class="px-6 py-3 text-right text-sm">{{ number_format($totalUsd, 2, '.', ' ') }} $</td>
                                <td class="px-6 py-3 text-right text-sm">{{ number_format($totalCdf, 2, '.', ' ') }} F</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="pt-6 flex justify-between">
                    <button wire:click="previousStep" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        ← Retour
                    </button>
                    <button wire:click="save" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        💾 Enregistrer la facture
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
