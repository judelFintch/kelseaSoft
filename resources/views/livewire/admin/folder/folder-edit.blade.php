<div>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <x-ui.flash-message />
        <x-ui.error-message />
    
        <form wire:submit.prevent="save">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Folder</h2>
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-forms.input label="Folder Number" model="folder.folder_number" readonly />
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
                    <x-forms.select label="Customs Office" model="folder.customs_office_id" :options="$customsOffices" option-label="name" option-value="id" />
    
                    <x-forms.input label="Declaration Number" model="folder.declaration_number" />
                    <x-forms.select label="Declaration Type" model="folder.declaration_type_id" :options="$declarationTypes" option-label="name" option-value="id" />
                    <x-forms.input label="Declarant" model="folder.declarant" />
                    <x-forms.input label="Customs Agent" model="folder.customs_agent" />
    
                    <x-forms.input label="Container Number" model="folder.container_number" />
                    <x-forms.input label="Weight (kg)" model="folder.weight" type="number" />
                    <x-forms.currency label="FOB Amount" model="folder.fob_amount" />
                    <x-forms.currency label="Insurance Amount" model="folder.insurance_amount" />
    
                    <x-forms.currency label="CIF Amount" model="folder.cif_amount" />
                    <x-forms.date label="Arrival Border Date" model="folder.arrival_border_date" />
                </div>
    
                <x-forms.textarea label="Description" model="folder.description" rows="4" />
    
                <div class="flex justify-end">
                    <x-forms.button type="submit">Update Folder</x-forms.button>
                </div>
            </div>
        </form>
    </div>
    
</div>
