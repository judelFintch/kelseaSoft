<?php
namespace App\Livewire\Dossiers;

use Livewire\Component;
use App\Models\Dossier;

class ShowDossier extends Component
{
    public $dossier;

    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function render()
    {
        return view('livewire.dossiers.show-dossier');
    }
}
