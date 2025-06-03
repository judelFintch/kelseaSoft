@php
    use Illuminate\Support\Str;
@endphp

<div x-data="{ step: 1 }">
    <x-ui.flash-message />
    <x-ui.error-message />

    <div class="max-w-5xl mx-auto p-6">
        <form wire:submit.prevent="saveInvoice">
            <!-- Barre de progression -->
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm font-medium text-gray-700 dark:text-white/70 mb-2">
                    <span x-text="`Étape ${step} sur 2`"></span>
                    <span x-show="step === 1">Éléments de la Déclaration</span>
                    <span x-show="step === 2">Honoraires & Total</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                    <div class="bg-brand-500 h-2 rounded-full transition-all duration-300" :style="`width: ${(step / 2) * 100}%`"></div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">🧾 Facturation du Dossier #{{ $folder->folder_number }}</h3>
                </div>

                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <!-- Étape 1 : Éléments de liquidation -->
                    <div x-show="step === 1" class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">📄 Éléments de liquidation</h4>
                        @foreach ($liquidationItems as $index => $item)
                            <div class="flex gap-3 items-center mb-2">
                                <x-forms.input model="liquidationItems.{{ $index }}.designation" placeholder="Désignation" class="w-2/3" />
                                <x-forms.currency model="liquidationItems.{{ $index }}.amount" placeholder="Montant" class="w-1/3" />
                                <button type="button" wire:click.prevent="removeLiquidationItem({{ $index }})" class="text-red-500 hover:text-red-700">🗑️</button>
                            </div>
                        @endforeach
                        <button type="button" wire:click.prevent="addLiquidationItem" class="text-sm text-blue-600 hover:underline">+ Ajouter un élément</button>
                    </div>

                    <!-- Étape 2 : Honoraires & Total -->
                    <div x-show="step === 2" class="pt-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">🏷️ Honoraires de l'entreprise</h4>
                        @foreach ($feeItems as $index => $item)
                            <div class="flex gap-3 items-center mb-2">
                                <x-forms.input model="feeItems.{{ $index }}.designation" placeholder="Désignation" class="w-2/3" />
                                <x-forms.currency model="feeItems.{{ $index }}.amount" placeholder="Montant" class="w-1/3" />
                                <button type="button" wire:click.prevent="removeFeeItem({{ $index }})" class="text-red-500 hover:text-red-700">🗑️</button>
                            </div>
                        @endforeach
                        <button type="button" wire:click.prevent="addFeeItem" class="text-sm text-blue-600 hover:underline">+ Ajouter un honoraire</button>

                        <div class="mt-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-xl shadow-sm">
                            <p class="text-sm text-gray-700 dark:text-gray-300">💸 Total liquidation : <strong>{{ number_format($totalLiquidation, 2) }} $</strong></p>
                            <p class="text-sm text-gray-700 dark:text-gray-300">💼 Total honoraires : <strong>{{ number_format($totalFees, 2) }} $</strong></p>
                            <p class="text-md font-bold text-gray-800 dark:text-white mt-2">🧮 Total général : <strong>{{ number_format($totalAmount, 2) }} $</strong></p>
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
                        <button type="button" @click="step = Math.min(2, step + 1)"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step < 2">
                            Suivant
                        </button>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                            x-show="step === 2">
                            💾 Enregistrer la Facture
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>