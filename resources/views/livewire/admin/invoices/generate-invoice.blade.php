<div class="w-full max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h2 class="text-2xl font-bold">🧾 Nouvelle Facture</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif

    {{-- ÉTAPE 1 --}}
    @if ($step === 1)
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <x-forms.select label="Société" model="company_id" :options="$companies" optionLabel="name" />
                <x-forms.input label="Date de Facture" model="invoice_date" type="date" />
            </div>

            <div class="grid grid-cols-3 gap-4">
                <x-forms.input label="Produit" model="product" />
                <x-forms.input label="Poids (kg)" model="weight" type="number" step="0.01" />
                <x-forms.input label="Code Opération" model="operation_code" />
            </div>

            <div class="grid grid-cols-4 gap-4">
                <x-forms.input label="FOB ($)" model="fob_amount" type="number" step="0.01" />
                <x-forms.input label="Assurance ($)" model="insurance_amount" type="number" step="0.01" />
                <x-forms.input label="Fret ($)" model="freight_amount" type="number" step="0.01" />
                <x-forms.input label="CIF ($)" model="cif_amount" type="number" step="0.01" />
            </div>

            <div class="grid grid-cols-3 gap-4">
                <x-forms.select label="Devise" model="currency_id" :options="$currencies" optionLabel="code" optionValue="id"
                    :placeholder="'-- sélectionner --'" />
                <x-forms.input label="Taux de change" model="exchange_rate" type="number" step="0.000001" />
                <x-forms.select label="Mode de paiement" model="payment_mode" :options="[
                    ['id' => 'provision', 'name' => 'Provision'],
                    ['id' => 'comptant', 'name' => 'Comptant'],
                ]" />
            </div>

            <div class="pt-4 flex justify-end">
                <button wire:click="goToStep(2)" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Étape suivante →
                </button>
            </div>
        </div>
    @endif

    {{-- ÉTAPE 2 --}}
    @if ($step === 2)
        <div>
            <h3 class="text-lg font-semibold mb-4">📋 Détails de la facture</h3>

            @foreach ($items as $index => $item)
                <div class="grid grid-cols-6 gap-4 items-end mb-3">
                    <x-forms.select label="Catégorie" model="items.{{ $index }}.category" :options="[
                        ['id' => 'import_tax', 'name' => 'Taxe d\'import'],
                        ['id' => 'agency_fee', 'name' => 'Frais d\'agence'],
                        ['id' => 'extra_fee', 'name' => 'Autres frais'],
                    ]" />

                    @if ($item['category'] === 'import_tax')
                        <x-forms.select label="Taxe" model="items.{{ $index }}.tax_id" :options="$taxes" optionLabel="label" />
                    @elseif ($item['category'] === 'agency_fee')
                        <x-forms.select label="Frais d'agence" model="items.{{ $index }}.agency_fee_id" :options="$agencyFees" optionLabel="label" />
                    @elseif ($item['category'] === 'extra_fee')
                        <x-forms.select label="Frais divers" model="items.{{ $index }}.extra_fee_id" :options="$extraFees" optionLabel="label" />
                    @endif

                    <x-forms.input label="Montant (USD)" model="items.{{ $index }}.amount_usd" type="number" step="0.01" />
                    <x-forms.input label="Montant converti" model="items.{{ $index }}.converted_amount" type="number" step="0.01" />
                    <button wire:click.prevent="removeItem({{ $index }})" class="text-red-600 text-sm">❌</button>
                </div>
            @endforeach

            <div class="flex justify-between mt-4">
                <button wire:click.prevent="addItem" class="text-sm text-blue-600 hover:underline">
                    ➕ Ajouter une ligne
                </button>
                <div class="text-right font-bold text-lg">
                    Total USD : {{ number_format(collect($items)->sum('amount_usd'), 2) }} <br>
                    Total Converti : {{ number_format(collect($items)->sum('converted_amount'), 2) }}
                </div>
            </div>

            <div class="pt-6 flex justify-between">
                <button wire:click="goToStep(1)" class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    ← Retour
                </button>
                <button wire:click="save" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700">
                    💾 Enregistrer la facture
                </button>
            </div>
        </div>
    @endif
</div>
