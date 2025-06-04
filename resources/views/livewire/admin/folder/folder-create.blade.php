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
        {{-- Step 1: Basic Information --}}
        <div x-data="{ active: @entangle('currentStep').defer === 1 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 1: Informations de Base</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.input label="Numéro de Dossier" model="folder_number" required />
                <x-forms.input label="Date du Dossier" model="folder_date" type="date" required />
                <x-forms.input label="Date d'Arrivée Frontière" model="arrival_border_date" type="date" />
                <x-forms.select label="Client (Société)" model="company_id" :options="$companies" optionLabel="name" optionValue="id" required />
                <x-forms.select label="Fournisseur" model="supplier_id" :options="$suppliers" optionLabel="name" optionValue="id" placeholder="Sélectionner un fournisseur" />
                <x-forms.input label="Référence Interne" model="internal_reference" />
                <x-forms.input label="Numéro de Commande" model="order_number" />
            </div>
        </div>

        {{-- Step 2: Transport & Goods Details --}}
        <div x-data="{ active: @entangle('currentStep').defer === 2 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 2: Détails Transport & Marchandises</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.input label="Numéro Camion" model="truck_number" />
                <x-forms.input label="Numéro Remorque" model="trailer_number" />
                <x-forms.select label="Transporteur" model="transporter_id" :options="$transporters" optionLabel="name" optionValue="id" required />
                <x-forms.input label="Nom du Chauffeur" model="driver_name" />
                <x-forms.input label="Téléphone Chauffeur" model="driver_phone" />
                <x-forms.input label="Nationalité Chauffeur" model="driver_nationality" />
                <x-forms.select label="Mode de Transport" model="transport_mode" :options="[['id' => 'Route', 'name' => 'Route'], ['id' => 'Air', 'name' => 'Air'], ['id' => 'Mer', 'name' => 'Mer']]" optionLabel="name" optionValue="id" />
                <x-forms.input label="Nature Marchandise" model="goods_type" required />
                <x-forms.input label="Poids (kg)" model="weight" type="number" step="0.01" />
                <x-forms.input label="Quantité (Colis)" model="quantity" type="number" step="1" />
                <x-forms.input label="Montant FOB ($)" model="fob_amount" type="number" step="0.01" />
                <x-forms.input label="Montant Assurance ($)" model="insurance_amount" type="number" step="0.01" />
                <x-forms.input label="Montant CIF ($)" model="cif_amount" type="number" step="0.01" />
            </div>
        </div>

        {{-- Step 3: Customs & Declaration Details --}}
        <div x-data="{ active: @entangle('currentStep').defer === 3 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 3: Détails Douane & Déclaration</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.select label="Lieu d'Origine" model="origin_id" :options="$locations" optionLabel="name" optionValue="id" placeholder="Sélectionner origine" />
                <x-forms.select label="Lieu de Destination" model="destination_id" :options="$locations" optionLabel="name" optionValue="id" placeholder="Sélectionner destination" />
                <x-forms.select label="Bureau de Douane" model="customs_office_id" :options="$customsOffices" optionLabel="name" optionValue="id" placeholder="Sélectionner bureau" />
                <x-forms.input label="Numéro de Déclaration" model="declaration_number" />
                <x-forms.select label="Type de Déclaration" model="declaration_type_id" :options="$declarationTypes" optionLabel="name" optionValue="id" placeholder="Sélectionner type" />
                <x-forms.input label="Déclarant" model="declarant" />
                <x-forms.input label="Agent en Douane" model="customs_agent" />
                <x-forms.input label="Numéro Conteneur" model="container_number" />
            </div>
        </div>

        {{-- Step 4: Tracking & Document Numbers --}}
        <div x-data="{ active: @entangle('currentStep').defer === 4 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 4: Numéros de Suivi & Documents</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.input label="Code Licence" model="license_code" />
                <x-forms.input label="Code BIVAC" model="bivac_code" />
                <x-forms.input label="Numéro TR8" model="tr8_number" />
                <x-forms.input label="Date TR8" model="tr8_date" type="date" />
                <x-forms.input label="Numéro T1" model="t1_number" />
                <x-forms.input label="Date T1" model="t1_date" type="date" />
                <x-forms.input label="Réf. Bureau Formalités" model="formalities_office_reference" />
                <x-forms.input label="Numéro IM4" model="im4_number" />
                <x-forms.input label="Date IM4" model="im4_date" type="date" />
                <x-forms.input label="Numéro Liquidation" model="liquidation_number" />
                <x-forms.input label="Date Liquidation" model="liquidation_date" type="date" />
                <x-forms.input label="Numéro Quittance" model="quitance_number" />
                <x-forms.input label="Date Quittance" model="quitance_date" type="date" />
            </div>
        </div>

        {{-- Step 5: Description & Review --}}
        <div x-data="{ active: @entangle('currentStep').defer === 5 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 border-gray-300 dark:border-gray-600">Étape 5: Description</h3>
            <div>
                <x-forms.textarea label="Description / Notes" model="description" rows="4" />
            </div>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
            <div>
                @if ($currentStep > 1)
                    <button type="button" wire:click="previousStep"
                            class="px-6 py-2 text-sm font-medium tracking-wide text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Précédent
                    </button>
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
                        Enregistrer le Dossier
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>
