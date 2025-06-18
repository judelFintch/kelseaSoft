<div class="w-full mx-auto space-y-6">
    <x-ui.flash-message />
    <x-ui.error-message />

    <h2 class="text-xl font-bold">Ajouter des éléments à la facture {{ $invoice->invoice_number }}</h2>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-4 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold">Taxes</h3>
        @foreach($taxItems as $i => $item)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <x-forms.select label="Taxe" :model="'taxItems.' . $i . '.tax_id'" :options="$taxes" optionLabel="label" optionValue="id" />
                </div>
                <div class="md:col-span-5">
                    <x-forms.input label="Montant USD" type="number" step="0.01" :model="'taxItems.' . $i . '.amount_usd'" />
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" wire:click="removeItem('tax', {{ $i }})" class="text-red-600 text-sm">❌</button>
                </div>
            </div>
        @endforeach
        <button type="button" wire:click="addTaxItem" class="text-sm text-blue-600 hover:underline">➕ Ajouter une taxe</button>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-4 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold">Frais agence</h3>
        @foreach($agencyFeeItems as $i => $item)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <x-forms.select label="Frais agence" :model="'agencyFeeItems.' . $i . '.agency_fee_id'" :options="$agencyFees" optionLabel="label" optionValue="id" />
                </div>
                <div class="md:col-span-5">
                    <x-forms.input label="Montant USD" type="number" step="0.01" :model="'agencyFeeItems.' . $i . '.amount_usd'" />
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" wire:click="removeItem('agency', {{ $i }})" class="text-red-600 text-sm">❌</button>
                </div>
            </div>
        @endforeach
        <button type="button" wire:click="addAgencyFeeItem" class="text-sm text-blue-600 hover:underline">➕ Ajouter un frais agence</button>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-4 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold">Autres frais</h3>
        @foreach($extraFeeItems as $i => $item)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <x-forms.select label="Frais divers" :model="'extraFeeItems.' . $i . '.extra_fee_id'" :options="$extraFees" optionLabel="label" optionValue="id" />
                </div>
                <div class="md:col-span-5">
                    <x-forms.input label="Montant USD" type="number" step="0.01" :model="'extraFeeItems.' . $i . '.amount_usd'" />
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" wire:click="removeItem('extra', {{ $i }})" class="text-red-600 text-sm">❌</button>
                </div>
            </div>
        @endforeach
        <button type="button" wire:click="addExtraFeeItem" class="text-sm text-blue-600 hover:underline">➕ Ajouter un frais divers</button>
    </div>

    <div class="flex justify-end">
        <x-forms.button wire:click="save" color="purple">Enregistrer</x-forms.button>
    </div>
</div>
