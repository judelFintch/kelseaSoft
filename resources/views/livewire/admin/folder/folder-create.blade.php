<div class="p-6 space-y-6">
    {{-- BARRE DE PROGRESSION --}}
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 mb-6">
        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
             style="width: {{ $step * 33.33 }}%;">
        </div>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Navigation des étapes --}}
        <div class="flex justify-between mb-4">
            <x-forms.button type="button"
                wire:click="previousStep"
                class="bg-gray-500 text-white hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="$step === 1">
                Précédent
            </x-forms.button>

            <div class="font-semibold text-sm">Étape {{ $step }} / 3</div>

            @if ($step < 3)
                <x-forms.button type="button"
                    wire:click="nextStep"
                    class="bg-blue-600 text-white hover:bg-blue-700">
                    Suivant
                </x-forms.button>
            @endif
        </div>

        {{-- ÉTAPE 1 --}}
        @if ($step === 1)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-forms.input label="Folder Number" wire:model.defer="folder.folder_number" required />
                <x-forms.select label="Dossier Type" wire:model.defer="folder.dossier_type"
                    :options="$optionsSelect" optionLabel="label" optionValue="value" placeholder="Sélectionner un type" required />
                <x-forms.select label="Client" wire:model.defer="folder.client"
                    :options="$clients" optionLabel="label" optionValue="value" placeholder="Choisir un client" />
                <x-forms.input label="Truck Number" wire:model.defer="folder.truck_number" required />
                <x-forms.input label="Trailer Number" wire:model.defer="folder.trailer_number" />
                <x-forms.select label="Transporter" wire:model.defer="folder.transporter_id"
                    :options="$transporters" optionLabel="label" optionValue="value" placeholder="Transporteur" />
                <x-forms.input label="Driver Name" wire:model.defer="folder.driver_name" />
                <x-forms.input label="Driver Phone" wire:model.defer="folder.driver_phone" />
                <x-forms.input label="Driver Nationality" wire:model.defer="folder.driver_nationality" />
            </div>
        @endif

        {{-- ÉTAPE 2 --}}
        @if ($step === 2)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-forms.select label="Origin" wire:model.defer="folder.origin_id"
                    :options="$locations" optionLabel="label" optionValue="value" placeholder="Origine" />
                <x-forms.select label="Destination" wire:model.defer="folder.destination_id"
                    :options="$locations" optionLabel="label" optionValue="value" placeholder="Destination" />
                <x-forms.select label="Supplier" wire:model.defer="folder.supplier_id"
                    :options="$suppliers" optionLabel="label" optionValue="value" placeholder="Fournisseur" />
                <x-forms.select label="Customs Office" wire:model.defer="folder.customs_office_id"
                    :options="$customsOffices" optionLabel="label" optionValue="value" placeholder="Bureau de douane" />
                <x-forms.input label="Declaration Number" wire:model.defer="folder.declaration_number" />
                <x-forms.select label="Declaration Type" wire:model.defer="folder.declaration_type_id"
                    :options="$declarationTypes" optionLabel="label" optionValue="value" placeholder="Type de déclaration" />
                <x-forms.input label="Declarant" wire:model.defer="folder.declarant" />
                <x-forms.input label="Customs Agent" wire:model.defer="folder.customs_agent" />
                <x-forms.input label="Container Number" wire:model.defer="folder.container_number" />
                <x-forms.input label="Arrival Border Date" type="date" wire:model.defer="folder.arrival_border_date" />
                <x-forms.input label="Folder Date" type="date" wire:model.defer="folder.folder_date" />
            </div>
        @endif

        {{-- ÉTAPE 3 --}}
        @if ($step === 3)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-forms.input label="FOB Amount" type="number" wire:model.defer="folder.fob_amount" />
                <x-forms.input label="Insurance Amount" type="number" wire:model.defer="folder.insurance_amount" />
                <x-forms.input label="CIF Amount" type="number" wire:model.defer="folder.cif_amount" readonly />
                <x-forms.input label="Weight (kg)" type="number" wire:model.defer="folder.weight" />
                <x-forms.input label="TR8 Number" wire:model.defer="folder.tr8_number" />
                <x-forms.input label="TR8 Date" type="date" wire:model.defer="folder.tr8_date" />
                <x-forms.input label="T1 Number" wire:model.defer="folder.t1_number" />
                <x-forms.input label="T1 Date" type="date" wire:model.defer="folder.t1_date" />
                <x-forms.input label="IM4 Number" wire:model.defer="folder.im4_number" />
                <x-forms.input label="IM4 Date" type="date" wire:model.defer="folder.im4_date" />
                <x-forms.input label="Liquidation Number" wire:model.defer="folder.liquidation_number" />
                <x-forms.input label="Liquidation Date" type="date" wire:model.defer="folder.liquidation_date" />
                <x-forms.input label="Quitance Number" wire:model.defer="folder.quitance_number" />
                <x-forms.input label="Quitance Date" type="date" wire:model.defer="folder.quitance_date" />

                @if ($folder['dossier_type'] === \App\Enums\DossierType::AVEC->value)
                    <x-forms.select label="License" wire:model.defer="folder.license_id"
                        :options="$licenseCodes" optionLabel="label" optionValue="value" placeholder="Licence" />
                    <x-forms.select label="Bivac Code" wire:model.defer="folder.bivac_code"
                        :options="$bivacCodes" optionLabel="label" optionValue="value" placeholder="Code Bivac" />
                @endif

                <x-forms.textarea label="Description" wire:model.defer="folder.description" rows="3" />
            </div>

            {{-- BOUTON DE SOUMISSION --}}
            <div class="pt-6">
                <x-forms.button type="submit" class="bg-green-600 text-white hover:bg-green-700">
                    Enregistrer
                </x-forms.button>
            </div>
        @endif
    </form>
</div>
