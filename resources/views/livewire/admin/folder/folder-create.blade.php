<div class="w-full max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-xl space-y-6 dark:bg-gray-800">

    <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">Créer un Nouveau Dossier</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm dark:bg-green-700 dark:text-green-100" role="alert">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm dark:bg-red-700 dark:text-red-100" role="alert">
            <p class="font-bold">Erreur</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Barre de progression --}}
    <div class="mb-8">
        <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full">
            <div class="h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full transition-all duration-300 ease-in-out" style="width: {{ ($currentStep / $totalSteps) * 100 }}%;"></div>
        </div>
        <p class="text-sm text-center text-gray-600 dark:text-gray-400 mt-2">Étape {{ $currentStep }} sur {{ $totalSteps }}</p>
    </div>

    <form wire:submit.prevent="save" class="space-y-8">

        {{-- ÉTAPE 1 --}}
        @if ($currentStep === 1)
        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm animate-fadeIn">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 1: Informations de Base</h3>
            <div class="space-y-4">
                <x-forms.select label="Entreprise" model="company_id" :options="$companies" optionLabel="name" optionValue="id" required placeholder="Sélectionner une entreprise" />
                <x-forms.input label="Numéro de Dossier" model="folder_number" required />
                <x-forms.input label="Numéro de la facture" model="invoice_number" required />
                <x-forms.input label="Date du Dossier" model="folder_date" type="date" required />
                <x-forms.select label="Devise" model="currency_id" :options="$currencies" optionLabel="code" optionValue="id" required />
                <x-forms.select label="Fournisseur" model="supplier_id" :options="$suppliers" optionLabel="name" optionValue="id" placeholder="Sélectionner un fournisseur" />
                <x-forms.select label="Nature Marchandise" model="goods_type" :options="$merchandiseTypes" optionLabel="name" optionValue="name" required placeholder="Sélectionner un type de marchandise" />
                <x-forms.textarea label="Description Générale" model="description" rows="3" />
                <x-forms.select label="Type de Dossier" model="dossier_type" :options="$dossierTypeOptions" optionLabel="label" optionValue="value" required />
                @if($dossier_type === 'avec')
                    <x-forms.select label="Licence" model="license_id" :options="$licenses" optionLabel="license_number" optionValue="id" placeholder="Sélectionner une licence" />
                @endif
            </div>
        </div>
        @endif

        {{-- ÉTAPE 2 --}}
        @if ($currentStep === 2)
        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm animate-fadeIn">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 2: Transport & Logistique</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.select label="Transporteur" model="transporter_id" :options="$transporters" optionLabel="name" optionValue="id" required placeholder="Sélectionner un transporteur" />
                <x-forms.input label="Numéro Camion" model="truck_number" />
                <x-forms.input label="Numéro Remorque" model="trailer_number" />
                <x-forms.select label="Mode de Transport" model="transport_mode" :options="$transportModes" optionLabel="name" optionValue="id" required />
                <x-forms.select label="Lieu d'Origine" model="origin_id" :options="$locations" optionLabel="name" optionValue="id" placeholder="Sélectionner origine" />
                <x-forms.select label="Lieu de Destination" model="destination_id" :options="$locations" optionLabel="name" optionValue="id" placeholder="Sélectionner destination" />
                <x-forms.input label="Date d'Arrivée Frontière" model="arrival_border_date" type="date" />
                <x-forms.input label="Poids (kg)" model="weight" type="number" step="0.01" />
                <x-forms.input label="Quantité de Marchandise" model="quantity" type="number" step="0.01" />
                <x-forms.input label="Montant FOB" model="fob_amount" type="number" step="0.01" />
                <x-forms.input label="Montant Assurance" model="insurance_amount" type="number" step="0.01" />
                <x-forms.input label="Fret" model="freight_amount" type="number" step="0.01" />
                <x-forms.input label="Montant CIF" model="cif_amount" type="number" step="0.01" disabled />
            </div>
        </div>
        @endif

        {{-- ÉTAPE 3 --}}
        @if ($currentStep === 3)
        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm animate-fadeIn">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 3: Douane & Références</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.select label="Bureau de Douane" model="customs_office_id" :options="$customsOffices" optionLabel="name" optionValue="id" placeholder="Sélectionner bureau" />
                <x-forms.input label="Numéro de Déclaration" model="declaration_number" />
                <x-forms.select label="Type de Déclaration" model="declaration_type_id" :options="$declarationTypes" optionLabel="name" optionValue="id" placeholder="Sélectionner type" />
                <x-forms.input label="Référence Interne" model="internal_reference" />
                <x-forms.input label="Numéro de Commande" model="order_number" />
            </div>
        </div>
        @endif

        {{-- Boutons de Navigation --}}
        <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
            <div>
                @if ($currentStep > 1)
                <button type="button" wire:click="previousStep"
                    class="px-6 py-2 text-sm font-medium tracking-wide text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                    Précédent
                </button>
                @else
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
                    Enregistrer le Dossier
                </button>
                @endif
            </div>
        </div>
    </form>

    <style>
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>
