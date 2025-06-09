<div x-data="{ tab: 'details' }" class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
    <!-- Header + Actions -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📁 Dossier : {{ $folder->folder_number }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">📅 Arrivée : {{ $folder->arrival_border_date }}</p>
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
                class="inline-flex items-center px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 dark:bg-indigo-700 dark:text-indigo-100 dark:hover:bg-indigo-600">✏️
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
                    ['label' => 'Truck Number', 'value' => $folder->truck_number],
                    ['label' => 'Trailer Number', 'value' => $folder->trailer_number],
                    ['label' => 'Invoice Number', 'value' => $folder->invoice_number],
                    ['label' => 'Goods Type', 'value' => $folder->goods_type],
                    ['label' => 'Agency', 'value' => $folder->agency],
                    ['label' => 'Pre-alert Place', 'value' => $folder->pre_alert_place],
                    ['label' => 'Transport Mode', 'value' => $folder->transport_mode],
                    ['label' => 'Internal Reference', 'value' => $folder->internal_reference],
                    ['label' => 'Order Number', 'value' => $folder->order_number],
                    ['label' => 'Folder Date', 'value' => $folder->folder_date],
                    ['label' => 'Transporter', 'value' => $folder->transporter?->name],
                    ['label' => 'Driver Name', 'value' => $folder->driver_name],
                    ['label' => 'Driver Phone', 'value' => $folder->driver_phone],
                    ['label' => 'Nationality', 'value' => $folder->driver_nationality],
                    ['label' => 'Origin', 'value' => $folder->origin?->name],
                    ['label' => 'Destination', 'value' => $folder->destination?->name],
                    ['label' => 'Client', 'value' => $folder->company?->name],
                    ['label' => 'Supplier', 'value' => $folder->supplier?->name],
                    ['label' => 'Customs Office', 'value' => $folder->customsOffice?->name],
                    ['label' => 'Declaration Number', 'value' => $folder->declaration_number],
                    ['label' => 'Declaration Type', 'value' => $folder->declarationType?->name],
                    ['label' => 'Declarant', 'value' => $folder->declarant],
                    ['label' => 'Customs Agent', 'value' => $folder->customs_agent],
                    ['label' => 'Container', 'value' => $folder->container_number],
                    ['label' => 'Weight', 'value' => $folder->weight],
                    ['label' => 'Quantity', 'value' => $folder->quantity],
                    ['label' => 'FOB Amount', 'value' => $folder->fob_amount],
                    ['label' => 'Insurance Amount', 'value' => $folder->insurance_amount],
                    ['label' => 'CIF Amount', 'value' => $folder->cif_amount],
                    ['label' => 'Arrival Border Date', 'value' => $folder->arrival_border_date],
                    ['label' => 'License Code', 'value' => $folder->license_code],
                    ['label' => 'BIVAC Code', 'value' => $folder->bivac_code],
                    ['label' => 'TR8 Number', 'value' => $folder->tr8_number],
                    ['label' => 'TR8 Date', 'value' => $folder->tr8_date],
                    ['label' => 'T1 Number', 'value' => $folder->t1_number],
                    ['label' => 'T1 Date', 'value' => $folder->t1_date],
                    ['label' => 'Formalities Office Ref', 'value' => $folder->formalities_office_reference],
                    ['label' => 'IM4 Number', 'value' => $folder->im4_number],
                    ['label' => 'IM4 Date', 'value' => $folder->im4_date],
                    ['label' => 'Liquidation Number', 'value' => $folder->liquidation_number],
                    ['label' => 'Liquidation Date', 'value' => $folder->liquidation_date],
                    ['label' => 'Quitance Number', 'value' => $folder->quitance_number],
                    ['label' => 'Quitance Date', 'value' => $folder->quitance_date],
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
                    <p class="text-sm text-gray-800 dark:text-gray-100">{{ $folder->description }}</p>
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
    </div>
</div>
