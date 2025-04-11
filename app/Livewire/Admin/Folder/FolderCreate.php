<?php

namespace App\Livewire\Admin\Folder;
use App\Services\Company\CompanyService;

use Livewire\Component;

class FolderCreate extends Component
{



    public $clients;


    public function mount()
    {
        
        $this->clients =  CompanyService::getAllCompanies();
    }

    public function save()
    {
        $validated = $this->validate([
            'folder.folder_number'        => 'required|string|max:255|unique:folders,folder_number',
            'folder.truck_number'         => 'required|string|max:255',
            'folder.trailer_number'       => 'nullable|string|max:255',
            'folder.transporter'          => 'nullable|string|max:255',
            'folder.driver_name'          => 'nullable|string|max:255',
            'folder.driver_phone'         => 'nullable|string|max:255',
            'folder.driver_nationality'   => 'nullable|string|max:255',
            'folder.origin'               => 'nullable|string|max:255',
            'folder.destination'          => 'nullable|string|max:255',
            'folder.supplier'             => 'nullable|string|max:255',
            'folder.client'               => 'nullable|string|max:255',
            'folder.customs_office'       => 'nullable|string|max:255',
            'folder.declaration_number'   => 'nullable|string|max:255',
            'folder.declaration_type'     => 'nullable|string|max:255',
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

        $this->folder->save();

        session()->flash('success', 'Folder created successfully.');

        return redirect()->route('folder.index');
    }
    public function render()
    {
        return view('livewire.admin.folder.folder-create');
    }
}
