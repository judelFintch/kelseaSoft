<?php

namespace App\Livewire\Admin\Folder;

use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Folder;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Transporter;
use App\Models\Company;
use App\Models\Currency;
use App\Models\MerchandiseType;
use App\Models\Licence;
use App\Enums\DossierType;
use App\Services\Company\CompanyService;
use App\Services\Folder\FolderService;
use Livewire\Component;

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

    public $companies;

    public $currencies;

    public $merchandiseTypes;

    public $licenses;

    public $dossierTypeOptions;

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

        $this->companies = Company::notDeleted()->orderBy('name')->get(['id', 'name']);
        $this->currencies = Currency::orderBy('code')->get(['id', 'code']);
        $this->merchandiseTypes = MerchandiseType::orderBy('name')->get(['id', 'name']);
        $this->licenses = Licence::orderBy('license_number')->get(['id', 'license_number']);
        $this->dossierTypeOptions = DossierType::options();
    }

    protected function rules(): array
    {
        return [
            'folder.folder_number' => 'required|string|max:255|unique:folders,folder_number,'.$this->folderModel->id,
            'folder.invoice_number' => 'nullable|string|max:255',
            'folder.company_id' => 'nullable|exists:companies,id',
            'folder.currency_id' => 'nullable|exists:currencies,id',
            'folder.folder_date' => 'nullable|date',
            'folder.goods_type' => 'nullable|string|max:255',
            'folder.agency' => 'nullable|string|max:255',
            'folder.pre_alert_place' => 'nullable|string|max:255',
            'folder.transport_mode' => 'nullable|string|max:255',
            'folder.dossier_type' => 'nullable|in:'.DossierType::SANS->value.','.DossierType::AVEC->value,
            'folder.license_id' => 'nullable|exists:licences,id',
            'folder.license_code' => 'nullable|string|max:255',
            'folder.bivac_code' => 'nullable|string|max:255',
            'folder.truck_number' => 'nullable|string|max:255',
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
            'folder.quantity' => 'nullable|numeric',
            'folder.fob_amount' => 'nullable|numeric',
            'folder.insurance_amount' => 'nullable|numeric',
            'folder.freight_amount' => 'nullable|numeric',
            'folder.cif_amount' => 'nullable|numeric',
            'folder.arrival_border_date' => 'nullable|date',
            'folder.internal_reference' => 'nullable|string|max:255',
            'folder.order_number' => 'nullable|string|max:255',
            'folder.tr8_number' => 'nullable|string|max:255',
            'folder.tr8_date' => 'nullable|date',
            'folder.t1_number' => 'nullable|string|max:255',
            'folder.t1_date' => 'nullable|date',
            'folder.formalities_office_reference' => 'nullable|string|max:255',
            'folder.im4_number' => 'nullable|string|max:255',
            'folder.im4_date' => 'nullable|date',
            'folder.liquidation_number' => 'nullable|string|max:255',
            'folder.liquidation_date' => 'nullable|date',
            'folder.quitance_number' => 'nullable|string|max:255',
            'folder.quitance_date' => 'nullable|date',
            'folder.description' => 'nullable|string|max:1000',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        FolderService::updateFolder($this->folderModel, $validated['folder']);

        session()->flash('message', 'Folder updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-edit');
    }
}
