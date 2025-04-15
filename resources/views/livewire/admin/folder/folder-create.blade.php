<div x-data="{ step: 1 }">
    <x-ui.flash-message />
    <x-ui.error-message />

    <div class="max-w-5xl mx-auto p-6">
        <form wire:submit.prevent="save()">
            <!-- Barre de progression -->
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm font-medium text-gray-700 dark:text-white/70 mb-2">
                    <span x-text="`Étape ${step} sur 3`"></span>
                    <span x-show="step === 1">Informations sur le Dossier</span>
                    <span x-show="step === 2">Chauffeur & Logistique</span>
                    <span x-show="step === 3">Financier & Description</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                    <div class="bg-brand-500 h-2 rounded-full transition-all duration-300" :style="`width: ${(step / 3) * 100}%`"></div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Create Folder</h3>
                </div>

                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <!-- Étape 1 -->
                    <div x-show="step === 1" class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Informations sur le Dossier</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Numéro de Dossier" model="folder.folder_number" readonly />
                            <x-forms.input label="Plaque du Camion" model="folder.truck_number" />
                            <x-forms.input label="Numéro de la Remorque" model="folder.trailer_number" />
                            <x-forms.select label="Transporteur" model="folder.transporter_id" :options="$transporters" option-label="name" option-value="id" placeholder="Sélectionnez un transporteur" />
                        </div>
                    </div>

                    <!-- Étape 2 -->
                    <div x-show="step === 2" class="py-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Chauffeur & Logistique</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Nom du Chauffeur" model="folder.driver_name" />
                            <x-forms.input label="Téléphone du Chauffeur" model="folder.driver_phone" />
                            <x-forms.input label="Nationalité du Chauffeur" model="folder.driver_nationality" />
                            <x-forms.select label="Provenance" model="folder.origin_id" :options="$locations" option-label="name" option-value="id" placeholder="Sélectionnez une provenance" />
                            <x-forms.select label="Destination" model="folder.destination_id" :options="$locations" option-label="name" option-value="id" placeholder="Sélectionnez une destination" />
                            <x-forms.select label="Fournisseur" model="folder.supplier_id" :options="$suppliers" option-label="name" option-value="id" placeholder="Sélectionnez un fournisseur" />
                            <x-forms.select label="Client" model="folder.client" :options="$clients" option-label="name" option-value="id" placeholder="Sélectionnez un client" />
                            <x-forms.select label="Bureau de Douane" model="folder.customs_office_id" :options="$customsOffices" option-label="name" option-value="id" placeholder="Sélectionnez un bureau" />
                            <x-forms.input label="Numéro TR8" model="folder.declaration_number" />
                            <x-forms.select label="Type de Déclaration" model="folder.declaration_type_id" :options="$declarationTypes" option-label="name" option-value="id" placeholder="Sélectionnez un type de déclaration" />
                            <x-forms.input label="Déclarant" model="folder.declarant" />
                            <x-forms.input label="Agent de Douane" model="folder.customs_agent" />
                            <x-forms.input label="Numéro de Conteneur" model="folder.container_number" />
                        </div>
                    </div>

                    <!-- Étape 3 -->
                    <div x-show="step === 3" class="pt-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Financier & Description</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Poids" model="folder.weight" type="number" />
                            <x-forms.currency label="Montant FOB" model="folder.fob_amount" />
                            <x-forms.currency label="Montant Assurance" model="folder.insurance_amount" />
                            <x-forms.currency label="Montant CIF" model="folder.cif_amount" />
                            <x-forms.date label="Date d'Arrivée à la Frontière" model="folder.arrival_border_date" />
                            <x-forms.textarea label="Description" model="folder.description" rows="4" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center px-5 py-4 sm:px-6 sm:py-5">
                    <button type="button" @click="step = Math.max(1, step - 1)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-white/80 dark:hover:bg-gray-600"
                        x-show="step > 1">
                        Previous
                    </button>

                    <div class="flex items-center gap-3 ml-auto">
                        <button type="button" @click="step = Math.min(3, step + 1)"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step < 3">
                            Next
                        </button>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step === 3">
                            Save Folder
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>