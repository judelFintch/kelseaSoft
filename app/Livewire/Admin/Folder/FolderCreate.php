<?php

namespace App\Livewire\Admin\Folder;

use App\Enums\DossierType;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Transporter;
use App\Services\Company\CompanyService;
use App\Services\Folder\FolderService;
use App\Services\Licence\LicenceService;
use Livewire\Component;
use Illuminate\Validation\Rules\Enum;

class FolderCreate extends Component
{
    public $clients;
    public $transporters;
    public $suppliers;
    public $locations;
    public $customsOffices;
    public $declarationTypes;

    public $folder;

    public $optionsSelect;
    public $licenseCodes = [];
    public $bivacCodes = [];

    public function mount()
    {
        $this->clients = CompanyService::getAllCompanies();
        $this->transporters = Transporter::all();
        $this->suppliers = Supplier::all();
        $this->locations = Location::all();
        $this->customsOffices = CustomsOffice::all();
        $this->declarationTypes = DeclarationType::all();



        $this->folder = [
            'folder_number' => FolderService::generateFolderNumber(),
            'dossier_type' => DossierType::SANS->value,
        ];

        $this->optionsSelect = DossierType::options();

        $this->licenseCodes = collect(LicenceService::getAllLicenses())
            ->map(fn($license) => [
                'label' => $license['license_number'],
                'value' => $license['id'],
            ])
            ->toArray();

        $this->bivacCodes = [
            ['label' => 'BIVAC-01', 'value' => 'BIVAC-01'],
            ['label' => 'BIVAC-02', 'value' => 'BIVAC-02'],
        ];
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['folder.fob_amount', 'folder.insurance_amount'])) {
            $fob = floatval($this->folder['fob_amount'] ?? 0);
            $insurance = floatval($this->folder['insurance_amount'] ?? 0);
            $this->folder['cif_amount'] = $fob + $insurance;
        }
    }

    public function save()
    {
        $rules = [
            'folder.folder_number' => 'required|string|max:255|unique:folders,folder_number',
            'folder.truck_number' => 'required|string|max:255',
            'folder.trailer_number' => 'nullable|string|max:255',
            'folder.invoice_number' => 'nullable|string|max:255',
            'folder.transporter_id' => 'nullable|exists:transporters,id',
            'folder.driver_name' => 'nullable|string|max:255',
            'folder.driver_phone' => 'nullable|string|max:255',
            'folder.driver_nationality' => 'nullable|string|max:255',
            'folder.origin_id' => 'nullable|exists:locations,id',
            'folder.destination_id' => 'nullable|exists:locations,id',
            'folder.supplier_id' => 'nullable|exists:suppliers,id',
            'folder.client' => 'nullable|string|max:255',
            'folder.customs_office_id' => 'nullable|exists:customs_offices,id',
            'folder.declaration_number' => 'nullable|string|max:255',
            'folder.declaration_type_id' => 'nullable|exists:declaration_types,id',
            'folder.declarant' => 'nullable|string|max:255',
            'folder.customs_agent' => 'nullable|string|max:255',
            'folder.container_number' => 'nullable|string|max:255',
            'folder.weight' => 'nullable|numeric',
            'folder.fob_amount' => 'nullable|numeric',
            'folder.insurance_amount' => 'nullable|numeric',
            'folder.cif_amount' => 'nullable|numeric',
            'folder.arrival_border_date' => 'nullable|date',
            'folder.description' => 'nullable|string|max:1000',
            'folder.dossier_type' => ['required', new Enum(DossierType::class)],
            'folder.quantity' => 'nullable|numeric',
        ];

        if ($this->folder['dossier_type'] === DossierType::AVEC->value) {
            $rules['folder.license_code'] = 'required|string|max:255';
            $rules['folder.bivac_code'] = 'required|string|max:255';
        }

        $validated = $this->validate($rules);

        $folder = FolderService::storeFolder($validated['folder']);

        if ($this->folder['dossier_type'] === DossierType::AVEC->value) {
            $license = LicenceService::getLicenseById($this->folder['license_code']);

            if (!$license) {
                session()->flash('error', '🚫 Licence introuvable.');
                return;
            }

            $success = app(LicenceService::class)->attachFolderToLicense($folder, $license);

            if (!$success) {
                $folder->delete();
                session()->flash('error', '❌ Échec : la licence ne permet pas ce rattachement (poids, FOB ou quantité insuffisants).');
                return;
            }
        }

        $this->reset('folder');
        $this->folder['folder_number'] = FolderService::generateFolderNumber();
        $this->folder['dossier_type'] = DossierType::SANS->value;

        session()->flash('message', '✅ Dossier créé avec succès et licence mise à jour.');
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-create');
    }
}
