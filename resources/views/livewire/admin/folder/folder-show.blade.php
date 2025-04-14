<div x-data="{ tab: 'details' }" class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
    <!-- Onglets -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex flex-wrap gap-6 text-sm font-semibold">
            <button @click="tab = 'details'"
                :class="tab === 'details' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-indigo-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6M9 16h6M9 8h6M5 20h14a2 2 0 0 0 2-2V6a2..." /></svg>
                Détails
            </button>

            <button @click="tab = 'files'"
                :class="tab === 'files' ? 'border-b-2 border-green-500 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-green-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 0 0 2 2h2..." /></svg>
                Fichiers
            </button>

            <button @click="tab = 'progress'"
                :class="tab === 'progress' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-blue-500'"
                class="flex items-center gap-1 px-1 pb-3 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3..." /></svg>
                Progression
            </button>
        </nav>
    </div>

    <!-- PANELS -->
    <div class="mt-4 space-y-6">
        <!-- DÉTAILS -->
        <div x-show="tab === 'details'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $fields = [
                    ['label' => 'Folder Number', 'value' => $folder->folder_number, 'icon' => 'folder'],
                    ['label' => 'Truck Number', 'value' => $folder->truck_number, 'icon' => 'truck'],
                    ['label' => 'Trailer Number', 'value' => $folder->trailer_number, 'icon' => 'truck'],
                    ['label' => 'Transporter', 'value' => $folder->transporter, 'icon' => 'user'],
                    ['label' => 'Driver Name', 'value' => $folder->driver_name, 'icon' => 'user'],
                    ['label' => 'Driver Phone', 'value' => $folder->driver_phone, 'icon' => 'phone'],
                    ['label' => 'Nationality', 'value' => $folder->driver_nationality, 'icon' => 'globe'],
                    ['label' => 'Origin', 'value' => $folder->origin, 'icon' => 'map'],
                    ['label' => 'Destination', 'value' => $folder->destination, 'icon' => 'location'],
                    ['label' => 'Client', 'value' => $folder->client, 'icon' => 'office-building'],
                    ['label' => 'Supplier', 'value' => $folder->supplier, 'icon' => 'office-building'],
                    ['label' => 'Customs Office', 'value' => $folder->customs_office, 'icon' => 'building'],
                    ['label' => 'Declaration Number', 'value' => $folder->declaration_number, 'icon' => 'document'],
                    ['label' => 'Declaration Type', 'value' => $folder->declaration_type, 'icon' => 'document'],
                    ['label' => 'Declarant', 'value' => $folder->declarant, 'icon' => 'user'],
                    ['label' => 'Customs Agent', 'value' => $folder->customs_agent, 'icon' => 'user'],
                    ['label' => 'Container', 'value' => $folder->container_number, 'icon' => 'cube'],
                    ['label' => 'Weight', 'value' => $folder->weight . ' kg', 'icon' => 'scale'],
                    ['label' => 'FOB', 'value' => $folder->fob_amount . ' USD', 'icon' => 'cash'],
                    ['label' => 'Insurance', 'value' => $folder->insurance_amount . ' USD', 'icon' => 'shield'],
                    ['label' => 'CIF', 'value' => $folder->cif_amount . ' USD', 'icon' => 'credit-card'],
                    ['label' => 'Arrival Date', 'value' => $folder->arrival_border_date, 'icon' => 'calendar'],
                ];
            @endphp

            @foreach($fields as $field)
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-indigo-500 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <!-- Placeholder for icon logic. You can dynamically include from Heroicons or BladeUI -->
                        <use xlink:href="#icon-{{ $field['icon'] }}"></use>
                    </svg>
                    <div>
                        <p class="text-xs uppercase text-gray-500 dark:text-gray-400">{{ $field['label'] }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $field['value'] }}</p>
                    </div>
                </div>
            @endforeach

            <div class="sm:col-span-2 lg:col-span-3">
                <div class="bg-yellow-50 dark:bg-yellow-900/10 p-4 rounded-lg border-l-4 border-yellow-400">
                    <p class="text-xs uppercase text-yellow-800 dark:text-yellow-200 mb-1 font-semibold">Description</p>
                    <p class="text-sm text-gray-800 dark:text-gray-100">{{ $folder->description }}</p>
                </div>
            </div>
        </div>

        <!-- FICHIERS -->
        <div x-show="tab === 'files'" x-cloak class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Joindre un fichier</label>
            <input type="file" wire:model="file" class="w-full text-sm text-gray-800 border-gray-300 rounded" />

            @if ($folder->files && count($folder->files))
                <ul class="list-disc list-inside text-sm text-gray-800 dark:text-gray-100">
                    @foreach($folder->files as $file)
                        <li>
                            <a href="{{ asset('storage/'.$file->path) }}" class="text-blue-600 hover:underline" target="_blank">
                                {{ $file->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500">Aucun fichier joint.</p>
            @endif
        </div>

        <!-- PROGRESSION -->
        <div x-show="tab === 'progress'" x-cloak>
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Suivi de progression</h4>
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
