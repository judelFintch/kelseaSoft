<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\Transporter;
use App\Models\Location;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Licence;
use App\Enums\DossierType;
use App\Services\Folder\FolderService;
use Illuminate\Validation\Rule;

class FolderCreate extends Component
{
    public int $currentStep = 1;
    public int $totalSteps = 3;

    // Étape 1
    public $folder_number;
    public $folder_date;
    public $company_id;
    public $dossier_type = DossierType::SANS->value;
    public $invoice_number;
    public $supplier_id;
    public $goods_type;
    public $description;

    // Étape 2
    public $transporter_id;
    public $truck_number;
    public $trailer_number;
    public $transport_mode = 'Route';
    public $origin_id;
    public $destination_id;
    public $arrival_border_date;
    public $weight;
    public $quantity;
    public $fob_amount;
    public $insurance_amount;
    public $cif_amount;

    // Étape 3
    public $customs_office_id;
    public $declaration_number;
    public $declaration_type_id;
    public $internal_reference;
    public $order_number;

    // Étape 4 - Licence
    public $license_id;
    public $license_code;

    // Liste des licences disponibles pour la société
    public $licenses = [];

    // Pour les select
    public $companies = [];
    public $suppliers = [];
    public $transporters = [];
    public $locations = [];
    public $customsOffices = [];
    public $declarationTypes = [];
    public $transportModes = [];

    public function mount()
    {
        $this->folder_date = now()->toDateString();
        $this->companies = Company::orderBy('name')->get(['id', 'name', 'acronym']);
        $this->suppliers = Supplier::orderBy('name')->get(['id', 'name']);
        $this->transporters = Transporter::orderBy('name')->get(['id', 'name']);
        $this->locations = Location::orderBy('name')->get(['id', 'name']);
        $this->customsOffices = CustomsOffice::orderBy('name')->get(['id', 'name']);
        $this->declarationTypes = DeclarationType::orderBy('name')->get(['id', 'name']);
        $this->transportModes = [
            ['id' => 'Route', 'name' => 'Route'],
            ['id' => 'Air', 'name' => 'Air'],
            ['id' => 'Mer', 'name' => 'Mer'],
            ['id' => 'Multimodal', 'name' => 'Multimodal'],
        ];

        $this->licenses = [];

        $this->generateFolderNumber('GEN'); // par défaut
    }

    public function updatedCompanyId($value)
    {
        $company = Company::find($value);
        if ($company) {
            $this->generateFolderNumber($company->acronym ?? 'GEN');
            if ($this->dossier_type === DossierType::AVEC->value) {
                $this->loadCompanyLicenses();
            }
        }
    }

    public function updatedDossierType($value)
    {
        if ($value === DossierType::AVEC->value) {
            $this->totalSteps = 4;
            $this->loadCompanyLicenses();
        } else {
            $this->totalSteps = 3;
            $this->license_id = null;
            $this->license_code = null;
        }
    }

    public function updatedLicenseId($value)
    {
        if ($value) {
            $license = Licence::find($value);
            if ($license) {
                $this->license_code = $license->license_number;
            }
        }
    }

    protected function loadCompanyLicenses()
    {
        $this->licenses = [];
        if ($this->company_id) {
            $this->licenses = Licence::where('company_id', $this->company_id)
                ->get(['id', 'license_number'])
                ->toArray();
        }
    }

    public function generateFolderNumber(string $acronym)
    {
        $year = now()->format('y');
        $systemAcronym = 'MDB';
        do {
            $random = random_int(1000, 9999);
            $number = "{$year}/{$systemAcronym}/{$acronym}/{$random}";
        } while (Folder::where('folder_number', $number)->exists());

        $this->folder_number = $number;
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
        $rules = $this->getStepRules($step);
        $this->validate($rules);
    }

    protected function getStepRules(int $step): array
    {
        return match ($step) {
            1 => [
                'company_id' => 'required|exists:companies,id',
                'dossier_type' => 'required|in:sans,avec',
                'folder_number' => ['required', 'string', Rule::unique('folders', 'folder_number')->withoutTrashed()],
                'invoice_number' => 'required|string|max:255',
                'folder_date' => 'required|date',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'goods_type' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ],
            2 => [
                'transporter_id' => 'required|exists:transporters,id',
                'truck_number' => 'nullable|string|max:255',
                'trailer_number' => 'nullable|string|max:255',
                'transport_mode' => 'required|in:Route,Air,Mer,Multimodal',
                'origin_id' => 'nullable|exists:locations,id',
                'destination_id' => 'nullable|exists:locations,id',
                'arrival_border_date' => 'nullable|date|after_or_equal:folder_date',
                'weight' => 'nullable|numeric|min:0',
            ],
            3 => [
                'customs_office_id' => 'nullable|exists:customs_offices,id',
                'declaration_number' => 'nullable|string|max:255',
                'declaration_type_id' => 'nullable|exists:declaration_types,id',
                'internal_reference' => 'nullable|string|max:255',
                'order_number' => 'nullable|string|max:255',
            ],
            4 => [
                'license_id' => 'required|exists:licences,id',
                'license_code' => 'required|string|max:255',
            ],
            default => [],
        };
    }

    public function save()
    {
        $rules = array_merge(
            $this->getStepRules(1),
            $this->getStepRules(2),
            $this->getStepRules(3)
        );

        if ($this->dossier_type === DossierType::AVEC->value) {
            $rules = array_merge($rules, $this->getStepRules(4));
        }

        $rules['folder_number'] = ['required', 'string', Rule::unique('folders', 'folder_number')->withoutTrashed()];

        $this->validate($rules);

       

        try {
            FolderService::storeFolder([
                'folder_number' => $this->folder_number,
                'invoice_number' => $this->invoice_number,
                'quantity' => $this->quantity,
                'fob_amount' => $this->fob_amount,
                'insurance_amount' => $this->insurance_amount,
                'cif_amount' => $this->cif_amount,
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
                'dossier_type' => $this->dossier_type,
                'license_id' => $this->dossier_type === DossierType::AVEC->value ? $this->license_id : null,
                'license_code' => $this->dossier_type === DossierType::AVEC->value ? $this->license_code : null,
            ]);

            session()->flash('success', 'Dossier créé avec succès.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return;
        }

        $this->resetExcept('companies', 'suppliers', 'transporters', 'locations', 'customsOffices', 'declarationTypes', 'transportModes', 'totalSteps');
        $this->licenses = [];
        $this->dossier_type = DossierType::SANS->value;
        $this->currentStep = 1;
        $this->folder_date = now()->toDateString();
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-create');
    }
}
