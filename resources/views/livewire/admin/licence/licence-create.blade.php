<div x-data="{ step: 1 }">
    <x-ui.flash-message />
    <x-ui.error-message />

    <div class="max-w-5xl mx-auto p-6">
        <form wire:submit.prevent="save" novalidate>
            <!-- Barre de progression -->
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm font-medium text-gray-700 dark:text-white/70 mb-2">
                    <span x-text="`Étape ${step} sur 3`"></span>
                    <span x-show="step === 1">Informations de base</span>
                    <span x-show="step === 2">Capacités et plafonds</span>
                    <span x-show="step === 3">Financier</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                    <div class="bg-brand-500 h-2 rounded-full transition-all duration-300"
                        :style="`width: ${(step / 3) * 100}%`"></div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Create License</h3>
                </div>

                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <!-- Étape 1 -->
                    <div x-show="step === 1" x-cloak class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Informations de base</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="License Number" model="license_number" required />
                            <x-forms.input label="License Type" model="license_type" required />
                            <x-forms.input label="License Category" model="license_category" />
                            <x-forms.select label="Currency" model="currency">
                                <option value="USD">USD</option>
                                <option value="CDF">CDF</option>
                                <option value="EUR">EUR</option>
                            </x-forms.select>
                        </div>
                    </div>

                    <!-- Étape 2 -->
                    <div x-show="step === 2" x-cloak class="py-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Capacités et plafonds</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Nombre maximum de dossiers" type="number" model="max_folders" />
                            <x-forms.input label="Poids autorisé total (kg)" type="number" model="initial_weight" />
                            <x-forms.input label="Montant FOB autorisé" type="number" model="initial_fob_amount" />
                            <x-forms.input label="Quantité totale autorisée" type="number" model="quantity_total" />
                        </div>
                    </div>

                    <!-- Étape 3 -->
                    <div x-show="step === 3" x-cloak class="pt-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Financier</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Fret" type="number" model="freight_amount" />
                            <x-forms.input label="Assurance" type="number" model="insurance_amount" />
                            <x-forms.input label="Autres frais" type="number" model="other_fees" />
                            <x-forms.input label="Montant CIF" type="number" model="cif_amount" />
                            <x-forms.input label="Mode de paiement" model="payment_mode" />
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between items-center px-5 py-4 sm:px-6 sm:py-5">
                    <button type="button" @click="step = Math.max(1, step - 1)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-white/80 dark:hover:bg-gray-600"
                        x-show="step > 1">
                        Précédent
                    </button>

                    <div class="flex items-center gap-3 ml-auto">
                        <button type="button" @click="step = Math.min(3, step + 1)"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step < 3">
                            Suivant
                        </button>

                        <button type="submit"
                            x-show="step === 3"
                            x-cloak
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">
                            Enregistrer la licence
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
