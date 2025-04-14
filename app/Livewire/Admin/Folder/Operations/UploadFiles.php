<?php

namespace App\Livewire\Admin\Folder\Operations;

use Livewire\Component;
use App\Models\DocumentType;

class UploadFiles extends Component
{


    public $folder;
    public $file;
    public $documentTypes;

    protected $rules = [
        'file' => 'required|file|max:10240',
        'documentType' => 'required|string',
    ];



    public function mount($folder)
    {
        $this->folder = $folder;
        $this->documentTypes = DocumentType::all();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function uploadFile()
    {
        $this->validate();

        // logiques d’enregistrement
        $path = $this->file->store('folder_files', 'public');

        $this->folder->files()->create([
            'name' => $this->file->getClientOriginalName(),
            'path' => $path,
            'type' => $this->documentType,
        ]);

        $this->reset('file', 'documentType');
    }



    public function render()
    {
        return view('livewire.admin.folder.operations.upload-files');
    }
}
