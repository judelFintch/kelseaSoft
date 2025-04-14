<div>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header + Search + Create -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📁 Folders</h2>

            <div class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                <input type="search" wire:model.debounce.500ms="search"
                    placeholder="Search folders..."
                    class="w-full sm:w-64 rounded-lg px-4 py-2 text-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-white shadow-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" />

                <a href="{{ route('folder.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-all duration-200 shadow-theme-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    Create Folder
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr class="text-left font-semibold text-gray-600 dark:text-gray-300">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Folder No.</th>
                        <th class="px-4 py-3">Truck</th>
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Arrival</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($folders as $folder)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition text-gray-800 dark:text-gray-100">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-brand-600">{{ $folder->folder_number }}</td>
                            <td class="px-4 py-3">{{ $folder->truck_number }}</td>
                            <td class="px-4 py-3">{{ $folder->client }}</td>
                            <td class="px-4 py-3">{{ $folder->arrival_border_date?->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('folder.show', $folder->id) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium transition">View</a>
                                <a href="{{ route('folder.edit', $folder->id) }}"
                                   class="text-yellow-600 hover:text-yellow-700 font-medium transition">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
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
