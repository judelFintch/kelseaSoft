<?php

namespace App\Livewire\Pages\Folder;

use Livewire\Component;
use App\Models\Folder;

class PrintableCalculationSheet extends Component
{
    public Folder $folder;

    public function mount(Folder $folder): void
    {
        $this->folder = $folder->load(['invoice', 'lines', 'company', 'customsOffice']);
    }

    public function render()
    {
        return view('livewire.pages.folder.printable-calculation-sheet');
    }
}
