<div>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <x-ui.flash-message />
        <x-ui.error-message />

        <form wire:submit.prevent="save">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Folder</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-forms.input label="Folder Number" model="folder.folder_number" />
                    <x-forms.input label="Invoice Number" model="folder.invoice_number" />
                    <x-forms.date label="Folder Date" model="folder.folder_date" />
                    <x-forms.select label="Company" model="folder.company_id" :options="$companies" option-label="name" option-value="id" />
                    <x-forms.select label="Currency" model="folder.currency_id" :options="$currencies" option-label="code" option-value="id" />
                    <x-forms.select label="Goods Type" model="folder.goods_type" :options="$merchandiseTypes" option-label="name" option-value="name" />
                    <x-forms.input label="Agency" model="folder.agency" />
                    <x-forms.input label="Pre-alert Place" model="folder.pre_alert_place" />
                    <x-forms.input label="Transport Mode" model="folder.transport_mode" />
                    <x-forms.select label="Dossier Type" model="folder.dossier_type" :options="$dossierTypeOptions" option-label="label" option-value="value" />
                    @if(($folder['dossier_type'] ?? null) === 'avec')
                        <x-forms.select label="License" model="folder.license_id" :options="$licenses" option-label="license_number" option-value="id" />
                    @endif
                    <x-forms.input label="License Code" model="folder.license_code" />
                    <x-forms.input label="BIVAC Code" model="folder.bivac_code" />
                </div>

                <hr/>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Transport & Logistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-forms.input label="Truck Number" model="folder.truck_number" />
                    <x-forms.input label="Trailer Number" model="folder.trailer_number" />
                    <x-forms.select label="Transporter" model="folder.transporter_id" :options="$transporters" option-label="name" option-value="id" />
                    <x-forms.input label="Driver Name" model="folder.driver_name" />
                    <x-forms.input label="Driver Phone" model="folder.driver_phone" />
                    <x-forms.input label="Driver Nationality" model="folder.driver_nationality" />
                    <x-forms.select label="Origin" model="folder.origin_id" :options="$locations" option-label="name" option-value="id" />
                    <x-forms.select label="Destination" model="folder.destination_id" :options="$locations" option-label="name" option-value="id" />
                    <x-forms.select label="Supplier" model="folder.supplier_id" :options="$suppliers" option-label="name" option-value="id" />
                    <x-forms.select label="Client" model="folder.client" :options="$clients" option-label="name" option-value="id" />
                    <x-forms.input label="Container Number" model="folder.container_number" />
                    <x-forms.input label="Weight" model="folder.weight" type="number" />
                    <x-forms.input label="Quantity" model="folder.quantity" type="number" />
                    <x-forms.currency label="FOB Amount" model="folder.fob_amount" />
                    <x-forms.currency label="Insurance Amount" model="folder.insurance_amount" />
                    <x-forms.currency label="Freight Amount" model="folder.freight_amount" />
                    <x-forms.currency label="CIF Amount" model="folder.cif_amount" />
                    <x-forms.date label="Arrival Border Date" model="folder.arrival_border_date" />
                </div>

                <hr/>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Customs & References</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-forms.select label="Customs Office" model="folder.customs_office_id" :options="$customsOffices" option-label="name" option-value="id" />
                    <x-forms.input label="Declaration Number" model="folder.declaration_number" />
                    <x-forms.select label="Declaration Type" model="folder.declaration_type_id" :options="$declarationTypes" option-label="name" option-value="id" />
                    <x-forms.input label="Declarant" model="folder.declarant" />
                    <x-forms.input label="Customs Agent" model="folder.customs_agent" />
                    <x-forms.input label="Internal Reference" model="folder.internal_reference" />
                    <x-forms.input label="Order Number" model="folder.order_number" />
                    <x-forms.input label="TR8 Number" model="folder.tr8_number" />
                    <x-forms.date label="TR8 Date" model="folder.tr8_date" />
                    <x-forms.input label="T1 Number" model="folder.t1_number" />
                    <x-forms.date label="T1 Date" model="folder.t1_date" />
                    <x-forms.input label="Formalities Office Ref" model="folder.formalities_office_reference" />
                    <x-forms.input label="IM4 Number" model="folder.im4_number" />
                    <x-forms.date label="IM4 Date" model="folder.im4_date" />
                    <x-forms.input label="Liquidation Number" model="folder.liquidation_number" />
                    <x-forms.date label="Liquidation Date" model="folder.liquidation_date" />
                    <x-forms.input label="Quitance Number" model="folder.quitance_number" />
                    <x-forms.date label="Quitance Date" model="folder.quitance_date" />
                </div>

                <x-forms.textarea label="Description" model="folder.description" rows="4" />

                <div class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    <x-forms.button type="submit">Update Folder</x-forms.button>
                </div>

            </div>
        </form>
    </div>

</div>
