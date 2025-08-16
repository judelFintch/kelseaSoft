<div x-data="{ tab: 'details' }" class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
    <!-- Header + Actions -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📁 Dossier : {{ $folder->folder_number }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">📅 Arrivée : {{ optional($folder->arrival_border_date)->format('d/m/Y') ?? '—' }}</p>
        </div>
        <div class="flex gap-3">
            {{-- Conditional Invoicing Button --}}
            @if ($folder->invoice)
                <a href="{{ route('invoices.show', $folder->invoice->id) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-sky-100 text-sky-700 rounded hover:bg-sky-200 dark:bg-sky-700 dark:text-sky-100 dark:hover:bg-sky-600">
                    📄 Voir la facture
                </a>
            @else
                <a href="{{ route('invoices.generate', ['folder' => $folder]) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200 dark:bg-green-700 dark:text-green-100 dark:hover:bg-green-600">
                    ➕ Facturer
                </a>
            @endif

            <a href="{{ route('folder.edit', $folder) }}"
                class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-brand-500 rounded hover:bg-brand-600">✏️
                Modifier</a>
            <button wire:click="confirmDelete"
                class="inline-flex items-center px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 dark:bg-red-700 dark:text-red-100 dark:hover:bg-red-600">🗑
                Supprimer</button>
            <button wire:click="printPdf"
                class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 text-gray-800 rounded hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">🖨️
                Imprimer</button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex flex-wrap gap-6 text-sm font-semibold">
            <button @click="tab = 'details'"
                :class="tab === 'details' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                    'border-transparent text-gray-500 dark:text-gray-400 hover:text-indigo-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">📄 Détails</button>
            <button @click="tab = 'files'"
                :class="tab === 'files' ? 'border-b-2 border-green-500 text-green-600 dark:text-green-400' :
                    'border-transparent text-gray-500 dark:text-gray-400 hover:text-green-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">📁 Fichiers</button>
            <button @click="tab = 'progress'"
                :class="tab === 'progress' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' :
                    'border-transparent text-gray-500 dark:text-gray-400 hover:text-blue-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">⏳ Progression</button>
        </nav>
    </div>

    <!-- Panels -->
    <div class="mt-4 space-y-6">
        <!-- Details -->
        <div x-show="tab === 'details'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $fields = [
                    ['label' => 'Numéro Camion', 'value' => $folder->truck_number ?? '—'],
                    ['label' => 'Numéro Remorque', 'value' => $folder->trailer_number ?? '—'],
                    ['label' => 'Numéro Facture', 'value' => $folder->invoice_number ?? '—'],
                    ['label' => 'Type de Marchandise', 'value' => $folder->goods_type ?? '—'],
                    ['label' => 'Agence', 'value' => $folder->agency ?? '—'],
                    ['label' => 'Lieu Pré Alerte', 'value' => $folder->pre_alert_place ?? '—'],
                    ['label' => 'Mode de Transport', 'value' => $folder->transport_mode ?? '—'],
                    ['label' => 'Référence Interne', 'value' => $folder->internal_reference ?? '—'],
                    ['label' => 'Numéro Commande', 'value' => $folder->order_number ?? '—'],
                    ['label' => 'Date Dossier', 'value' => optional($folder->folder_date)->format('d/m/Y') ?? '—'],
                    ['label' => 'Transporteur', 'value' => optional($folder->transporter)->name ?? '—'],
                    ['label' => 'Téléphone Transporteur', 'value' => optional($folder->transporter)->phone ?? '—'],
                    ['label' => 'Email Transporteur', 'value' => optional($folder->transporter)->email ?? '—'],
                    ['label' => 'Nom du Chauffeur', 'value' => $folder->driver_name ?? '—'],
                    ['label' => 'Téléphone Chauffeur', 'value' => $folder->driver_phone ?? '—'],
                    ['label' => 'Nationalité Chauffeur', 'value' => $folder->driver_nationality ?? '—'],
                    ['label' => 'Origine', 'value' => optional($folder->origin)->name ?? '—'],
                    ['label' => 'Destination', 'value' => optional($folder->destination)->name ?? '—'],
                    ['label' => 'Client', 'value' => $folder->client ?? '—'],
                    ['label' => 'Entreprise', 'value' => optional($folder->company)->name ?? '—'],
                    ['label' => 'Téléphone Entreprise', 'value' => optional($folder->company)->phone_number ?? '—'],
                    ['label' => 'Email Entreprise', 'value' => optional($folder->company)->email ?? '—'],
                    ['label' => 'Fournisseur', 'value' => optional($folder->supplier)->name ?? '—'],
                    ['label' => 'Téléphone Fournisseur', 'value' => optional($folder->supplier)->phone ?? '—'],
                    ['label' => 'Email Fournisseur', 'value' => optional($folder->supplier)->email ?? '—'],
                    ['label' => 'Bureau de Douane', 'value' => optional($folder->customsOffice)->name ?? '—'],
                    ['label' => 'Numéro Déclaration', 'value' => $folder->declaration_number ?? '—'],
                    ['label' => 'Type de Déclaration', 'value' => optional($folder->declarationType)->name ?? '—'],
                    ['label' => 'Déclarant', 'value' => $folder->declarant ?? '—'],
                    ['label' => 'Agent Douane', 'value' => $folder->customs_agent ?? '—'],
                    ['label' => 'Numéro Container', 'value' => $folder->container_number ?? '—'],
                    ['label' => 'Poids', 'value' => number_format($folder->weight ?? 0, 2)],
                    ['label' => 'Quantité', 'value' => number_format($folder->quantity ?? 0, 2)],
                    ['label' => 'Montant FOB', 'value' => number_format($folder->fob_amount ?? 0, 2)],
                    ['label' => 'Montant Assurance', 'value' => number_format($folder->insurance_amount ?? 0, 2)],
                    ['label' => 'Montant CIF', 'value' => number_format($folder->cif_amount ?? 0, 2)],
                    ['label' => 'Fret', 'value' => number_format($folder->freight_amount ?? 0, 2)],
                    ['label' => 'Devise', 'value' => optional($folder->currency)->code ?? '—'],
                    ['label' => 'Type de Dossier', 'value' => optional($folder->dossier_type)->label() ?? '—'],
                    ['label' => 'Numéro Licence', 'value' => optional($folder->license)->license_number ?? '—'],
                    ['label' => 'Date Arrivée Frontière', 'value' => optional($folder->arrival_border_date)->format('d/m/Y') ?? '—'],
                    ['label' => 'Code Licence', 'value' => $folder->license_code ?? '—'],
                    ['label' => 'Code BIVAC', 'value' => $folder->bivac_code ?? '—'],
                    ['label' => 'Numéro Scellé', 'value' => $folder->scelle_number ?? '—'],
                    ['label' => 'Numéro Manifeste', 'value' => $folder->manifest_number ?? '—'],
                    ['label' => 'Incoterm', 'value' => $folder->incoterm ?? '—'],
                    ['label' => 'Régime', 'value' => $folder->customs_regime ?? '—'],
                    ['label' => 'Code Additionnel', 'value' => $folder->additional_code ?? '—'],
                    ['label' => 'Date de Cotation', 'value' => optional($folder->quotation_date)->format('d/m/Y') ?? '—'],
                    ['label' => "Date d'Ouverture", 'value' => optional($folder->opening_date)->format('d/m/Y') ?? '—'],
                    ['label' => "Point d'Entrée", 'value' => $folder->entry_point ?? '—'],
                    ['label' => 'Numéro TR8', 'value' => $folder->tr8_number ?? '—'],
                    ['label' => 'Date TR8', 'value' => optional($folder->tr8_date)->format('d/m/Y') ?? '—'],
                    ['label' => 'Numéro T1', 'value' => $folder->t1_number ?? '—'],
                    ['label' => 'Date T1', 'value' => optional($folder->t1_date)->format('d/m/Y') ?? '—'],
                    ['label' => 'Référence Bureau Formalités', 'value' => $folder->formalities_office_reference ?? '—'],
                    ['label' => 'Numéro IM4', 'value' => $folder->im4_number ?? '—'],
                    ['label' => 'Date IM4', 'value' => optional($folder->im4_date)->format('d/m/Y') ?? '—'],
                    ['label' => 'Numéro Liquidation', 'value' => $folder->liquidation_number ?? '—'],
                    ['label' => 'Date Liquidation', 'value' => optional($folder->liquidation_date)->format('d/m/Y') ?? '—'],
                    ['label' => 'Numéro Quittance', 'value' => $folder->quitance_number ?? '—'],
                    ['label' => 'Date Quittance', 'value' => optional($folder->quitance_date)->format('d/m/Y') ?? '—'],
                ];
            @endphp

            @foreach ($fields as $field)
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg shadow-sm">
                    <p class="text-xs uppercase text-gray-500 dark:text-gray-400">{{ $field['label'] }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $field['value'] }}</p>
                </div>
            @endforeach

            <div class="sm:col-span-2 lg:col-span-3">
                <div class="bg-yellow-50 dark:bg-yellow-900/10 p-4 rounded-lg border-l-4 border-yellow-400">
                    <p class="text-xs uppercase text-yellow-800 dark:text-yellow-200 mb-1 font-semibold">Description</p>
                    <p class="text-sm text-gray-800 dark:text-gray-100">{{ $folder->description ?? '—' }}</p>
                </div>
            </div>

            {{-- Section pour la Facture Associée --}}
            @if ($folder->invoice)
                <div
                    class="sm:col-span-1 lg:col-span-1 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                    <h4 class="text-md font-semibold mb-2 text-gray-700 dark:text-gray-200">Facture Associée</h4>
                    <p>
                        <a href="{{ route('invoices.show', $folder->invoice->id) }}"
                            class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                            Voir Facture N° {{ $folder->invoice->invoice_number ?? 'N/A' }}
                        </a>
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                        Montant: {{ number_format($folder->invoice->total_usd ?? 0, 2) }} USD
                        {{-- Adaptez le champ de montant et la devise si nécessaire --}}
                    </p>
                </div>
            @endif
        </div>

        <!-- Files -->
        <div x-show="tab === 'files'" x-cloak>
            @livewire('admin.folder.operations.upload-files', ['folder' => $folder], key('upload-files-' . $folder->id))
        </div>

        <!-- Progress -->
        <div x-show="tab === 'progress'" x-cloak>
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">📊 Suivi de progression</h4>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                <div class="bg-green-500 h-full transition-all duration-500"
                    style="width: {{ $folder->progress_percentage }}%"></div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                {{ $folder->progress_percentage }}% terminé
            </p>
        </div>

        <div class="mt-6">
            @livewire('admin.folder.folder-extra-fields', ['folder' => $folder], key('extra-fields-' . $folder->id))
        </div>

        <div class="mt-6">
            @livewire('admin.folder.folder-lines-form', ['folder' => $folder], key('lines-form-' . $folder->id))
        </div>
    </div>
</div>
