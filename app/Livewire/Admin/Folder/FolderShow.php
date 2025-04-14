<?php

namespace App\Livewire\Admin\Folder;


use Livewire\Component;
use App\Models\Folder;

class FolderShow extends Component
{


    public $folder;


    public function mount($id)
    {
        $this->folder = Folder::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-show');
    }
}
