<?php

namespace App\Livewire\Dossiers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Dossier;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class ShowDossier extends Component
{
    use WithFileUploads;

    public $dossier;
    public $dossierId;
    public $folderName = ''; // Nom du dossier à enregistrer
    public $files = [];
    public $uploadedFiles = [];

    public function mount($dossier)
    {
        $this->dossierId = $dossier;
        $this->loadDossier();
    }

    public function loadDossier()
    {
        $this->dossier = Dossier::with('files')->find($this->dossierId);

        if (!$this->dossier) {
            session()->flash('error', 'Dossier introuvable.');
            return redirect()->route('dossiers.index');
        }

        $this->uploadedFiles = $this->dossier->files;
    }

    public function saveDossier()
    {
        $this->validate([
            'folderName' => 'required|string|max:255',
            'files.*' => 'file|max:2048|mimes:pdf,jpg,png,jpeg,doc,docx',
        ]);

        // Enregistrement du dossier
        $dossier = Dossier::create([
            'file_number' => uniqid('DOC_'),
            'supplier' => 'MARCHANDISE',
            'goods_type' => 'SOUFFRE',
            'quantity' => 1,
            'total_weight' => 0.00,
            'declared_value' => 0.00,
            'status' => 'pending',
            'client_id' => 1, // Remplace par le vrai client_id
            'file_type' => $this->folderName,
            'expected_arrival_date' => now(),
        ]);

        // Enregistrement des fichiers liés
        foreach ($this->files as $file) {
            $filePath = $file->store('documents', 'public');

            File::create([
                'dossier_id' => $dossier->id,
                'name' => $file->getClientOriginalName(),
                'path' => $filePath,
                'type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        session()->flash('success', 'Dossier et fichiers enregistrés avec succès !');

        // Réinitialisation des champs
        $this->files = [];
        $this->folderName = '';
        $this->loadDossier();
    }

    public function deleteFile($fileId)
    {
        $file = File::findOrFail($fileId);
        Storage::disk('public')->delete($file->path);
        $file->delete();

        session()->flash('success', 'Fichier supprimé !');
        $this->loadDossier();
    }

    public function render()
    {
        return view('livewire.dossiers.show-dossier');
    }
}
