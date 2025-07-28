<div class="space-y-4">
    <h3 class="text-md font-semibold">Informations complémentaires</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-forms.input label="N° Scellé" model="scelle_number" />
        <x-forms.input label="N° Manifest" model="manifest_number" />
        <x-forms.input label="Incoterm" model="incoterm" />
        <x-forms.input label="Régime Douanier" model="customs_regime" />
        <x-forms.input label="Code Additionnel" model="additional_code" />
        <x-forms.date label="Date Devis" model="quotation_date" />
        <x-forms.date label="Date Ouverture" model="opening_date" />
        <x-forms.input label="Point d'Entrée" model="entry_point" />
    </div>
    <button type="button" wire:click="save" class="px-2 py-1 bg-indigo-600 text-white rounded">Enregistrer</button>
</div>
