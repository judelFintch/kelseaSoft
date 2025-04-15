<?php

namespace App\Livewire\Admin\Folder;

use App\Services\Folder\FolderService;
use Livewire\Component;

class FolderShow extends Component
{
    public $folder;

    public function mount($id)
    {
        $this->folder = FolderService::getFolder($id);
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
