<div class="w-full max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h2 class="text-2xl font-bold">🧾 Nouvelle Facture</h2>
    @if ($previewInvoiceNumber)
        <p class="text-sm text-gray-600">Code facture prévisionnel : <strong>{{ $previewInvoiceNumber }}</strong></p>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif
    {{-- Barre de progression --}}
    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300"
            style="width: {{ (100 / (count($categorySteps) + 1)) * $step }}%">
        </div>
    </div>

    {{-- Étape 1 – Informations générales --}}
    @if ($step === 1)
        <div class="space-y-6">

            {{-- Affichage des Informations du Dossier Sélectionné/Chargé --}}
            @if ($selectedFolder)
                <div class="p-4 my-2 bg-blue-50 border border-blue-300 text-blue-800 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Facturation pour le Dossier : <span
                            class="font-bold">{{ $selectedFolder->folder_number }}</span></h3>
                    <p><strong>Client :</strong>
                        {{ $selectedFolder->company?->name ?? ($selectedFolder->client ?? 'N/A') }}</p>
                    <p class="text-sm"><strong>Description du dossier :</strong>
                        {{ $selectedFolder->description ?? 'N/A' }}</p>

                    @if (method_exists($this, 'clearSelectedFolder'))
                        <button type="button" wire:click="clearSelectedFolder"
                            class="mt-3 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm transition duration-150 ease-in-out">
                            Annuler la liaison / Saisir manuellement
                        </button>
                    @endif
                </div>
            @elseif($folder_id && !$selectedFolder)
                <div class="p-4 my-2 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg shadow">
                    <p>Le dossier avec l'ID {{ $folder_id }} n'a pas pu être chargé pour la facturation. Vérifiez les
                        messages d'erreur ou saisissez manuellement.</p>
                </div>
            @endif
            {{-- Fin Affichage Informations Dossier --}}

            <div class="grid grid-cols-2 gap-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Société
                            (Client)</label>
                        <input type="text" value="{{ $selectedFolder?->company?->name }}"
                            class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:outline-none focus:ring-0 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            readonly>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Acronyme</label>
                        <input type="text" value="{{ $selectedFolder?->company?->acronym }}"
                            class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:outline-none focus:ring-0 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            readonly>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Date de
                        Facture</label>
                    <input type="date" wire:model.live="invoice_date"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('invoice_date')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Produit</label>
                    <input type="text" wire:model="product"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('product')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Poids (kg)</label>
                    <input type="number" step="0.01" wire:model.live="weight"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('weight')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Code
                        Opération</label>
                    <input type="text" wire:model="operation_code"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('operation_code')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">FOB ($)</label>
                    <input type="number" step="0.01" wire:model="default_fob_amount"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('default_fob_amount')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Assurance
                        ($)</label>
                    <input type="number" step="0.01" wire:model="insurance_amount"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('insurance_amount')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Fret ($)</label>
                    <input type="number" step="0.01" wire:model="freight_amount"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('freight_amount')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">CIF ($)</label>
                    <input type="number" step="0.01" wire:model.live="cif_amount"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('cif_amount')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Devise
                        principale</label>
                    <select wire:model="currency_id"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <option value="">-- Select --</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                        @endforeach
                    </select>
                    @error('currency_id')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Taux de
                        change</label>
                    <input type="text" wire:model="exchange_rate"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    @error('exchange_rate')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Mode de
                        paiement</label>
                    <select wire:model="payment_mode"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <option value="">-- Select --</option>
                        <option value="provision">Provision</option>
                        <option value="comptant">Comptant</option>
                    </select>
                    @error('payment_mode')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button wire:click="nextStep" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Étape suivante →
                </button>
            </div>
        </div>
    @endif

    {{-- Étapes dynamiques par catégorie --}}
    @foreach ($categorySteps as $index => $category)
        @if ($step === $index + 2)
            <div class="space-y-6">
                <h3 class="text-lg font-semibold mb-4">
                    {{ strtoupper($category === 'import_tax' ? '🧾 Taxes d\'import' : ($category === 'agency_fee' ? '🏢 Frais agence' : '🔧 Autres frais')) }}
                </h3>

                @foreach ($items as $i => $item)
                    @if ($item['category'] === $category)
                        <div class="grid grid-cols-7 gap-4 items-end mb-3">
                            @if ($category === 'import_tax')
                                <div class="space-y-1 col-span-1">
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Taxe</label>
                                    <select wire:model="items.{{ $i }}.tax_id"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                        <option value="">-- Select --</option>
                                        @foreach ($taxes as $t)
                                            <option value="{{ $t->id }}">{{ $t->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('items.' . $i . '.tax_id')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @elseif ($category === 'agency_fee')
                                <div class="space-y-1 col-span-1">
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Frais
                                        agence</label>
                                    <select wire:model="items.{{ $i }}.agency_fee_id"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                        <option value="">-- Select --</option>
                                        @foreach ($agencyFees as $f)
                                            <option value="{{ $f->id }}">{{ $f->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('items.' . $i . '.agency_fee_id')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @elseif ($category === 'extra_fee')
                                <div class="space-y-1 col-span-1">
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Frais
                                        divers</label>
                                    <select wire:model="items.{{ $i }}.extra_fee_id"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                        <option value="">-- Select --</option>
                                        @foreach ($extraFees as $e)
                                            <option value="{{ $e->id }}">{{ $e->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('items.' . $i . '.extra_fee_id')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="space-y-1 col-span-1">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Devise</label>
                                <select wire:model.live="items.{{ $i }}.currency_id"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                    <option value="">-- Select --</option>
                                    @foreach ($currencies as $c)
                                        <option value="{{ $c->id }}">{{ $c->code }}</option>
                                    @endforeach
                                </select>
                                @error('items.' . $i . '.currency_id')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1 col-span-1">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Quantité</label>
                                <input type="number" step="1"
                                    wire:model.live="items.{{ $i }}.quantity"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('items.' . $i . '.quantity')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-1 col-span-1">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Montant
                                    (devise locale)</label>
                                <input type="number" step="0.01"
                                    wire:model.live="items.{{ $i }}.amount_local"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('items.' . $i . '.amount_local')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-1 col-span-1">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Montant
                                    USD</label>
                                <input type="number" step="0.01"
                                    wire:model.live="items.{{ $i }}.amount_usd" disabled
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>

                            <div class="space-y-1 col-span-1">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Montant
                                    CDF</label>
                                <input type="number" step="0.01"
                                    wire:model.live="items.{{ $i }}.amount_cdf" disabled
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>

                            <button wire:click.prevent="removeItem({{ $i }})"
                                class="text-red-600 text-sm">❌</button>
                        </div>
                    @endif
                @endforeach

                <button wire:click.prevent="addItem('{{ $category }}')"
                    class="text-sm text-blue-600 hover:underline">
                    ➕ Ajouter une ligne à
                    {{ $category === 'import_tax' ? 'Taxes' : ($category === 'agency_fee' ? 'Frais agence' : 'Frais divers') }}
                </button>

                <div class="pt-6 flex justify-between">
                    <button wire:click="previousStep"
                        class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        ← Retour
                    </button>
                    @if ($step < count($categorySteps) + 1)
                        <button wire:click="nextStep"
                            class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700">
                            Étape suivante →
                        </button>
                    @else
                        <button wire:click="save"
                            class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700">
                            💾 Enregistrer la facture
                        </button>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
