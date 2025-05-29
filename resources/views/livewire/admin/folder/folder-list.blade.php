<div>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="overflow-x-auto border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Folder</th>
                        <th class="px-4 py-3 text-left">Truck</th>
                        <th class="px-4 py-3 text-left">Trailer</th>
                        <th class="px-4 py-3 text-left">Invoice</th>
                        <th class="px-4 py-3 text-left">Goods</th>
                        <th class="px-4 py-3 text-left">Agency</th>
                        <th class="px-4 py-3 text-left">Pre-alert</th>
                        <th class="px-4 py-3 text-left">Mode</th>
                        <th class="px-4 py-3 text-left">Internal Ref</th>
                        <th class="px-4 py-3 text-left">Order</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Transporter</th>
                        <th class="px-4 py-3 text-left">Origin</th>
                        <th class="px-4 py-3 text-left">Dest.</th>
                        <th class="px-4 py-3 text-left">Supplier</th>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-left">Customs Office</th>
                        <th class="px-4 py-3 text-left">Decl. Number</th>
                        <th class="px-4 py-3 text-left">Decl. Type</th>
                        <th class="px-4 py-3 text-left">Declarant</th>
                        <th class="px-4 py-3 text-left">Agent</th>
                        <th class="px-4 py-3 text-left">Container</th>
                        <th class="px-4 py-3 text-left">Border Date</th>
                        <th class="px-4 py-3 text-left">TR8</th>
                        <th class="px-4 py-3 text-left">TR8 Date</th>
                        <th class="px-4 py-3 text-left">T1</th>
                        <th class="px-4 py-3 text-left">T1 Date</th>
                        <th class="px-4 py-3 text-left">Formalities</th>
                        <th class="px-4 py-3 text-left">IM4</th>
                        <th class="px-4 py-3 text-left">IM4 Date</th>
                        <th class="px-4 py-3 text-left">Liquidation</th>
                        <th class="px-4 py-3 text-left">Liquidation Date</th>
                        <th class="px-4 py-3 text-left">Quitance</th>
                        <th class="px-4 py-3 text-left">Quitance Date</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">License Code</th>
                        <th class="px-4 py-3 text-left">Bivac</th>
                        <th class="px-4 py-3 text-left">License</th>
                        <th class="px-4 py-3 text-left">Desc.</th>
                      
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($folders as $folder)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $folder->folder_number }}</td>
                            <td class="px-4 py-3">{{ $folder->truck_number }}</td>
                            <td class="px-4 py-3">{{ $folder->trailer_number }}</td>
                            <td class="px-4 py-3">{{ $folder->invoice_number }}</td>
                            <td class="px-4 py-3">{{ $folder->goods_type }}</td>
                            <td class="px-4 py-3">{{ $folder->agency }}</td>
                            <td class="px-4 py-3">{{ $folder->pre_alert_place }}</td>
                            <td class="px-4 py-3">{{ $folder->transport_mode }}</td>
                            <td class="px-4 py-3">{{ $folder->internal_reference }}</td>
                            <td class="px-4 py-3">{{ $folder->order_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->folder_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->transporter?->name }}</td>
                            
                            <td class="px-4 py-3">{{ $folder->origin?->name }}</td>
                            <td class="px-4 py-3">{{ $folder->destination?->name }}</td>
                            <td class="px-4 py-3">{{ $folder->supplier?->name }}</td>
                            <td class="px-4 py-3">{{ $folder->company?->name }}</td>
                            <td class="px-4 py-3">{{ $folder->customsOffice?->name }}</td>
                            <td class="px-4 py-3">{{ $folder->declaration_number }}</td>
                            <td class="px-4 py-3">{{ $folder->declarationType?->name }}</td>
                            <td class="px-4 py-3">{{ $folder->declarant }}</td>
                            <td class="px-4 py-3">{{ $folder->customs_agent }}</td>
                            <td class="px-4 py-3">{{ $folder->container_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->arrival_border_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->tr8_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->tr8_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->t1_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->t1_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->formalities_office_reference }}</td>
                            <td class="px-4 py-3">{{ $folder->im4_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->im4_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->liquidation_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->liquidation_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->quitance_number }}</td>
                            <td class="px-4 py-3">{{ optional($folder->quitance_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $folder->dossier_type }}</td>
                            <td class="px-4 py-3">{{ $folder->license_code }}</td>
                            <td class="px-4 py-3">{{ $folder->bivac_code }}</td>
                            <td class="px-4 py-3">{{ $folder->license?->license_number }}</td>
                            <td class="px-4 py-3">{{ Str::limit($folder->description, 25) }}</td>
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="45" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No folders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
