<div class="w-full mx-auto p-6 space-y-6">
    <x-ui.flash-message />
    <x-ui.error-message />

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-sm">
        <div class="space-y-8 p-6">
            <h2 class="text-2xl font-bold flex items-center gap-2 text-gray-800 dark:text-white">
                🧾
                <span>Ajouter des éléments à la facture {{ $invoice->invoice_number }}</span>
            </h2>

            <section class="space-y-4">
                <h3 class="text-lg font-semibold flex items-center gap-2 text-gray-700 dark:text-gray-200">💰 Taxes</h3>
                @foreach($taxItems as $i => $item)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-5">
                            <x-forms.select label="Taxe" :model="'taxItems.' . $i . '.tax_id'" :options="$taxes" optionLabel="label" optionValue="id" />
                        </div>
                <div class="md:col-span-5">
                    <x-forms.input label="Montant USD" type="number" step="0.01" :model="'taxItems.' . $i . '.amount_usd'" />
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" wire:click="removeItem('tax', {{ $i }})" class="text-red-600 hover:text-red-800 text-lg">❌</button>
                </div>
            </div>
        @endforeach
                <button type="button" wire:click="addTaxItem" class="flex items-center text-sm text-blue-600 hover:text-blue-800 transition">
                    ➕ <span class="ml-1">Ajouter une taxe</span>
                </button>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg font-semibold flex items-center gap-2 text-gray-700 dark:text-gray-200">🏢 Frais agence</h3>
        @foreach($agencyFeeItems as $i => $item)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <x-forms.select label="Frais agence" :model="'agencyFeeItems.' . $i . '.agency_fee_id'" :options="$agencyFees" optionLabel="label" optionValue="id" />
                </div>
                <div class="md:col-span-5">
                    <x-forms.input label="Montant USD" type="number" step="0.01" :model="'agencyFeeItems.' . $i . '.amount_usd'" />
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" wire:click="removeItem('agency', {{ $i }})" class="text-red-600 hover:text-red-800 text-lg">❌</button>
                </div>
            </div>
        @endforeach
                <button type="button" wire:click="addAgencyFeeItem" class="flex items-center text-sm text-blue-600 hover:text-blue-800 transition">
                    ➕ <span class="ml-1">Ajouter un frais agence</span>
                </button>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg font-semibold flex items-center gap-2 text-gray-700 dark:text-gray-200">📝 Autres frais</h3>
        @foreach($extraFeeItems as $i => $item)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <x-forms.select label="Frais divers" :model="'extraFeeItems.' . $i . '.extra_fee_id'" :options="$extraFees" optionLabel="label" optionValue="id" />
                </div>
                <div class="md:col-span-5">
                    <x-forms.input label="Montant USD" type="number" step="0.01" :model="'extraFeeItems.' . $i . '.amount_usd'" />
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" wire:click="removeItem('extra', {{ $i }})" class="text-red-600 hover:text-red-800 text-lg">❌</button>
                </div>
            </div>
        @endforeach
                <button type="button" wire:click="addExtraFeeItem" class="flex items-center text-sm text-blue-600 hover:text-blue-800 transition">
                    ➕ <span class="ml-1">Ajouter un frais divers</span>
                </button>
            </section>

            <div class="flex justify-end pt-6">
                <x-forms.button wire:click="save" color="purple">💾 Enregistrer</x-forms.button>
            </div>
        </div>
    </div>
</div>
