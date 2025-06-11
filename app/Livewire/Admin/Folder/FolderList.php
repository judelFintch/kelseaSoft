<?php

namespace App\Livewire\Admin\Folder;

use App\Exports\FolderExport;
use App\Models\Folder;
use App\Models\Transporter;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class FolderList extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $filterTransporter = null;

    public $filterDateFrom = null;

    public $filterDateTo = null;

    public $transporters;

    public $allColumns = [
        'folder_number' => 'Folder',
        'truck_number' => 'Truck',
        'trailer_number' => 'Trailer',
        'invoice_number' => 'Invoice',
        'goods_type' => 'Goods',
        'agency' => 'Agency',
        'pre_alert_place' => 'Pre-alert',
        'transport_mode' => 'Mode',
        'internal_reference' => 'Internal Ref',
        'order_number' => 'Order',
        'folder_date' => 'Date',
        'transporter_name' => 'Transporter', // Assuming 'transporter->name'
        'origin_name' => 'Origin', // Assuming 'origin->name'
        'destination_name' => 'Dest.', // Assuming 'destination->name'
        'supplier_name' => 'Supplier', // Assuming 'supplier->name'
        'company_name' => 'Client', // Assuming 'company->name'
        'customs_office_name' => 'Customs Office', // Assuming 'customsOffice->name'
        'declaration_number' => 'Decl. Number',
        'declaration_type_name' => 'Decl. Type', // Assuming 'declarationType->name'
        'declarant' => 'Declarant',
        'customs_agent' => 'Agent',
        'container_number' => 'Container',
        'arrival_border_date' => 'Border Date',
        'tr8_number' => 'TR8',
        'tr8_date' => 'TR8 Date',
        't1_number' => 'T1',
        't1_date' => 'T1 Date',
        'formalities_office_reference' => 'Formalities',
        'im4_number' => 'IM4',
        'im4_date' => 'IM4 Date',
        'liquidation_number' => 'Liquidation',
        'liquidation_date' => 'Liquidation Date',
        'quitance_number' => 'Quitance',
        'quitance_date' => 'Quitance Date',
        'dossier_type' => 'Type',
        'license_code' => 'License Code',
        'bivac_code' => 'Bivac',
        'license_number' => 'License', // Assuming 'license->license_number'
        'description' => 'Desc.',
    ];

    public $visibleColumns = [
        'folder_number',
        'truck_number',
        'company_name', // Or 'company_name' if that's the correct key for client
        'arrival_border_date',
        // 'status', // Assuming there's a status field, or we can derive one.
    ];

    protected $queryString = ['search'];

    public function mount()
    {
        $this->transporters = Transporter::all();
        // Initialize visibleColumns with a default set if not already set by Livewire's mechanisms
        if (empty($this->visibleColumns)) {
            $this->visibleColumns = [
                'folder_number', 'truck_number', 'company_name',
                'arrival_border_date', 'goods_type', 'transporter_name', 'declaration_number'
            ];
        }
    }

    public function exportExcel()
    {
        return Excel::download(new FolderExport, 'folders.xlsx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $folders = Folder::with([
            'transporter',
            'supplier',
            'origin',
            'destination',
            'customsOffice',
            'declarationType',
            'company',
            'invoice', // Ajout de la relation invoice pour l'eager loading
        ])
            ->when($this->search, function ($query) {
                $query->where('folder_number', 'like', '%' . $this->search . '%')
                    ->orWhere('truck_number', 'like', '%' . $this->search . '%')
                    ->orWhere('client', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterTransporter, fn($q) => $q->where('transporter_id', $this->filterTransporter))
            ->when($this->filterDateFrom, fn($q) => $q->whereDate('arrival_border_date', '>=', $this->filterDateFrom))
            ->when($this->filterDateTo, fn($q) => $q->whereDate('arrival_border_date', '<=', $this->filterDateTo))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.folder.folder-list', [
            'folders' => $folders,
            'totalFolders' => $folders->total(),
        ]);
    }
}
