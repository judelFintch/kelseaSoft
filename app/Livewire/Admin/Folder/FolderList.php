<?php

namespace App\Livewire\Admin\Folder;

use App\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class FolderList extends Component
{

    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $folders = Folder::query()
        ->when($this->search, function ($query) {
            $query->where('folder_number', 'like', '%' . $this->search . '%')
                  ->orWhere('truck_number', 'like', '%' . $this->search . '%')
                  ->orWhere('client', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate($this->perPage);
        return view('livewire.admin.folder.folder-list', [
            'folders' => $folders,
        ]);
    }
}
