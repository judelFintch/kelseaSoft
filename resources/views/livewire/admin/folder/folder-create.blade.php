<div x-data="{ step: 1 }">
    <x-ui.flash-message />
    <x-ui.error-message />
    <div class="max-w-5xl mx-auto p-6">
        <form wire:submit.prevent="submitForm()">
            <!-- Barre de progression dynamique -->
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm font-medium text-gray-700 dark:text-white/70 mb-2">
                    <span x-text="`Step ${step} of 3`"></span>
                    <span x-show="step === 1">Folder Information</span>
                    <span x-show="step === 2">Driver & Logistics</span>
                    <span x-show="step === 3">Financial & Description</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                    <div class="bg-brand-500 h-2 rounded-full transition-all duration-300"
                        :style="`width: ${(step / 3) * 100}%`"></div>
                </div>
            </div>

            <!-- Card -->
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <!-- Header -->
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Create Folder</h3>
                </div>

                <!-- Body -->
                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <!-- Étape 1 -->
                    <div x-show="step === 1" class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Folder Details</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Folder Number" model="folder.folder_number" />
                            <x-forms.input label="Truck Number" model="folder.truck_number" />
                            <x-forms.input label="Trailer Number" model="folder.trailer_number" />
                            <x-forms.input label="Transporter" model="folder.transporter" />
                        </div>
                    </div>

                    <!-- Étape 2 -->
                    <div x-show="step === 2" class="py-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Driver & Logistics</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Driver Name" model="folder.driver_name" />
                            <x-forms.input label="Driver Phone" model="folder.driver_phone" />
                            <x-forms.input label="Driver Nationality" model="folder.driver_nationality" />
                            <x-forms.input label="Origin" model="folder.origin" />
                            <x-forms.input label="Destination" model="folder.destination" />
                            <x-forms.input label="Supplier" model="folder.supplier" />
                            <x-forms.input label="Client" model="folder.client" />
                            <x-forms.input label="Customs Office" model="folder.customs_office" />
                            <x-forms.input label="Declaration Number" model="folder.declaration_number" />
                            <x-forms.input label="Declaration Type" model="folder.declaration_type" />
                            <x-forms.input label="Declarant" model="folder.declarant" />
                            <x-forms.input label="Customs Agent" model="folder.customs_agent" />
                            <x-forms.input label="Container Number" model="folder.container_number" />
                        </div>
                    </div>

                    <!-- Étape 3 -->
                    <div x-show="step === 3" class="pt-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Financial & Description</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Weight" model="folder.weight" type="number" />
                            <x-forms.input label="FOB Amount" model="folder.fob_amount" type="number" />
                            <x-forms.input label="Insurance Amount" model="folder.insurance_amount" type="number" />
                            <x-forms.input label="CIF Amount" model="folder.cif_amount" type="number" />
                            <x-forms.input label="Arrival at Border" model="folder.arrival_border_date" type="date" />
                            <x-forms.textarea label="Description" model="folder.description" rows="4" />
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center px-5 py-4 sm:px-6 sm:py-5">
                    <button type="button" @click="step = Math.max(1, step - 1)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-white/80 dark:hover:bg-gray-600"
                        x-show="step > 1">Previous</button>

                    <div class="flex items-center gap-3 ml-auto">
                        <button type="button" @click="step = Math.min(3, step + 1)"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step < 3">Next</button>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step === 3">Save Folder</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
