<div>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-end mb-4">
            <button wire:click="exportExcel"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all duration-200">
                📤 Export Excel
            </button>
        </div>
        <!-- Header + Search + Create -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📁 Folders</h2>

            <div class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                <input type="search" wire:model.debounce.500ms="search" placeholder="Search folders..."
                    class="w-full sm:w-64 rounded-lg px-4 py-2 text-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-white shadow-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" />

                <a href="{{ route('folder.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-all duration-200 shadow-theme-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Folder
                </a>
            </div>
        </div>

        <!-- Filtres avancés en colonne -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div>
                <x-forms.select label="Transporter" wire:model="filterTransporter" :options="$transporters" option-label="name"
                    option-value="id" placeholder="All Transporters" />
            </div>

            <div>
                <x-forms.date label="From Date" wire:model="filterDateFrom" />
            </div>

            <div>
                <x-forms.date label="To Date" wire:model="filterDateTo" />
            </div>

            <div class="flex items-end">
                <button wire:click="$refresh"
                    class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg transition">
                    🔄 Refresh
                </button>
            </div>
        </div>
        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Folder Number</th>
                        <th class="px-4 py-2 text-left">Truck</th>
                        <th class="px-4 py-2 text-left">Company</th>
                        <th class="px-4 py-2 text-left">Transporter</th>
                        <th class="px-4 py-2 text-left">Supplier</th>
                        <th class="px-4 py-2 text-left">Origin → Destination</th>
                        <th class="px-4 py-2 text-left">Border Date</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($folders as $folder)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition text-gray-800 dark:text-gray-100">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-brand-600">{{ $folder->folder_number }}</td>
                            <td class="px-4 py-3">{{ $folder->truck_number }}</td>
                            <td class="px-4 py-3">{{ $folder->company?->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $folder->transporter?->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $folder->supplier?->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                {{ $folder->origin?->name ?? '?' }} → {{ $folder->destination?->name ?? '?' }}
                            </td>
                            <td class="px-4 py-3">{{ $folder->arrival_border_date?->format('Y-m-d') ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="inline-flex justify-center w-full rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">
                                        Options
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
                                            <a href="{{ route('folder.show', $folder->id) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                👁 View
                                            </a>
                                            <a href="{{ route('folder.edit', $folder->id) }}"
                                                class="block px-4 py-2 text-sm text-yellow-600 hover:bg-gray-100 dark:text-yellow-400 dark:hover:bg-gray-700">
                                                ✏️ Edit
                                            </a>
                                            <button wire:click="$emit('confirmFolderDelete', {{ $folder->id }})"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                                                🗑 Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9"
                                class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 font-medium">
                                No folders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $folders->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
