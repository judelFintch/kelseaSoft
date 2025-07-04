<div class="w-full mx-auto p-6 space-y-6">
    <x-ui.flash-message />
    <x-ui.error-message />

    <form wire:submit.prevent="loadInvoice" class="flex gap-2 items-end">
        <x-forms.input label="Numéro de facture" model="invoiceNumber" class="flex-1" />
        <x-forms.button type="submit">Charger</x-forms.button>
    </form>

    @if($invoice)
        <div class="bg-white dark:bg-gray-800 border rounded-xl p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Facture {{ $invoice->invoice_number }}</h2>

            @foreach($items as $i => $item)
                <div class="grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-4">
                        <x-forms.input label="Libellé" :model="'items.' . $i . '.label'" />
                    </div>
                    <div class="col-span-2">
                        <x-forms.input label="Quantité" type="number" step="1" :model="'items.' . $i . '.quantity'" />
                    </div>
                    <div class="col-span-3">
                        <x-forms.input label="Montant USD" type="number" step="0.01" :model="'items.' . $i . '.amount_usd'" />
                    </div>
                    <div class="col-span-2">
                        <x-forms.select label="Taxe" :model="'items.' . $i . '.tax_id'" :options="$taxes" optionLabel="label" optionValue="id" />
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <x-forms.button type="button" wire:click="updateItem({{ $i }})">Valider</x-forms.button>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end pt-4">
                <x-forms.button type="button" wire:click="validateInvoice">Valider l'opération</x-forms.button>
            </div>
        </div>
    @endif
</div>
