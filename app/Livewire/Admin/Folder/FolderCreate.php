<?php

namespace App\Livewire\Admin\Folder;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\Transporter;
use App\Models\Location;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Folder;
use Livewire\Component;
use Illuminate\Validation\Rule;

class FolderCreate extends Component
{
    public int $currentStep = 1;
    public int $totalSteps = 3; // Simplified to 3 steps for now

    // Step 1: Core Information
    public $folder_number = '';
    public $folder_date = '';
    public $company_id = null;    // Client
    public $supplier_id = null;
    public $goods_type = '';      // Nature of goods (was 'product' in Invoice)
    public $description = '';     // General description

    // Step 2: Transport & Logistics
    public $transporter_id = null;
    public $truck_number = '';
    public $trailer_number = '';
    public $transport_mode = 'Route';
    public $origin_id = null;
    public $destination_id = null;
    public $arrival_border_date = '';
    public $weight = null;        // kg

    // Step 3: Customs & References
    public $customs_office_id = null;
    public $declaration_number = '';
    public $declaration_type_id = null;
    public $internal_reference = '';
    public $order_number = '';
    // We can add more financial fields like fob_amount etc. here if needed,
    // similar to GenerateInvoice step 1, or keep it simpler for Folder creation.

    // Data for dropdowns
    public $companies = [];
    public $suppliers = [];
    public $transporters = [];
    public $locations = [];
    public $customsOffices = [];
    public $declarationTypes = [];
    public $transportModes = [
        ['id' => 'Route', 'name' => 'Route'],
        ['id' => 'Air', 'name' => 'Air'],
        ['id' => 'Mer', 'name' => 'Mer'],
    ];

    public function mount()
    {
        $this->folder_date = now()->toDateString();
        $this->companies = Company::orderBy('name')->get(['id', 'name']);
        $this->suppliers = Supplier::orderBy('name')->get(['id', 'name']);
        $this->transporters = Transporter::orderBy('name')->get(['id', 'name']);
        $this->locations = Location::orderBy('name')->get(['id', 'name']);
        $this->customsOffices = CustomsOffice::orderBy('name')->get(['id', 'name']);
        $this->declarationTypes = DeclarationType::orderBy('name')->get(['id', 'name']);
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

    protected function getStepRules(int $step): array
    {
        $rules = [];
        switch ($step) {
            case 1:
                $rules = [
                    'folder_number' => ['required', 'string', 'max:255', Rule::unique('folders', 'folder_number')->withoutTrashed()],
                    'folder_date' => 'required|date',
                    'company_id' => 'required|exists:companies,id',
                    'supplier_id' => 'nullable|exists:suppliers,id',
                    'goods_type' => 'required|string|max:255',
                    'description' => 'nullable|string|max:1000',
                ];
                break;
            case 2:
                $rules = [
                    'transporter_id' => 'required|exists:transporters,id',
                    'truck_number' => 'nullable|string|max:255',
                    'trailer_number' => 'nullable|string|max:255',
                    'transport_mode' => 'required|string|in:Route,Air,Mer',
                    'origin_id' => 'nullable|exists:locations,id',
                    'destination_id' => 'nullable|exists:locations,id',
                    'arrival_border_date' => 'nullable|date|after_or_equal:folder_date',
                    'weight' => 'nullable|numeric|min:0',
                ];
                break;
            case 3:
                $rules = [
                    'customs_office_id' => 'nullable|exists:customs_offices,id',
                    'declaration_number' => 'nullable|string|max:255',
                    'declaration_type_id' => 'nullable|exists:declaration_types,id',
                    'internal_reference' => 'nullable|string|max:255',
                    'order_number' => 'nullable|string|max:255',
                ];
                break;
        }
        return $rules;
    }

    public function validateStep(int $step)
    {
        $rules = $this->getStepRules($step);
        if (!empty($rules)) {
            $this->validate($rules);
        }
    }

    public function save()
    {
        $allRules = [];
        for ($i = 1; $i <= $this->totalSteps; $i++) {
            $allRules = array_merge($allRules, $this->getStepRules($i));
        }
        // Ensure unique folder_number check is strict on save
        $allRules['folder_number'] = ['required', 'string', 'max:255', Rule::unique('folders', 'folder_number')->withoutTrashed()];

        // Consolidate all properties to be saved
        $this->validate($allRules); // Validate all data at once

        // Collect all public properties that are actual folder fields
        // This is safer than just $validatedData if some properties are not meant for the DB
        $folderData = [
            'folder_number' => $this->folder_number,
            'folder_date' => $this->folder_date,
            'company_id' => $this->company_id,
            'supplier_id' => $this->supplier_id,
            'goods_type' => $this->goods_type,
            'description' => $this->description,
            'transporter_id' => $this->transporter_id,
            'truck_number' => $this->truck_number,
            'trailer_number' => $this->trailer_number,
            'transport_mode' => $this->transport_mode,
            'origin_id' => $this->origin_id,
            'destination_id' => $this->destination_id,
            'arrival_border_date' => $this->arrival_border_date,
            'weight' => $this->weight,
            'customs_office_id' => $this->customs_office_id,
            'declaration_number' => $this->declaration_number,
            'declaration_type_id' => $this->declaration_type_id,
            'internal_reference' => $this->internal_reference,
            'order_number' => $this->order_number,
            // Add any other fields from the properties list that should be saved to the Folder model
            // For example, if you re-add driver_name, etc. list them here.
        ];

        Folder::create($folderData);

        session()->flash('success', 'Dossier créé avec succès.');
        $this->resetExcept('companies', 'suppliers', 'transporters', 'locations', 'customsOffices', 'declarationTypes', 'transportModes', 'totalSteps');
        $this->mount(); // Re-initialize folder_date and potentially other defaults
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-create')
                ->layout('components.layouts.app');
    }
}
