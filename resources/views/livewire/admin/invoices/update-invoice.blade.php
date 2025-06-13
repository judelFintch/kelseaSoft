<div>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <x-ui.flash-message />
        <x-ui.error-message />

        <form wire:submit.prevent="updateInvoice">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Modifier la Facture</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-forms.input label="Date" model="invoice_date" type="date" />
                    <x-forms.input label="Produit" model="product" />
                    <x-forms.input label="Poids (kg)" model="weight" type="number" step="0.01" />
                    <x-forms.input label="Code Opération" model="operation_code" />
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <x-forms.input label="FOB" model="fob_amount" type="number" step="0.01" />
                    <x-forms.input label="Assurance" model="insurance_amount" type="number" step="0.01" />
                    <x-forms.input label="Fret" model="freight_amount" type="number" step="0.01" />
                    <x-forms.input label="CIF" model="cif_amount" type="number" step="0.01" />
                </div>

                <x-forms.select label="Mode de paiement" model="payment_mode" :options="[['id' => 'provision','name' => 'Provision'], ['id' => 'comptant','name' => 'Comptant']]" optionLabel="name" optionValue="id" />

                <hr class="my-4" />
                <h3 class="text-md font-semibold text-gray-800 dark:text-white">Lignes de Facture</h3>
                <div class="space-y-4">
                    @foreach($items as $i => $item)
                        <div class="grid grid-cols-6 gap-2 items-end">
                            <x-forms.input label="Libellé" :model="'items.' . $i . '.label'" />
                            <x-forms.input label="Montant USD" :model="'items.' . $i . '.amount_usd'" type="number" step="0.01" />
                            <x-forms.select label="Taxe" :model="'items.' . $i . '.tax_id'" :options="$taxes" optionLabel="label" optionValue="id" />
                            <x-forms.select label="Frais agence" :model="'items.' . $i . '.agency_fee_id'" :options="$agencyFees" optionLabel="label" optionValue="id" />
                            <x-forms.select label="Frais divers" :model="'items.' . $i . '.extra_fee_id'" :options="$extraFees" optionLabel="label" optionValue="id" />
                            <button type="button" wire:click="removeItem({{ $i }})" class="text-red-600 text-sm">❌</button>
                        </div>
                    @endforeach

                    <button type="button" wire:click="addItem" class="text-sm text-blue-600 hover:underline">➕ Ajouter une ligne</button>
                </div>

                <div class="flex justify-end pt-4">
                    <x-forms.button type="submit">Mettre à jour</x-forms.button>
                </div>
            </div>
        </form>
    </div>
</div>
