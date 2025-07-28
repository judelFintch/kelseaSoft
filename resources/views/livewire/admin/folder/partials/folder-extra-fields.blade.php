<div class="space-y-4">
    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-200">Informations complémentaires</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <input type="text" wire:model.defer="scelle_number" placeholder="N° scellé" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="manifest_number" placeholder="N° manifeste" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="incoterm" placeholder="Incoterm" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="customs_regime" placeholder="Régime" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="additional_code" placeholder="Code additionnel" class="border rounded px-2 py-1">
        <input type="date" wire:model.defer="quotation_date" class="border rounded px-2 py-1">
        <input type="date" wire:model.defer="opening_date" class="border rounded px-2 py-1">
        <input type="text" wire:model.defer="entry_point" placeholder="Point d'entrée" class="border rounded px-2 py-1">
    </div>
    <button wire:click="save" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
</div>
