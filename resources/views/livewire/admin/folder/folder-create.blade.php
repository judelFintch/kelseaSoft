<div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
        <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white sticky top-0 z-10">
            <tr>
                <th>#</th>
                <th>Folder Number</th>
                <th>Truck</th>
                <th>Trailer</th>
                <th>Invoice</th>
                <th>Goods Type</th>
                <th>Agency</th>
                <th>Pre-alert</th>
                <th>Transport Mode</th>
                <th>Internal Ref</th>
                <th>Order</th>
                <th>Folder Date</th>
                <th>Transporter</th>
                <th>Driver Name</th>
                <th>Driver Phone</th>
                <th>Driver Nationality</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Supplier</th>
                <th>Client</th>
                <th>Customs Office</th>
                <th>Declaration Number</th>
                <th>Declaration Type</th>
                <th>Declarant</th>
                <th>Customs Agent</th>
                <th>Container</th>
                <th>Border Date</th>
                <th>TR8</th>
                <th>TR8 Date</th>
                <th>T1</th>
                <th>T1 Date</th>
                <th>Formalities Ref</th>
                <th>IM4</th>
                <th>IM4 Date</th>
                <th>Liquidation</th>
                <th>Liquidation Date</th>
                <th>Quitance</th>
                <th>Quitance Date</th>
                <th>Dossier Type</th>
                <th>License Code</th>
                <th>Bivac Code</th>
                <th>License</th>
                <th>Description</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($folders as $folder)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $folder->folder_number }}</td>
                    <td>{{ $folder->truck_number }}</td>
                    <td>{{ $folder->trailer_number }}</td>
                    <td>{{ $folder->invoice_number }}</td>
                    <td>{{ $folder->goods_type }}</td>
                    <td>{{ $folder->agency }}</td>
                    <td>{{ $folder->pre_alert_place }}</td>
                    <td>{{ $folder->transport_mode }}</td>
                    <td>{{ $folder->internal_reference }}</td>
                    <td>{{ $folder->order_number }}</td>
                    <td>{{ optional($folder->folder_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->transporter?->name }}</td>
                    <td>{{ $folder->driver_name }}</td>
                    <td>{{ $folder->driver_phone }}</td>
                    <td>{{ $folder->driver_nationality }}</td>
                    <td>{{ $folder->origin?->name }}</td>
                    <td>{{ $folder->destination?->name }}</td>
                    <td>{{ $folder->supplier?->name }}</td>
                    <td>{{ $folder->company?->name }}</td>
                    <td>{{ $folder->customsOffice?->name }}</td>
                    <td>{{ $folder->declaration_number }}</td>
                    <td>{{ $folder->declarationType?->name }}</td>
                    <td>{{ $folder->declarant }}</td>
                    <td>{{ $folder->customs_agent }}</td>
                    <td>{{ $folder->container_number }}</td>
                    <td>{{ optional($folder->arrival_border_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->tr8_number }}</td>
                    <td>{{ optional($folder->tr8_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->t1_number }}</td>
                    <td>{{ optional($folder->t1_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->formalities_office_reference }}</td>
                    <td>{{ $folder->im4_number }}</td>
                    <td>{{ optional($folder->im4_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->liquidation_number }}</td>
                    <td>{{ optional($folder->liquidation_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->quitance_number }}</td>
                    <td>{{ optional($folder->quitance_date)->format('Y-m-d') }}</td>
                    <td>{{ $folder->dossier_type }}</td>
                    <td>{{ $folder->license_code }}</td>
                    <td>{{ $folder->bivac_code }}</td>
                    <td>{{ $folder->license?->license_number }}</td>
                    <td>{{ Str::limit($folder->description, 30) }}</td>
                    <td>{{ $folder->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="44" class="text-center py-6 text-gray-500">No folders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
