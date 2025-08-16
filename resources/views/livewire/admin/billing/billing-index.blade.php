<div class="space-y-4 bg-white dark:bg-gray-900 p-6 rounded-xl shadow">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">Dossiers en cours</h2>
        <input type="text" wire:model.debounce.500ms="search" placeholder="Rechercher..."
            class="border rounded px-3 py-1 text-sm" />
    </div>

    <div class="overflow-x-auto border rounded">
        <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-3 py-2 text-left">Dossier</th>
                    <th class="px-3 py-2 text-left">Client</th>
                    <th class="px-3 py-2 text-right">Solde</th>
                    <th class="px-3 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($folders as $folder)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-3 py-2 whitespace-nowrap">{{ $folder->folder_number }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $folder->company?->name ?? '—' }}</td>
                        <td class="px-3 py-2 text-right whitespace-nowrap">{{ number_format($folder->balance, 2, ',', ' ') }}</td>
                        <td class="px-3 py-2 text-right">
                            <a href="{{ route('folder.transactions', $folder->id) }}" class="text-blue-600 hover:underline">Détails</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-3 py-4 text-center text-gray-500">Aucun dossier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $folders->links('vendor.pagination.tailwind') }}
    </div>
</div>
