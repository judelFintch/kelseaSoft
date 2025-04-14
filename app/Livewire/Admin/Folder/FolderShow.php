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

    public function deleteFile($id)
    {
        // logiques de suppression ici
    }

    public function printPdf()
    {
        // génération PDF ou redirection
    }

    public function confirmDelete()
    {
        // logique de confirmation ou suppression immédiate
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-show');
    }
}
