<div>
    <div class="max-w-7xl mx-auto px-4 py-6">
        {{-- Column Selection UI --}}
        <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
            <h4 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">Select Visible Columns:</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @foreach($allColumns as $key => $label)
                    <label class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <input type="checkbox" wire:model.live="visibleColumns" value="{{ $key }}" class="form-checkbox h-5 w-5 text-indigo-600 rounded dark:bg-gray-800 dark:border-gray-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between mb-2">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Liste des dossiers ({{ $totalFolders }})</h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <label>
                    Per page:
                    <select wire:model="perPage" class="ml-2 form-select text-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </label>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900">
            <h4 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">Filtres</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-2">
                <x-forms.input model="search" placeholder="🔍 Rechercher..." class="w-full" />
                <x-forms.select model="filterCompany" :options="$companies" option-label="name" option-value="id" placeholder="-- Compagnie --" class="w-full" />
                <x-forms.select model="filterType" :options="$dossierTypeOptions" option-label="label" option-value="value" placeholder="-- Type --" class="w-full" />
                <x-forms.select model="filterTransporter" :options="$transporters" option-label="name" option-value="id" placeholder="-- Transporteur --" class="w-full" />
                <x-forms.input model="filterDateFrom" type="date" placeholder="De" class="w-full" />
                <x-forms.input model="filterDateTo" type="date" placeholder="À" class="w-full" />
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th> {{-- Static first column --}}
                        @foreach($allColumns as $key => $label)
                            @if(in_array($key, $visibleColumns))
                                <th class="px-4 py-3 text-left">{{ $label }}</th>
                            @endif
                        @endforeach
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($folders as $folder)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3">{{ $folders->firstItem() + $loop->index }}</td> {{-- Static first cell --}}
                            @foreach($allColumns as $key => $label)
                                @if(in_array($key, $visibleColumns))
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @switch($key)
                                            @case('folder_number')
                                                <a href="{{ route('folder.show', $folder->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-600 font-medium">
                                                    {{ $folder->folder_number }}
                                                </a>
                                                @break
                                            @case('transporter_name')
                                                {{ $folder->transporter?->name }}
                                                @break
                                            @case('origin_name')
                                                {{ $folder->origin?->name }}
                                                @break
                                            @case('destination_name')
                                                {{ $folder->destination?->name }}
                                                @break
                                            @case('supplier_name')
                                                {{ $folder->supplier?->name }}
                                                @break
                                            @case('company_name')
                                                {{ $folder->company?->name }}
                                                @break
                                            @case('customs_office_name')
                                                {{ $folder->customsOffice?->name }}
                                                @break
                                            @case('declaration_type_name')
                                                {{ $folder->declarationType?->name }}
                                                @break
                                            @case('license_number')
                                                {{ $folder->license?->license_number }}
                                                @break
                                            @case('created_at')
                                                {{ $folder->created_at->format('Y-m-d') }}
                                                @break
                                            @case('folder_date')
                                            @case('arrival_border_date')
                                            @case('tr8_date')
                                            @case('t1_date')
                                            @case('im4_date')
                                            @case('liquidation_date')
                                            @case('quitance_date')
                                                {{ optional($folder->$key)->format('Y-m-d') }}
                                                @break
                                            @case('description')
                                                {{ Str::limit($folder->description, 25) }}
                                                @break
                                        @default
                                            {{ $folder->$key }}
                                        @endswitch
                                    </td>
                                @endif
                            @endforeach
                            <td class="px-4 py-3">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="text-gray-500 hover:text-gray-700">•••</button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('folder.show', $folder->id)">Afficher</x-dropdown-link>
                                        <x-dropdown-link :href="route('folder.edit', $folder->id)" class="text-indigo-600 hover:text-indigo-800">Modifier</x-dropdown-link>
                                        <button wire:click="archiveFolder({{ $folder->id }})"
                                            onclick="return confirm('Archiver ce dossier ?');"
                                            class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            Archiver
                                        </button>
                                    </x-slot>
                                </x-dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Adjust colspan: 1 for # column + count of visible columns --}}
                            <td colspan="{{ 2 + count($visibleColumns) }}" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No folders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-end">
            {{ $folders->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
