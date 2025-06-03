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
                        <th class="px-4 py-3 text-left">Facturation</th> {{-- Nouvelle colonne --}}
                        <th class="px-4 py-3 text-left">Desc.</th>
                      
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($folders as $folder)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ route('folder.show', $folder->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-600 font-medium">
                                    {{ $folder->folder_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->truck_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->trailer_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->invoice_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->goods_type }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->agency }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->pre_alert_place }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->transport_mode }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->internal_reference }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->order_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->folder_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->transporter?->name }}</td>
                            
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->origin?->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->destination?->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->supplier?->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->company?->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->customsOffice?->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->declaration_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->declarationType?->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->declarant }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->customs_agent }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->container_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->arrival_border_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->tr8_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->tr8_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->t1_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->t1_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->formalities_office_reference }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->im4_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->im4_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->liquidation_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->liquidation_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->quitance_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ optional($folder->quitance_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->dossier_type }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->license_code }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->bivac_code }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $folder->license?->license_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap"> {{-- Nouvelle cellule pour la facturation --}}
                                @if($folder->invoice)
                                    <a href="{{ route('invoices.show', $folder->invoice->id) }}"
                                       class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full hover:bg-green-200 dark:bg-green-700 dark:text-green-100 dark:hover:bg-green-600">
                                        Facturé ({{ $folder->invoice->invoice_number ?? 'Voir' }})
                                    </a>
                                @else
                                    {{-- La route 'admin.invoices.generate.from-folder' sera créée plus tard --}}
                                    <a href="{{ route('admin.invoices.generate', ['folder_id' => $folder->id]) }}" {{-- Supposition temporaire de la route et du paramètre --}}
                                       class="px-2 py-1 text-xs bg-blue-500 text-white rounded-full hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                                        Facturer
                                    </a>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ Str::limit($folder->description, 25) }}</td>
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="46" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No folders found.</td> {{-- Ajuster colspan --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
