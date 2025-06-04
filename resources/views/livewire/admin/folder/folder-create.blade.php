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
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 1: Informations de Base</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Folder Number --}}
                <div>
                    <label for="folder_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de Dossier <span class="text-red-500">*</span></label>
                    <input type="text" id="folder_number" wire:model.defer="folder_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('folder_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Folder Date --}}
                <div>
                    <label for="folder_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date du Dossier <span class="text-red-500">*</span></label>
                    <input type="date" id="folder_date" wire:model.defer="folder_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('folder_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Arrival Border Date --}}
                <div>
                    <label for="arrival_border_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date d'Arrivée Frontière</label>
                    <input type="date" id="arrival_border_date" wire:model.defer="arrival_border_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('arrival_border_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Company (Client) --}}
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client (Société) <span class="text-red-500">*</span></label>
                    <select id="company_id" wire:model.defer="company_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un client</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Supplier --}}
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fournisseur</label>
                    <select id="supplier_id" wire:model.defer="supplier_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un fournisseur</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Internal Reference --}}
                <div>
                    <label for="internal_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Référence Interne</label>
                    <input type="text" id="internal_reference" wire:model.defer="internal_reference" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('internal_reference') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Order Number --}}
                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de Commande</label>
                    <input type="text" id="order_number" wire:model.defer="order_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('order_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Step 2: Transport & Goods Details --}}
        <div x-data="{ active: @entangle('currentStep').defer === 2 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 2: Détails Transport & Marchandises</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Truck Number --}}
                <div>
                    <label for="truck_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro Camion</label>
                    <input type="text" id="truck_number" wire:model.defer="truck_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('truck_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Trailer Number --}}
                <div>
                    <label for="trailer_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro Remorque</label>
                    <input type="text" id="trailer_number" wire:model.defer="trailer_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('trailer_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Transporter --}}
                <div>
                    <label for="transporter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transporteur <span class="text-red-500">*</span></label>
                    <select id="transporter_id" wire:model.defer="transporter_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un transporteur</option>
                        @foreach($transporters as $transporter)
                            <option value="{{ $transporter->id }}">{{ $transporter->name }}</option>
                        @endforeach
                    </select>
                    @error('transporter_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Driver Name --}}
                <div>
                    <label for="driver_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom du Chauffeur</label>
                    <input type="text" id="driver_name" wire:model.defer="driver_name" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('driver_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Driver Phone --}}
                <div>
                    <label for="driver_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Téléphone Chauffeur</label>
                    <input type="text" id="driver_phone" wire:model.defer="driver_phone" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('driver_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Driver Nationality --}}
                <div>
                    <label for="driver_nationality" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nationalité Chauffeur</label>
                    <input type="text" id="driver_nationality" wire:model.defer="driver_nationality" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('driver_nationality') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Transport Mode --}}
                <div>
                    <label for="transport_mode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mode de Transport <span class="text-red-500">*</span></label>
                    <select id="transport_mode" wire:model.defer="transport_mode" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        @foreach($transportModes as $mode)
                            <option value="{{ $mode['id'] }}">{{ $mode['name'] }}</option>
                        @endforeach
                    </select>
                    @error('transport_mode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Goods Type --}}
                <div>
                    <label for="goods_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nature Marchandise <span class="text-red-500">*</span></label>
                    <input type="text" id="goods_type" wire:model.defer="goods_type" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('goods_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Weight --}}
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Poids (kg)</label>
                    <input type="number" id="weight" wire:model.defer="weight" step="0.01" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Quantity --}}
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantité (Colis)</label>
                    <input type="number" id="quantity" wire:model.defer="quantity" step="1" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- FOB Amount --}}
                <div>
                    <label for="fob_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Montant FOB ($)</label>
                    <input type="number" id="fob_amount" wire:model.defer="fob_amount" step="0.01" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('fob_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Insurance Amount --}}
                <div>
                    <label for="insurance_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Montant Assurance ($)</label>
                    <input type="number" id="insurance_amount" wire:model.defer="insurance_amount" step="0.01" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('insurance_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- CIF Amount --}}
                <div>
                    <label for="cif_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Montant CIF ($)</label>
                    <input type="number" id="cif_amount" wire:model.defer="cif_amount" step="0.01" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('cif_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Step 3: Customs & Declaration Details --}}
        <div x-data="{ active: @entangle('currentStep').defer === 3 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 3: Détails Douane & Déclaration</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Origin --}}
                <div>
                    <label for="origin_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu d'Origine</label>
                    <select id="origin_id" wire:model.defer="origin_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un lieu</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('origin_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Destination --}}
                <div>
                    <label for="destination_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu de Destination</label>
                    <select id="destination_id" wire:model.defer="destination_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un lieu</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('destination_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Customs Office --}}
                <div>
                    <label for="customs_office_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bureau de Douane</label>
                    <select id="customs_office_id" wire:model.defer="customs_office_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un bureau</option>
                        @foreach($customsOffices as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                    </select>
                    @error('customs_office_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Declaration Number --}}
                <div>
                    <label for="declaration_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de Déclaration</label>
                    <input type="text" id="declaration_number" wire:model.defer="declaration_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('declaration_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Declaration Type --}}
                <div>
                    <label for="declaration_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de Déclaration</label>
                    <select id="declaration_type_id" wire:model.defer="declaration_type_id" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner un type</option>
                        @foreach($declarationTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('declaration_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Declarant --}}
                <div>
                    <label for="declarant" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Déclarant</label>
                    <input type="text" id="declarant" wire:model.defer="declarant" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('declarant') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Customs Agent --}}
                <div>
                    <label for="customs_agent" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agent en Douane</label>
                    <input type="text" id="customs_agent" wire:model.defer="customs_agent" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('customs_agent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Container Number --}}
                <div>
                    <label for="container_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro Conteneur</label>
                    <input type="text" id="container_number" wire:model.defer="container_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('container_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Step 4: Tracking & Document Numbers --}}
        <div x-data="{ active: @entangle('currentStep').defer === 4 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 4: Numéros de Suivi & Documents</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- License Code --}}
                <div>
                    <label for="license_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code Licence</label>
                    <input type="text" id="license_code" wire:model.defer="license_code" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('license_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- BIVAC Code --}}
                <div>
                    <label for="bivac_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code BIVAC</label>
                    <input type="text" id="bivac_code" wire:model.defer="bivac_code" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('bivac_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- TR8 Number --}}
                <div>
                    <label for="tr8_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro TR8</label>
                    <input type="text" id="tr8_number" wire:model.defer="tr8_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('tr8_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- TR8 Date --}}
                <div>
                    <label for="tr8_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date TR8</label>
                    <input type="date" id="tr8_date" wire:model.defer="tr8_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('tr8_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- T1 Number --}}
                <div>
                    <label for="t1_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro T1</label>
                    <input type="text" id="t1_number" wire:model.defer="t1_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('t1_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- T1 Date --}}
                <div>
                    <label for="t1_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date T1</label>
                    <input type="date" id="t1_date" wire:model.defer="t1_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('t1_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Formalities Office Reference --}}
                <div>
                    <label for="formalities_office_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Réf. Bureau Formalités</label>
                    <input type="text" id="formalities_office_reference" wire:model.defer="formalities_office_reference" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('formalities_office_reference') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- IM4 Number --}}
                <div>
                    <label for="im4_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro IM4</label>
                    <input type="text" id="im4_number" wire:model.defer="im4_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('im4_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- IM4 Date --}}
                <div>
                    <label for="im4_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date IM4</label>
                    <input type="date" id="im4_date" wire:model.defer="im4_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('im4_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Liquidation Number --}}
                <div>
                    <label for="liquidation_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro Liquidation</label>
                    <input type="text" id="liquidation_number" wire:model.defer="liquidation_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('liquidation_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Liquidation Date --}}
                <div>
                    <label for="liquidation_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Liquidation</label>
                    <input type="date" id="liquidation_date" wire:model.defer="liquidation_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('liquidation_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Quitance Number --}}
                <div>
                    <label for="quitance_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro Quittance</label>
                    <input type="text" id="quitance_number" wire:model.defer="quitance_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('quitance_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Quitance Date --}}
                <div>
                    <label for="quitance_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Quittance</label>
                    <input type="date" id="quitance_date" wire:model.defer="quitance_date" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100">
                    @error('quitance_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Step 5: Description --}}
        <div x-data="{ active: @entangle('currentStep').defer === 5 }" x-show="active" class="space-y-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-6 border-gray-300 dark:border-gray-600">Étape 5: Description</h3>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description / Notes</label>
                <textarea id="description" wire:model.defer="description" rows="6" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
            <div>
                @if ($currentStep > 1)
                    <button type="button" wire:click="previousStep"
                            class="px-6 py-2 text-sm font-medium tracking-wide text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Précédent
                    </button>
                @else
                    <span class="px-6 py-2">&nbsp;</span> {{-- Placeholder for spacing --}}
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
