<div>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <x-ui.flash-message />
        <x-ui.error-message />

        <form wire:submit.prevent="save">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Folder</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Folder Number</label>
                        <input type="text" wire:model.live="folder.folder_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.folder_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Invoice Number</label>
                        <input type="text" wire:model.live="folder.invoice_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.invoice_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Folder Date</label>
                        <input type="date" wire:model.live="folder.folder_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.folder_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Company</label>
                        <select wire:model.live="folder.company_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($companies as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.company_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Currency</label>
                        <select wire:model.live="folder.currency_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($currencies as $item)
                                <option value="{{ $item->id }}">{{ $item->code }}</option>
                            @endforeach
                        </select>
                        @error('folder.currency_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Goods Type</label>
                        <select wire:model.live="folder.goods_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($merchandiseTypes as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.goods_type') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Agency</label>
                        <input type="text" wire:model.live="folder.agency" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.agency') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pre-alert Place</label>
                        <input type="text" wire:model.live="folder.pre_alert_place" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.pre_alert_place') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Transport Mode</label>
                        <input type="text" wire:model.live="folder.transport_mode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.transport_mode') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Dossier Type</label>
                        <select wire:model.live="folder.dossier_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($dossierTypeOptions as $item)
                                <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                            @endforeach
                        </select>
                        @error('folder.dossier_type') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    @if(($folder['dossier_type'] ?? null) === 'avec')
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">License</label>
                            <select wire:model.live="folder.license_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Select --</option>
                                @foreach ($licenses as $item)
                                    <option value="{{ $item->id }}">{{ $item->license_number }}</option>
                                @endforeach
                            </select>
                            @error('folder.license_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">License Code</label>
                        <input type="text" wire:model.live="folder.license_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.license_code') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">BIVAC Code</label>
                        <input type="text" wire:model.live="folder.bivac_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.bivac_code') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr/>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Transport & Logistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Truck Number</label>
                        <input type="text" wire:model.live="folder.truck_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.truck_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Trailer Number</label>
                        <input type="text" wire:model.live="folder.trailer_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.trailer_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Transporter</label>
                        <select wire:model.live="folder.transporter_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($transporters as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.transporter_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Driver Name</label>
                        <input type="text" wire:model.live="folder.driver_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.driver_name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Driver Phone</label>
                        <input type="text" wire:model.live="folder.driver_phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.driver_phone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Driver Nationality</label>
                        <input type="text" wire:model.live="folder.driver_nationality" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.driver_nationality') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Origin</label>
                        <select wire:model.live="folder.origin_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($locations as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.origin_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Destination</label>
                        <select wire:model.live="folder.destination_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($locations as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.destination_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Supplier</label>
                        <select wire:model.live="folder.supplier_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($suppliers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.supplier_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Client</label>
                        <select wire:model.live="folder.client" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($clients as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.client') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Container Number</label>
                        <input type="text" wire:model.live="folder.container_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.container_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Weight</label>
                        <input type="number" step="any" wire:model.live="folder.weight" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.weight') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                        <input type="number" step="any" wire:model.live="folder.quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.quantity') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">FOB Amount</label>
                        <input type="number" step="0.01" wire:model.live="folder.fob_amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.fob_amount') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Insurance Amount</label>
                        <input type="number" step="0.01" wire:model.live="folder.insurance_amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.insurance_amount') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Freight Amount</label>
                        <input type="number" step="0.01" wire:model.live="folder.freight_amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.freight_amount') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">CIF Amount</label>
                        <input type="number" step="0.01" wire:model.live="folder.cif_amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.cif_amount') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Arrival Border Date</label>
                        <input type="date" wire:model.live="folder.arrival_border_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.arrival_border_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr/>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Customs & References</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Customs Office</label>
                        <select wire:model.live="folder.customs_office_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($customsOffices as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.customs_office_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Declaration Number</label>
                        <input type="text" wire:model.live="folder.declaration_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.declaration_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Declaration Type</label>
                        <select wire:model.live="folder.declaration_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select --</option>
                            @foreach ($declarationTypes as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('folder.declaration_type_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Declarant</label>
                        <input type="text" wire:model.live="folder.declarant" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.declarant') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Customs Agent</label>
                        <input type="text" wire:model.live="folder.customs_agent" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.customs_agent') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Internal Reference</label>
                        <input type="text" wire:model.live="folder.internal_reference" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.internal_reference') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Order Number</label>
                        <input type="text" wire:model.live="folder.order_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.order_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">TR8 Number</label>
                        <input type="text" wire:model.live="folder.tr8_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.tr8_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">TR8 Date</label>
                        <input type="date" wire:model.live="folder.tr8_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.tr8_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">T1 Number</label>
                        <input type="text" wire:model.live="folder.t1_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.t1_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">T1 Date</label>
                        <input type="date" wire:model.live="folder.t1_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.t1_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Formalities Office Ref</label>
                        <input type="text" wire:model.live="folder.formalities_office_reference" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.formalities_office_reference') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">IM4 Number</label>
                        <input type="text" wire:model.live="folder.im4_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.im4_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">IM4 Date</label>
                        <input type="date" wire:model.live="folder.im4_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.im4_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Liquidation Number</label>
                        <input type="text" wire:model.live="folder.liquidation_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.liquidation_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Liquidation Date</label>
                        <input type="date" wire:model.live="folder.liquidation_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.liquidation_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quitance Number</label>
                        <input type="text" wire:model.live="folder.quitance_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.quitance_number') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quitance Date</label>
                        <input type="date" wire:model.live="folder.quitance_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('folder.quitance_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea rows="4" wire:model.live="folder.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    @error('folder.description') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>

                <div class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    <button type="submit" class="w-full">Update Folder</button>
                </div>

            </div>
        </form>
    </div>

</div>
