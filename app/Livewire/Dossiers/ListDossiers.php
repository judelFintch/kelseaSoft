<?php

namespace App\Livewire\Dossiers;

use Livewire\Component;
use App\Models\Dossier;

class ListDossiers extends Component
{
    public function render()
    {
        return view('livewire.dossiers.list-dossiers', [
            'dossiers' => Dossier::latest()->paginate(10)
        ]);
    }
}
