<?php

namespace App\Livewire\Dossiers;

use Livewire\Component;
use App\Models\Dossier;


class EditDossier extends Component
{
    public $dossier;

    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function update()
    {
        $this->dossier->save();
        return redirect()->route('dossiers.index')->with('success', 'Dossier mis à jour avec succès !');
    }

    public function render()
    {
        return view('livewire.dossiers.edit-dossier');
    }
}
