<div class="space-y-4">
    <h3 class="text-md font-semibold">Lignes de cotation</h3>
    @foreach ($lines as $index => $line)
        <div class="grid grid-cols-6 gap-2 items-end">
            <x-forms.input label="Position" model="lines.{{ $index }}.position_code" />
            <x-forms.input label="Description" model="lines.{{ $index }}.description" />
            <x-forms.input label="Colis" model="lines.{{ $index }}.colis" />
            <x-forms.input label="Poids Brut" type="number" model="lines.{{ $index }}.gross_weight" />
            <x-forms.input label="Poids Net" type="number" model="lines.{{ $index }}.net_weight" />
            <x-forms.currency label="FOB" model="lines.{{ $index }}.fob_amount" />
            <button type="button" wire:click="removeLine({{ $index }})" class="text-red-500">🗑</button>
        </div>
    @endforeach
    <button type="button" wire:click="addLine" class="px-2 py-1 bg-gray-200 rounded">+ Ajouter ligne</button>
    <button type="button" wire:click="save" class="px-2 py-1 bg-indigo-600 text-white rounded">Enregistrer</button>
</div>
