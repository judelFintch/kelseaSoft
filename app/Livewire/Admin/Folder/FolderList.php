<?php

namespace App\Livewire\Admin\Folder;

use App\Models\Folder;
use App\Models\Transporter;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FolderExport;
use App\Services\Folder\FolderService;

class FolderList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $filterTransporter = null;
    public $filterDateFrom = null;
    public $filterDateTo = null;
    public $transporters;

    protected $queryString = ['search'];

    public function mount()
    {
        $this->transporters = Transporter::all();
    }

    public function exportExcel()
{
    return Excel::download(new FolderExport, 'folders.xlsx');
}

    public function updatingSearch()
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
                'company'
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
        ]);
    }
}