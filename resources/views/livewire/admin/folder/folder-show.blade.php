<div x-data="{ tab: 'details' }" class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
    <!-- Barre info et actions -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📁 Dossier : {{ $folder->folder_number }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">📅 Arrivée : {{ $folder->arrival_border_date }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('folder.edit', $folder) }}"
               class="inline-flex items-center px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200">
                ✏️ Modifier
            </a>
            <button wire:click="confirmDelete"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200">
                🗑 Supprimer
            </button>
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
                class="flex items-center gap-1 px-1 pb-3 transition">
                📄 Détails
            </button>

            <button @click="tab = 'files'"
                :class="tab === 'files' ? 'border-b-2 border-green-500 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-green-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">
                📁 Fichiers
            </button>

            <button @click="tab = 'progress'"
                :class="tab === 'progress' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-blue-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">
                ⏳ Progression
            </button>
        </nav>
    </div>

    <!-- PANELS -->
    <div class="mt-4 space-y-6">
        <!-- DÉTAILS -->
        <div x-show="tab === 'details'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $fields = [
                    ['label' => 'Truck Number', 'value' => $folder->truck_number],
                    ['label' => 'Trailer Number', 'value' => $folder->trailer_number],
                    ['label' => 'Transporter', 'value' => $folder->transporter],
                    ['label' => 'Driver Name', 'value' => $folder->driver_name],
                    ['label' => 'Driver Phone', 'value' => $folder->driver_phone],
                    ['label' => 'Nationality', 'value' => $folder->driver_nationality],
                    ['label' => 'Origin', 'value' => $folder->origin],
                    ['label' => 'Destination', 'value' => $folder->destination],
                    ['label' => 'Client', 'value' => $folder->client],
                    ['label' => 'Supplier', 'value' => $folder->supplier],
                    ['label' => 'Customs Office', 'value' => $folder->customs_office],
                    ['label' => 'Declaration Number', 'value' => $folder->declaration_number],
                    ['label' => 'Declaration Type', 'value' => $folder->declaration_type],
                    ['label' => 'Declarant', 'value' => $folder->declarant],
                    ['label' => 'Customs Agent', 'value' => $folder->customs_agent],
                    ['label' => 'Container', 'value' => $folder->container_number],
                    ['label' => 'Weight', 'value' => $folder->weight . ' kg'],
                    ['label' => 'FOB', 'value' => $folder->fob_amount . ' USD'],
                    ['label' => 'Insurance', 'value' => $folder->insurance_amount . ' USD'],
                    ['label' => 'CIF', 'value' => $folder->cif_amount . ' USD'],
                ];
            @endphp

            @foreach($fields as $field)
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
        </div>

        @livewire('admin.folder.operations.upload-files', ['folder' => $folder], key('upload-files-' . $folder->id))
        <!-- FICHIERS -->


        <!-- PROGRESSION -->
        <div x-show="tab === 'progress'" x-cloak>
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">📊 Suivi de progression</h4>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                <div class="bg-green-500 h-full transition-all duration-500"
                     style="width: {{ $folder->progress_percentage ?? 60 }}%"></div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                {{ $folder->progress_percentage ?? 60 }}% terminé
            </p>
        </div>
    </div>
</div>
