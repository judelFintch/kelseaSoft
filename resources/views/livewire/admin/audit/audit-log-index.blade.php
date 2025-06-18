<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">📝 Historique des actions</h2>

    <div class="flex mb-4 gap-2">
        <input type="text" wire:model.lazy="search" placeholder="Rechercher..." class="border rounded px-2 py-1 w-full">
    </div>

    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Utilisateur</th>
                <th class="border px-2 py-1">Opération</th>
                <th class="border px-2 py-1">Modèle</th>
                <th class="border px-2 py-1">Référence</th>
                <th class="border px-2 py-1">Message</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td class="border px-2 py-1">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="border px-2 py-1">{{ optional($log->user)->name ?? 'System' }}</td>
                    <td class="border px-2 py-1">{{ $log->operation }}</td>
                    <td class="border px-2 py-1">{{ class_basename($log->auditable_type) }}</td>
                    <td class="border px-2 py-1">{{ $log->identifier }}</td>
                    <td class="border px-2 py-1">{{ $log->message }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border px-2 py-1 text-center">Aucun log</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
