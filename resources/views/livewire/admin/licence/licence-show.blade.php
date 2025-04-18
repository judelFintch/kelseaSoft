<div x-data="{ tab: 'details' }" class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-bold text-indigo-700 dark:text-indigo-400">📄 Licence : {{ $license->license_number }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">🧾 Type : {{ $license->license_type }} | 💱 Devise : {{ $license->currency }}</p>
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
            @php
                $tabs = [
                    ['key' => 'details', 'label' => '📋 Détails', 'color' => 'indigo'],
                    ['key' => 'capacites', 'label' => '📦 Capacités', 'color' => 'blue'],
                    ['key' => 'financier', 'label' => '💰 Financier', 'color' => 'green'],
                    ['key' => 'relations', 'label' => '🧾 Fournisseurs', 'color' => 'purple'],
                    ['key' => 'dates', 'label' => '📅 Dates', 'color' => 'yellow'],
                ];
            @endphp

            @foreach($tabs as $tabItem)
                <button @click="tab = '{{ $tabItem['key'] }}'"
                    :class="tab === '{{ $tabItem['key'] }}' ? 'border-b-2 border-{{ $tabItem['color'] }}-500 text-{{ $tabItem['color'] }}-600 dark:text-{{ $tabItem['color'] }}-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-{{ $tabItem['color'] }}-500'"
                    class="flex items-center gap-1 px-1 pb-3 transition">{{ $tabItem['label'] }}</button>
            @endforeach
        </nav>
    </div>

    <!-- PANELS -->
    <div class="mt-4 space-y-6">
        <!-- DÉTAILS -->
        <div x-show="tab === 'details'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $infos = [
                    ['label' => '📑 Catégorie', 'value' => $license->license_category, 'bg' => 'bg-indigo-50'],
                    ['label' => '⚖️ Régime douanier', 'value' => $license->customs_regime, 'bg' => 'bg-indigo-100'],
                    ['label' => '💳 Paiement', 'value' => $license->payment_mode, 'bg' => 'bg-green-50'],
                    ['label' => '👤 Bénéficiaire', 'value' => $license->payment_beneficiary, 'bg' => 'bg-yellow-50'],
                    ['label' => '🚚 Transport', 'value' => $license->transport_mode, 'bg' => 'bg-purple-50'],
                    ['label' => '🔎 Référence', 'value' => $license->transport_reference, 'bg' => 'bg-pink-50'],
                ];
            @endphp
            @foreach($infos as $item)
                <div class="{{ $item['bg'] }} p-4 rounded-lg shadow-sm border-l-4 border-current">
                    <p class="text-xs uppercase font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item['value'] ?? '—' }}</p>
                </div>
            @endforeach
        </div>

        <!-- CAPACITÉS -->
        <div x-show="tab === 'capacites'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $capacites = [
                    ['label' => '💸 FOB autorisé', 'value' => number_format($license->initial_fob_amount, 2) . ' ' . $license->currency, 'bg' => 'bg-blue-50'],
                    ['label' => '💰 FOB restant', 'value' => number_format($license->remaining_fob_amount, 2) . ' ' . $license->currency, 'bg' => 'bg-blue-100'],
                    ['label' => '⚖️ Poids total', 'value' => $license->initial_weight . ' kg', 'bg' => 'bg-cyan-50'],
                    ['label' => '📉 Poids restant', 'value' => $license->remaining_weight . ' kg', 'bg' => 'bg-cyan-100'],
                    ['label' => '📦 Qté totale', 'value' => $license->quantity_total, 'bg' => 'bg-sky-50'],
                    ['label' => '🧮 Qté restante', 'value' => $license->remaining_quantity, 'bg' => 'bg-sky-100'],
                    ['label' => '📁 Dossiers max', 'value' => $license->max_folders, 'bg' => 'bg-indigo-50'],
                    ['label' => '📂 Dossiers restants', 'value' => $license->remaining_folders, 'bg' => 'bg-indigo-100'],
                ];
            @endphp
            @foreach($capacites as $item)
                <div class="{{ $item['bg'] }} p-4 rounded-lg shadow-sm border-l-4 border-current">
                    <p class="text-xs uppercase font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- FINANCIER -->
        <div x-show="tab === 'financier'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $financier = [
                    ['label' => '🚛 Fret', 'value' => $license->freight_amount ?? '—', 'bg' => 'bg-green-50'],
                    ['label' => '🛡️ Assurance', 'value' => $license->insurance_amount ?? '—', 'bg' => 'bg-green-100'],
                    ['label' => '💼 Autres frais', 'value' => $license->other_fees ?? '—', 'bg' => 'bg-lime-50'],
                    ['label' => '📦 CIF', 'value' => $license->cif_amount ?? '—', 'bg' => 'bg-lime-100'],
                ];
            @endphp
            @foreach($financier as $item)
                <div class="{{ $item['bg'] }} p-4 rounded-lg shadow-sm border-l-4 border-current">
                    <p class="text-xs uppercase font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- RELATIONS -->
        <div x-show="tab === 'relations'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $relations = [
                    ['label' => '🏢 Fournisseur', 'value' => $license->supplier->name ?? '—', 'bg' => 'bg-purple-50'],
                    ['label' => '🏭 Entreprise', 'value' => $license->company->name ?? '—', 'bg' => 'bg-purple-100'],
                    ['label' => '🏛️ Douane', 'value' => $license->customsOffice->name ?? '—', 'bg' => 'bg-violet-50'],
                ];
            @endphp
            @foreach($relations as $item)
                <div class="{{ $item['bg'] }} p-4 rounded-lg shadow-sm border-l-4 border-current">
                    <p class="text-xs uppercase font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- DATES & NOTES -->
        <div x-show="tab === 'dates'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $dates = [
                    ['label' => '🧾 Facture', 'value' => optional($license->invoice_date)->format('d/m/Y'), 'bg' => 'bg-yellow-50'],
                    ['label' => '✅ Validation', 'value' => optional($license->validation_date)->format('d/m/Y'), 'bg' => 'bg-yellow-100'],
                    ['label' => '⏳ Expiration', 'value' => optional($license->expiry_date)->format('d/m/Y'), 'bg' => 'bg-orange-100'],
                ];
            @endphp
            @foreach($dates as $item)
                <div class="{{ $item['bg'] }} p-4 rounded-lg shadow-sm border-l-4 border-current">
                    <p class="text-xs uppercase font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item['value'] }}</p>
                </div>
            @endforeach

            <div class="sm:col-span-2 lg:col-span-3">
                <div class="bg-yellow-50 dark:bg-yellow-900/10 p-4 rounded-lg border-l-4 border-yellow-400">
                    <p class="text-xs uppercase text-yellow-800 dark:text-yellow-200 mb-1 font-semibold">📝 Notes</p>
                    <p class="text-sm text-gray-800 dark:text-gray-100">{{ $license->notes ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
