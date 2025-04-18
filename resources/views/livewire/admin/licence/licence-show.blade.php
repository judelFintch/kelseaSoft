
<div x-data="{ tab: 'details' }" class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📄 Licence : {{ $license->license_number }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Type : {{ $license->license_type }} | Devise : {{ $license->currency }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('licence.edit', $license) }}"
               class="inline-flex items-center px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200">
                ✏️ Modifier
            </a>
            <button wire:click="printPdf"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 text-gray-800 rounded hover:bg-gray-200">
                🖨️ Imprimer
            </button>
        </div>
    </div>

    <!-- Onglets -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex flex-wrap gap-6 text-sm font-semibold">
            <button @click="tab = 'details'"
                :class="tab === 'details' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-indigo-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">📋 Détails</button>

            <button @click="tab = 'capacites'"
                :class="tab === 'capacites' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-blue-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">📦 Capacités</button>

            <button @click="tab = 'financier'"
                :class="tab === 'financier' ? 'border-b-2 border-green-500 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-green-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">💰 Financier</button>

            <button @click="tab = 'relations'"
                :class="tab === 'relations' ? 'border-b-2 border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-purple-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">🧾 Fournisseurs</button>

            <button @click="tab = 'dates'"
                :class="tab === 'dates' ? 'border-b-2 border-yellow-500 text-yellow-600 dark:text-yellow-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-yellow-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">📅 Dates</button>
        </nav>
    </div>

    <!-- PANELS -->
    <div class="mt-4 space-y-6">
        <!-- DÉTAILS -->
        <div x-show="tab === 'details'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $infos = [
                    ['label' => 'Catégorie', 'value' => $license->license_category],
                    ['label' => 'Régime douanier', 'value' => $license->customs_regime],
                    ['label' => 'Mode de paiement', 'value' => $license->payment_mode],
                    ['label' => 'Bénéficiaire', 'value' => $license->payment_beneficiary],
                    ['label' => 'Mode de transport', 'value' => $license->transport_mode],
                    ['label' => 'Référence transport', 'value' => $license->transport_reference],
                ];
            @endphp
            @foreach($infos as $item)
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg shadow-sm">
                    <p class="text-xs uppercase text-gray-500 dark:text-gray-400">{{ $item['label'] }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item['value'] ?? '—' }}</p>
                </div>
            @endforeach
        </div>

        <!-- CAPACITÉS -->
        <div x-show="tab === 'capacites'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-forms.show label="FOB autorisé">{{ number_format($license->initial_fob_amount, 2) }} {{ $license->currency }}</x-forms.show>
            <x-forms.show label="FOB restant">{{ number_format($license->remaining_fob_amount, 2) }} {{ $license->currency }}</x-forms.show>
            <x-forms.show label="Poids total">{{ $license->initial_weight }} kg</x-forms.show>
            <x-forms.show label="Poids restant">{{ $license->remaining_weight }} kg</x-forms.show>
            <x-forms.show label="Quantité totale">{{ $license->quantity_total }}</x-forms.show>
            <x-forms.show label="Quantité restante">{{ $license->remaining_quantity }}</x-forms.show>
            <x-forms.show label="Dossiers max">{{ $license->max_folders }}</x-forms.show>
            <x-forms.show label="Dossiers restants">{{ $license->remaining_folders }}</x-forms.show>
        </div>

        <!-- FINANCIER -->
        <div x-show="tab === 'financier'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-forms.show label="Fret">{{ $license->freight_amount ?? '—' }}</x-forms.show>
            <x-forms.show label="Assurance">{{ $license->insurance_amount ?? '—' }}</x-forms.show>
            <x-forms.show label="Autres frais">{{ $license->other_fees ?? '—' }}</x-forms.show>
            <x-forms.show label="CIF">{{ $license->cif_amount ?? '—' }}</x-forms.show>
        </div>

        <!-- RELATIONS -->
        <div x-show="tab === 'relations'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-forms.show label="Fournisseur">{{ $license->supplier->name ?? '—' }}</x-forms.show>
            <x-forms.show label="Entreprise">{{ $license->company->name ?? '—' }}</x-forms.show>
            <x-forms.show label="Bureau de douane">{{ $license->customsOffice->name ?? '—' }}</x-forms.show>
        </div>

        <!-- DATES -->
        <div x-show="tab === 'dates'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-forms.show label="Date de facture">{{ optional($license->invoice_date)->format('d/m/Y') }}</x-forms.show>
            <x-forms.show label="Date de validation">{{ optional($license->validation_date)->format('d/m/Y') }}</x-forms.show>
            <x-forms.show label="Date d’expiration">{{ optional($license->expiry_date)->format('d/m/Y') }}</x-forms.show>

            <div class="sm:col-span-2 lg:col-span-3">
                <div class="bg-yellow-50 dark:bg-yellow-900/10 p-4 rounded-lg border-l-4 border-yellow-400">
                    <p class="text-xs uppercase text-yellow-800 dark:text-yellow-200 mb-1 font-semibold">Notes</p>
                    <p class="text-sm text-gray-800 dark:text-gray-100">{{ $license->notes ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>