<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Enums\DossierType;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Transporter;
use App\Services\Company\CompanyService;
use App\Services\Folder\FolderService;
use App\Services\Licence\LicenceService;
use Illuminate\Validation\Rules\Enum;

class FolderCreate extends Component
{
    public $step = 1;

    public $clients = [];
    public $transporters = [];
    public $suppliers = [];
    public $locations = [];
    public $customsOffices = [];
    public $declarationTypes = [];
    public $optionsSelect = [];
    public $licenseCodes = [];
    public $bivacCodes = [];

    public $folder = [];

    public function mount()
    {
        $this->clients = CompanyService::getAllCompanies()->map(fn($client) => [
            'label' => $client->name,
            'value' => $client->id
        ])->toArray();

        $this->transporters = Transporter::all()->map(fn($t) => [
            'label' => $t->name,
            'value' => $t->id
        ])->toArray();

        $this->suppliers = Supplier::all()->map(fn($s) => [
            'label' => $s->name,
            'value' => $s->id
        ])->toArray();

        $this->locations = Location::all()->map(fn($l) => [
            'label' => $l->name,
            'value' => $l->id
        ])->toArray();

        $this->customsOffices = CustomsOffice::all()->map(fn($o) => [
            'label' => $o->name,
            'value' => $o->id
        ])->toArray();

        $this->declarationTypes = DeclarationType::all()->map(fn($d) => [
            'label' => $d->name,
            'value' => $d->id
        ])->toArray();

        $this->optionsSelect = DossierType::options();

        $this->licenseCodes = \App\Models\Licence::all()->map(fn($lic) => [
            'label' => $lic->license_number,
            'value' => $lic->id,
        ])->toArray();

        $this->bivacCodes = [
            ['label' => 'BIVAC-01', 'value' => 'BIVAC-01'],
            ['label' => 'BIVAC-02', 'value' => 'BIVAC-02'],
        ];

        $this->folder['folder_number'] = FolderService::generateFolderNumber();
        $this->folder['dossier_type'] = DossierType::SANS->value;
    }

    public function updated($property)
    {
        if (in_array($property, ['folder.fob_amount', 'folder.insurance_amount'])) {
            $fob = floatval($this->folder['fob_amount'] ?? 0);
            $insurance = floatval($this->folder['insurance_amount'] ?? 0);
            $this->folder['cif_amount'] = $fob + $insurance;
        }
    }

    public function nextStep()
    {
        if ($this->step < 3) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function save()
    {
        $rules = [
            'folder.folder_number' => 'required|string|max:255|unique:folders,folder_number',
            'folder.truck_number' => 'required|string|max:255',
            'folder.trailer_number' => 'nullable|string|max:255',
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
            'folder.folder_date' => 'nullable|date',
            'folder.tr8_number' => 'nullable|string|max:255',
            'folder.tr8_date' => 'nullable|date',
            'folder.t1_number' => 'nullable|string|max:255',
            'folder.t1_date' => 'nullable|date',
            'folder.im4_number' => 'nullable|string|max:255',
            'folder.im4_date' => 'nullable|date',
            'folder.liquidation_number' => 'nullable|string|max:255',
            'folder.liquidation_date' => 'nullable|date',
            'folder.quitance_number' => 'nullable|string|max:255',
            'folder.quitance_date' => 'nullable|date',
            'folder.dossier_type' => ['required', new Enum(DossierType::class)],
            'folder.description' => 'nullable|string|max:1000',
        ];

        if ($this->folder['dossier_type'] === DossierType::AVEC->value) {
            $rules['folder.license_id'] = 'required|exists:licences,id';
            $rules['folder.bivac_code'] = 'required|string|max:255';
        }

        $validated = $this->validate($rules);

        $folder = FolderService::storeFolder([
            ...$validated['folder'],
            'license_id' => $this->folder['license_id'] ?? null,
        ]);

        if ($this->folder['dossier_type'] === DossierType::AVEC->value) {
            $license = LicenceService::getLicenseById($this->folder['license_id']);

            if (!$license) {
                session()->flash('error', '🚫 Licence introuvable.');
                return;
            }

            $success = app(LicenceService::class)->attachFolderToLicense($folder, $license);

            if (!$success) {
                $folder->delete();
                session()->flash('error', '❌ Échec : la licence ne permet pas ce rattachement.');
                return;
            }
        }

        $this->reset('folder');
        $this->folder['folder_number'] = FolderService::generateFolderNumber();
        $this->folder['dossier_type'] = DossierType::SANS->value;
        $this->step = 1;

        session()->flash('message', '✅ Dossier créé avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-create');
    }
}
