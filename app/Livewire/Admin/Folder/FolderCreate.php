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
use Illuminate\Validation\Rule;

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
    public $transport_mode = 'Route'; // Default value
    public $goods_type = '';
    public $weight = null;
    public $quantity = null;
    public $fob_amount = null;
    public $insurance_amount = null;
    public $cif_amount = null;

    // Step 3: Customs & Declaration Details
    public $origin_id = null;
    public $destination_id = null;
    public $customs_office_id = null;
    public $declaration_number = '';
    public $declaration_type_id = null;
    public $declarant = '';
    public $customs_agent = '';
    public $container_number = '';

    // Step 4: Tracking & Document Numbers
    public $license_code = '';
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
                    'arrival_border_date' => 'nullable|date|after_or_equal:folder_date',
                    'company_id' => 'required|exists:companies,id',
                    'supplier_id' => 'nullable|exists:suppliers,id',
                    'internal_reference' => 'nullable|string|max:255',
                    'order_number' => 'nullable|string|max:255',
                ];
                break;
            case 2:
                $rules = [
                    'truck_number' => 'nullable|string|max:255',
                    'trailer_number' => 'nullable|string|max:255',
                    'transporter_id' => 'required|exists:transporters,id',
                    'driver_name' => 'nullable|string|max:255',
                    'driver_phone' => 'nullable|string|max:255',
                    'driver_nationality' => 'nullable|string|max:255',
                    'transport_mode' => 'required|string|in:Route,Air,Mer',
                    'goods_type' => 'required|string|max:255',
                    'weight' => 'nullable|numeric|min:0',
                    'quantity' => 'nullable|integer|min:0',
                    'fob_amount' => 'nullable|numeric|min:0',
                    'insurance_amount' => 'nullable|numeric|min:0',
                    'cif_amount' => 'nullable|numeric|min:0',
                ];
                break;
            case 3:
                $rules = [
                    'origin_id' => 'nullable|exists:locations,id',
                    'destination_id' => 'nullable|exists:locations,id',
                    'customs_office_id' => 'nullable|exists:customs_offices,id',
                    'declaration_number' => 'nullable|string|max:255',
                    'declaration_type_id' => 'nullable|exists:declaration_types,id',
                    'declarant' => 'nullable|string|max:255',
                    'customs_agent' => 'nullable|string|max:255',
                    'container_number' => 'nullable|string|max:255',
                ];
                break;
            case 4:
                $rules = [
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
                ];
                break;
            case 5:
                $rules = [
                    'description' => 'nullable|string',
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

        $validatedData = $this->validate($allRules);

        Folder::create($validatedData);

        session()->flash('success', 'Dossier créé avec succès.');
        $this->reset();
        $this->mount();
        $this->currentStep = 1; // Reset to first step
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-create')
                    ->layout('components.layouts.app'); // Assuming your main layout is app.blade.php
    }
}
