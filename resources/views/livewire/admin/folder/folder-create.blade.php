<div>
    <x-ui.flash-message />
    <x-ui.error-message />
    <div class="max-w-5xl mx-auto p-6">
        <form wire:submit.prevent="submitForm()">
            <div class="rounded-2xl top-6 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Create Folder</h3>
                </div>

                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <div class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Folder Information</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Each field below corresponds to the validated attributes -->

                            @foreach ([
                                'folder_number' => 'Folder Number',
                                'truck_number' => 'Truck Number',
                                'trailer_number' => 'Trailer Number',
                                'transporter' => 'Transporter',
                                'driver_name' => 'Driver Name',
                                'driver_phone' => 'Driver Phone',
                                'driver_nationality' => 'Driver Nationality',
                                'origin' => 'Origin',
                                'destination' => 'Destination',
                                'supplier' => 'Supplier',
                                'client' => 'Client',
                                'customs_office' => 'Customs Office',
                                'declaration_number' => 'Declaration Number',
                                'declaration_type' => 'Declaration Type',
                                'declarant' => 'Declarant',
                                'customs_agent' => 'Customs Agent',
                                'container_number' => 'Container Number',
                                'weight' => 'Weight (KG)',
                                'fob_amount' => 'FOB Amount',
                                'insurance_amount' => 'Insurance Amount',
                                'cif_amount' => 'CIF Amount',
                                'arrival_border_date' => 'Arrival Border Date',
                            ] as $field => $label)
                                <div>
                                    <label for="{{ $field }}"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ $label }}
                                    </label>
                                    <input 
                                        @if (str_contains($field, 'date')) type="date" 
                                        @elseif (in_array($field, ['weight', 'fob_amount', 'insurance_amount', 'cif_amount'])) type="number" step="0.01"
                                        @else type="text" 
                                        @endif
                                        id="{{ $field }}"
                                        wire:model.defer="folder.{{ $field }}"
                                        placeholder="Enter {{ strtolower($label) }}"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    @error("folder.$field")
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach

                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="description"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Description
                                </label>
                                <textarea id="description" rows="4" wire:model.defer="folder.description"
                                    placeholder="Enter folder description"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                                @error('folder.description')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                        Save Folder
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
