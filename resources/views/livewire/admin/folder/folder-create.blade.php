<div class="w-full max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-xl space-y-6 dark:bg-gray-800">

    <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">Créer un Nouveau Dossier</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm dark:bg-green-700 dark:text-green-100" role="alert">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Progress Bar --}}
    <div class="mb-8">
        <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full">
            <div class="h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full transition-all duration-300 ease-in-out" style="width: {{ ($currentStep / $totalSteps) * 100 }}%;"></div>
        </div>
        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mt-2">Étape {{ $currentStep }} sur {{ $totalSteps }}</p>
    </div>

    <form wire:submit.prevent="save" class="space-y-8">
        {{-- Step 1: Basic Information (Simplified for Debugging) --}}
        <div x-data="{ active: @entangle('currentStep').defer === 1 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 1: Informations de Base (Test de débogage)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="test_folder_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Numéro de Dossier (Test):</label>
                    <input type="text" id="test_folder_number" wire:model="folder_number" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
                    @error('folder_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="test_folder_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date du Dossier (Test):</label>
                    <input type="date" id="test_folder_date" wire:model="folder_date" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
                    @error('folder_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <p class="text-gray-700 dark:text-gray-200 mt-4">Valeur de currentStep (depuis Blade): {{ $currentStep }}</p>
            <div x-data="{ alpineCurrentStep: @entangle('currentStep').defer }">
                <p class="text-gray-700 dark:text-gray-200">Valeur de currentStep (via Alpine @entangle): <span x-text="alpineCurrentStep"></span></p>
            </div>
            <p class="text-gray-700 dark:text-gray-200">Si vous voyez ceci, la section de l'étape 1 est au moins partiellement rendue par Blade.</p>
        </div>

        {{-- Steps 2, 3, 4, 5 are temporarily commented out for debugging --}}
        <!--
        {{-- Step 2: Transport & Goods Details --}}
        <div x-data="{ active: @entangle('currentStep').defer === 2 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 2: (Commentée)</h3>
        </div>

        {{-- Step 3: Customs & Declaration Details --}}
        <div x-data="{ active: @entangle('currentStep').defer === 3 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 3: (Commentée)</h3>
        </div>

        {{-- Step 4: Tracking & Document Numbers --}}
        <div x-data="{ active: @entangle('currentStep').defer === 4 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 4: (Commentée)</h3>
        </div>

        {{-- Step 5: Description & Review --}}
        <div x-data="{ active: @entangle('currentStep').defer === 5 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 5: (Commentée)</h3>
        </div>
        -->

        {{-- Navigation Buttons (Kept for testing step changes) --}}
        <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
            <div>
                @if ($currentStep > 1)
                    <button type="button" wire:click="previousStep"
                            class="px-6 py-2 text-sm font-medium tracking-wide text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Précédent
                    </button>
                @else
                    {{-- Placeholder to keep spacing --}}
                    <span class="px-6 py-2">&nbsp;</span>
                @endif
            </div>
            <div>
                @if ($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep"
                            class="px-6 py-2 text-sm font-medium tracking-wide text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-500 focus:ring-opacity-50 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        Suivant
                    </button>
                @elseif ($currentStep === $totalSteps)
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium tracking-wide text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50 dark:bg-green-500 dark:hover:bg-green-400">
                        Enregistrer le Dossier (Désactivé pour le test)
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>
