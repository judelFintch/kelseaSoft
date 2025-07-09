<div class="p-6 bg-white rounded shadow space-y-4">
    <h2 class="text-xl font-bold">💾 Sauvegardes</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 px-3 py-2 rounded">{{ session('error') }}</div>
    @endif

    <button wire:click="createBackup" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
        ➕ Nouvelle sauvegarde
    </button>

    <table class="w-full mt-4 border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Fichier</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($files as $file)
                <tr>
                    <td class="border px-2 py-1">{{ $file }}</td>
                    <td class="border px-2 py-1 space-x-2">
                        <a href="{{ route('backups.download', $file) }}" class="text-blue-600 hover:underline">Télécharger</a>
                        <button wire:click="restoreBackup('{{ $file }}')" class="text-green-600 hover:underline">Restaurer</button>
                        <button wire:click="deleteBackup('{{ $file }}')" class="text-red-600 hover:underline">Supprimer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center py-4 text-gray-500">Aucune sauvegarde</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
