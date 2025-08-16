<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Modifier la devise</h2>
    <x-ui.flash-message />
    <x-ui.error-message />
    <form wire:submit.prevent="updateCurrency" class="space-y-4">
        <x-forms.input label="Code" model="code" placeholder="USD" />
        <x-forms.input label="Nom" model="name" placeholder="Dollar américain" />
        <x-forms.input label="Symbole" model="symbol" placeholder="$" />
        <x-forms.input label="Taux de change" model="exchange_rate" placeholder="1" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Enregistrer
        </button>
    </form>
</div>
