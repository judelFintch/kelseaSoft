<div class="space-y-4">
    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-200">Lignes de cotation</h4>

    <table class="w-full text-sm border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Position</th>
                <th class="border px-2 py-1">Description</th>
                <th class="border px-2 py-1">Colis</th>
                <th class="border px-2 py-1">Poids Brut</th>
                <th class="border px-2 py-1">Poids Net</th>
                <th class="border px-2 py-1">FOB</th>
                <th class="border px-2 py-1"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($folder->lines as $l)
                <tr>
                    <td class="border px-2 py-1">{{ $l->position_code }}</td>
                    <td class="border px-2 py-1">{{ $l->description }}</td>
                    <td class="border px-2 py-1">{{ $l->colis }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($l->gross_weight,2) }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($l->net_weight,2) }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($l->fob_amount,2) }}</td>
                    <td class="border px-2 py-1 text-center">
                        <button wire:click="deleteLine({{ $l->id }})" class="text-red-600">✖</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
        <input type="text" wire:model.defer="line.position_code" placeholder="Position" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="line.description" placeholder="Description" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="line.colis" placeholder="Colis" class="border rounded px-2 py-1">
        <input type="number" step="0.01" wire:model.defer="line.gross_weight" placeholder="Poids Brut" class="border rounded px-2 py-1">
        <input type="number" step="0.01" wire:model.defer="line.net_weight" placeholder="Poids Net" class="border rounded px-2 py-1">
        <input type="number" step="0.01" wire:model.defer="line.fob_amount" placeholder="FOB" class="border rounded px-2 py-1">
    </div>
    <button wire:click="addLine" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded">Ajouter</button>
</div>
