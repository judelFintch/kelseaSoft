<?php

namespace App\Livewire\Admin\Licence\Upload;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Licence;
use App\Models\LicenceFile;
use Illuminate\Support\Facades\Storage;

class UploadFiles extends Component
{
    use WithFileUploads;

    public Licence $licence;

    public $file;

    protected $rules = [
        'file' => 'required|file|max:10240',
    ];

    public function mount(Licence $licence): void
    {
        $this->licence = $licence->load('files');
    }

    public function uploadFile(): void
    {
        $this->validate();

        $storedPath = $this->file->store('licence_files', 'public');

        $this->licence->files()->create([
            'name' => $this->file->getClientOriginalName(),
            'path' => $storedPath,
        ]);

        $this->licence->refresh();
        $this->reset('file');
        session()->flash('success', 'Fichier BIVAC ajouté avec succès.');
    }

    public function deleteFile($id): void
    {
        $file = LicenceFile::findOrFail($id);

        if ($file->licence_id !== $this->licence->id) {
            abort(403);
        }

        Storage::disk('public')->delete($file->path);
        $file->delete();

        $this->licence->refresh();
    }

    public function render()
    {
        return view('livewire.admin.licence.upload.upload-files');
    }
}
