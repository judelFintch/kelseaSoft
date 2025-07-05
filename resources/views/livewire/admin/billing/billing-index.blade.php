<div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold mb-4">Dossiers en cours</h2>

    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th class="px-3 py-2 text-left">Dossier</th>
                <th class="px-3 py-2 text-right">Solde</th>
                <th class="px-3 py-2"></th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200">
            @forelse($folders as $folder)
                <tr>
                    <td class="px-3 py-2">{{ $folder->folder_number }}</td>
                    <td class="px-3 py-2 text-right">{{ number_format($folder->balance, 2, ',', ' ') }}</td>
                    <td class="px-3 py-2 text-right">
                        <a href="{{ route('folder.transactions', $folder->id) }}" class="text-blue-600 hover:underline">Ouvrir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-3 py-4 text-center text-gray-500">Aucun dossier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
