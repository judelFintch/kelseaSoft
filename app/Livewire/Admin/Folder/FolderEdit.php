<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;
use App\Models\Transporter;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Services\Company\CompanyService;
use App\Services\Folder\FolderService;


class FolderEdit extends Component
{
    public Folder $folderModel;
    public $folder;

    public $clients;
    public $transporters;
    public $suppliers;
    public $locations;
    public $customsOffices;
    public $declarationTypes;

    public function mount(Folder $folder)
    {
        $this->folderModel = $folder;
        $this->folder = $folder->toArray();

        $this->clients = CompanyService::getAllCompanies();
        $this->transporters = Transporter::all();
        $this->suppliers = Supplier::all();
        $this->locations = Location::all();
        $this->customsOffices = CustomsOffice::all();
        $this->declarationTypes = DeclarationType::all();
    }

    public function save()
    {
        $validated = $this->validate([
            'folder.folder_number'        => 'required|string|max:255|unique:folders,folder_number,' . $this->folderModel->id,
            'folder.truck_number'         => 'required|string|max:255',
            'folder.trailer_number'       => 'nullable|string|max:255',
            'folder.transporter_id'       => 'nullable|exists:transporters,id',
            'folder.driver_name'          => 'nullable|string|max:255',
            'folder.driver_phone'         => 'nullable|string|max:255',
            'folder.driver_nationality'   => 'nullable|string|max:255',
            'folder.origin_id'            => 'nullable|exists:locations,id',
            'folder.destination_id'       => 'nullable|exists:locations,id',
            'folder.supplier_id'          => 'nullable|exists:suppliers,id',
            'folder.client'               => 'nullable|string|max:255',
            'folder.customs_office_id'    => 'nullable|exists:customs_offices,id',
            'folder.declaration_number'   => 'nullable|string|max:255',
            'folder.declaration_type_id'  => 'nullable|exists:declaration_types,id',
            'folder.declarant'            => 'nullable|string|max:255',
            'folder.customs_agent'        => 'nullable|string|max:255',
            'folder.container_number'     => 'nullable|string|max:255',
            'folder.weight'               => 'nullable|numeric',
            'folder.fob_amount'           => 'nullable|numeric',
            'folder.insurance_amount'     => 'nullable|numeric',
            'folder.cif_amount'           => 'nullable|numeric',
            'folder.arrival_border_date'  => 'nullable|date',
            'folder.description'          => 'nullable|string|max:1000',
        ]);

        FolderService::updateFolder($this->folderModel, $validated['folder']);

        session()->flash('message', 'Folder updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-edit');
    }
}
