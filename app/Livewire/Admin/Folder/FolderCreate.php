<?php

namespace App\Livewire\Admin\Folder;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\Transporter;
use App\Models\Location; // For Origin/Destination
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Folder;
use Livewire\Component;

class FolderCreate extends Component
{
    // Properties for multi-step form
    public int $currentStep = 1;
    public int $totalSteps = 5; // Define total steps

    // Step 1: Basic Information
    public $folder_number = '';
    public $folder_date = '';
    public $arrival_border_date = '';
    public $company_id = null; // Client
    public $supplier_id = null;
    public $internal_reference = '';
    public $order_number = '';

    // Step 2: Transport & Goods Details
    public $truck_number = '';
    public $trailer_number = '';
    public $transporter_id = null;
    public $driver_name = '';
    public $driver_phone = '';
    public $driver_nationality = '';
    public $transport_mode = ''; // e.g., Route, Air, Mer
    public $goods_type = ''; // Nature of goods
    public $weight = null; // kg
    public $quantity = null; // e.g., number of packages
    public $fob_amount = null;
    public $insurance_amount = null;
    public $cif_amount = null; // Calculated or input

    // Step 3: Customs & Declaration Details
    public $origin_id = null; // Origin location
    public $destination_id = null; // Destination location
    public $customs_office_id = null;
    public $declaration_number = '';
    public $declaration_type_id = null;
    public $declarant = ''; // Name of declarant
    public $customs_agent = ''; // Name of customs agent
    public $container_number = ''; // If applicable

    // Step 4: Tracking & Document Numbers
    public $license_code = ''; // e.g., Import license
    public $bivac_code = '';
    public $tr8_number = '';
    public $tr8_date = '';
    public $t1_number = '';
    public $t1_date = '';
    public $formalities_office_reference = '';
    public $im4_number = '';
    public $im4_date = '';
    public $liquidation_number = '';
    public $liquidation_date = '';
    public $quitance_number = '';
    public $quitance_date = '';

    // Step 5: Description
    public $description = '';

    // Data for dropdowns
    public $companies = [];
    public $suppliers = [];
    public $transporters = [];
    public $locations = [];
    public $customsOffices = [];
    public $declarationTypes = [];

    public function mount()
    {
        $this->folder_date = now()->toDateString();
        // Load data for dropdowns
        $this->companies = Company::all(['id', 'name']);
        $this->suppliers = Supplier::all(['id', 'name']);
        $this->transporters = Transporter::all(['id', 'name']);
        $this->locations = Location::all(['id', 'name']); // For origin & destination
        $this->customsOffices = CustomsOffice::all(['id', 'name']);
        $this->declarationTypes = DeclarationType::all(['id', 'name']);
    }

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateStep(int $step)
    {
        // Add step-specific validation rules here
        $rules = [];
        switch ($step) {
            case 1:
                $rules = [
                    'folder_number' => 'required|string|unique:folders,folder_number',
                    'folder_date' => 'required|date',
                    'arrival_border_date' => 'nullable|date|after_or_equal:folder_date',
                    'company_id' => 'required|exists:companies,id',
                    'supplier_id' => 'nullable|exists:suppliers,id',
                ];
                break;
            case 2:
                $rules = [
                    'truck_number' => 'nullable|string',
                    'transporter_id' => 'required|exists:transporters,id',
                    'goods_type' => 'required|string',
                    'weight' => 'nullable|numeric|min:0',
                    'fob_amount' => 'nullable|numeric|min:0',
                ];
                break;
            // Add more cases for other steps
        }
        $this->validate($rules);
    }

    public function save()
    {
        // Validate all fields before saving
        $this->validate([
            // Step 1
            'folder_number' => 'required|string|unique:folders,folder_number',
            'folder_date' => 'required|date',
            'arrival_border_date' => 'nullable|date|after_or_equal:folder_date',
            'company_id' => 'required|exists:companies,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'internal_reference' => 'nullable|string|max:255',
            'order_number' => 'nullable|string|max:255',

            // Step 2
            'truck_number' => 'nullable|string|max:255',
            'trailer_number' => 'nullable|string|max:255',
            'transporter_id' => 'required|exists:transporters,id',
            'driver_name' => 'nullable|string|max:255',
            'driver_phone' => 'nullable|string|max:255',
            'driver_nationality' => 'nullable|string|max:255',
            'transport_mode' => 'nullable|string|max:255',
            'goods_type' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'fob_amount' => 'nullable|numeric|min:0',
            'insurance_amount' => 'nullable|numeric|min:0',
            'cif_amount' => 'nullable|numeric|min:0',

            // Step 3
            'origin_id' => 'nullable|exists:locations,id',
            'destination_id' => 'nullable|exists:locations,id',
            'customs_office_id' => 'nullable|exists:customs_offices,id',
            'declaration_number' => 'nullable|string|max:255',
            'declaration_type_id' => 'nullable|exists:declaration_types,id',
            'declarant' => 'nullable|string|max:255',
            'customs_agent' => 'nullable|string|max:255',
            'container_number' => 'nullable|string|max:255',

            // Step 4
            'license_code' => 'nullable|string|max:255',
            'bivac_code' => 'nullable|string|max:255',
            'tr8_number' => 'nullable|string|max:255',
            'tr8_date' => 'nullable|date',
            't1_number' => 'nullable|string|max:255',
            't1_date' => 'nullable|date',
            'formalities_office_reference' => 'nullable|string|max:255',
            'im4_number' => 'nullable|string|max:255',
            'im4_date' => 'nullable|date',
            'liquidation_number' => 'nullable|string|max:255',
            'liquidation_date' => 'nullable|date',
            'quitance_number' => 'nullable|string|max:255',
            'quitance_date' => 'nullable|date',

            // Step 5
            'description' => 'nullable|string',
        ]);

        Folder::create([
            'folder_number' => $this->folder_number,
            'folder_date' => $this->folder_date,
            'arrival_border_date' => $this->arrival_border_date,
            'company_id' => $this->company_id,
            'supplier_id' => $this->supplier_id,
            'internal_reference' => $this->internal_reference,
            'order_number' => $this->order_number,
            'truck_number' => $this->truck_number,
            'trailer_number' => $this->trailer_number,
            'transporter_id' => $this->transporter_id,
            'driver_name' => $this->driver_name,
            'driver_phone' => $this->driver_phone,
            'driver_nationality' => $this->driver_nationality,
            'transport_mode' => $this->transport_mode,
            'goods_type' => $this->goods_type,
            'weight' => $this->weight,
            'quantity' => $this->quantity,
            'fob_amount' => $this->fob_amount,
            'insurance_amount' => $this->insurance_amount,
            'cif_amount' => $this->cif_amount,
            'origin_id' => $this->origin_id,
            'destination_id' => $this->destination_id,
            'customs_office_id' => $this->customs_office_id,
            'declaration_number' => $this->declaration_number,
            'declaration_type_id' => $this->declaration_type_id,
            'declarant' => $this->declarant,
            'customs_agent' => $this->customs_agent,
            'container_number' => $this->container_number,
            'license_code' => $this->license_code,
            'bivac_code' => $this->bivac_code,
            'tr8_number' => $this->tr8_number,
            'tr8_date' => $this->tr8_date,
            't1_number' => $this->t1_number,
            't1_date' => $this->t1_date,
            'formalities_office_reference' => $this->formalities_office_reference,
            'im4_number' => $this->im4_number,
            'im4_date' => $this->im4_date,
            'liquidation_number' => $this->liquidation_number,
            'liquidation_date' => $this->liquidation_date,
            'quitance_number' => $this->quitance_number,
            'quitance_date' => $this->quitance_date,
            'description' => $this->description,
            // Add any other fields that need to be saved
        ]);

        session()->flash('success', 'Dossier créé avec succès.');
        // Could also redirect: return redirect()->route('admin.folders.index');
        $this->reset(); // Reset form fields
        $this->mount(); // Reload initial data if needed
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-create');
    }
}
