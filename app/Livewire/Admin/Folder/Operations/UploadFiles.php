<?php

namespace App\Livewire\Admin\Folder\Operations;

use App\Models\DocumentType;
use App\Models\Folder;
use App\Models\FolderFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadFiles extends Component
{
    use WithFileUploads;

    public $folder;

    public $file;

    public $documentType;

    public $documentTypes = [];

    public $confirmingReset = false;

    public $confirmingDelete = null;

    protected $rules = [
        'file' => 'required|file|max:10240',
        'documentType' => 'required|exists:document_types,id',
    ];

    public function mount(Folder $folder)
    {
        $this->folder = $folder->load('files.documentType');
        $this->documentTypes = DocumentType::all();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function uploadFile()
    {
        $this->validate();
        $storedPath = $this->file->store('folder_files', 'public');
        $this->folder->files()->create([
            'name' => $this->documentType,
            'path' => $storedPath,
            'document_type_id' => $this->documentType,
        ]);

        session()->flash('success', '📁 Fichier ajouté avec succès !');

        $this->reset('file', 'documentType');
        $this->folder->refresh(); // recharge les fichiers
    }

    public function getGroupedFilesProperty()
    {
        return $this->folder->files
            ->groupBy(function ($file) {
                return $file->documentType->name ?? 'Non défini';
            });
    }

    public function deleteFile($id)
    {
        $file = FolderFile::findOrFail($id);

        if ($file->folder_id !== $this->folder->id) {
            abort(403);
        }

        Storage::disk('public')->delete($file->path);
        $file->delete();

        $this->folder->refresh();
    }

    public function render()
    {
        return view('livewire.admin.folder.operations.upload-files');
    }
}
