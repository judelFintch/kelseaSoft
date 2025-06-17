<div x-data="{ step: 1, confirmModal: false }">
    <!-- Alertes et messages -->
    <div class="max-w-5xl mx-auto px-6 mb-4 space-y-2">
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-cloak>
            @if (session()->has('success'))
                <div class="flex items-center justify-between gap-4 rounded-lg bg-green-100 border border-green-400 text-green-800 px-4 py-3">
                    <span class="text-sm font-medium">✅ {{ session('success') }}</span>
                    <button @click="show = false" class="text-green-700 hover:text-green-900 font-bold text-lg">&times;</button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="flex items-center justify-between gap-4 rounded-lg bg-red-100 border border-red-400 text-red-800 px-4 py-3">
                    <span class="text-sm font-medium">❌ {{ session('error') }}</span>
                    <button @click="show = false" class="text-red-700 hover:text-red-900 font-bold text-lg">&times;</button>
                </div>
            @endif

            @if (session()->has('info'))
                <div class="flex items-center justify-between gap-4 rounded-lg bg-blue-100 border border-blue-400 text-blue-800 px-4 py-3">
                    <span class="text-sm font-medium">ℹ️ {{ session('info') }}</span>
                    <button @click="show = false" class="text-blue-700 hover:text-blue-900 font-bold text-lg">&times;</button>
                </div>
            @endif
        </div>

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-cloak class="rounded-lg bg-red-100 border border-red-400 text-red-800 px-4 py-3">
                <div class="flex items-start justify-between">
                    <div>
                        <strong class="font-semibold">⚠️ Erreurs :</strong>
                        <ul class="list-disc list-inside mt-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-red-700 hover:text-red-900 font-bold text-lg ml-4">&times;</button>
                </div>
            </div>
        @endif
    </div>

    <!-- Formulaire -->
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
                            <x-forms.select
                                label="Entreprise cliente"
                                model="company_id"
                                :options="$companies->map(fn($c) => [$c->id, $c->name . ($c->acronym ? ' (' . $c->acronym . ')' : '')])->toArray()"
                                optionValue="0"
                                optionLabel="1"
                                placeholder="Sélectionner une entreprise"
                            />
                            <x-forms.select
                                label="BIVAC"
                                model="bivac_id"
                                :options="$bivacs->map(fn($b) => [$b->id, $b->label])->toArray()"
                                optionValue="0"
                                optionLabel="1"
                                placeholder="Sélectionner un BIVAC"
                            />
                            <x-forms.input label="License Number" model="license_number" required />
                            <x-forms.input label="License Type" model="license_type" required />
                            <x-forms.input label="License Category" model="license_category" />
                            <x-forms.select label="Currency" model="currency" :options="[['USD','USD'],['CDF','CDF'],['EUR','EUR']]" optionLabel="1" optionValue="0" placeholder="Sélectionner une devise" />
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
                            <div class="sm:col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Licence file
                                </label>
                                <input type="file" wire:model="file" class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('file')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex flex-col sm:flex-row justify-between items-center px-5 py-4 sm:px-6 sm:py-5 space-y-3 sm:space-y-0">
                    <button type="button"
                            @click="step = Math.max(1, step - 1)"
                            x-show="step > 1"
                            x-cloak
                            class="px-5 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-white/80 dark:hover:bg-gray-600 transition">
                        ← Précédent
                    </button>

                    <div class="flex items-center gap-4">
                        <button type="button"
                                @click="step = Math.min(3, step + 1)"
                                x-show="step < 3"
                                class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                            Suivant →
                        </button>

                        <button type="button"
                                x-show="step === 3"
                                x-cloak
                                @click="confirmModal = true"
                                class="px-6 py-2 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition">
                            ✅ Enregistrer la licence
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modale de confirmation -->
    <div x-show="confirmModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="confirmModal = false" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xl w-full max-w-md">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Confirmation</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Voulez-vous vraiment enregistrer cette licence ?</p>
            <div class="flex justify-end gap-4">
                <button @click="confirmModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    Annuler
                </button>
                <button @click="$wire.save(); confirmModal = false"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>
