<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;

class FolderExtraFields extends Component
{
    public Folder $folder;

    public $scelle_number;
    public $manifest_number;
    public $incoterm;
    public $customs_regime;
    public $additional_code;
    public $quotation_date;
    public $opening_date;
    public $entry_point;

    public function mount(Folder $folder): void
    {
        $this->folder = $folder;
        $this->fill($folder->only([
            'scelle_number',
            'manifest_number',
            'incoterm',
            'customs_regime',
            'additional_code',
            'quotation_date',
            'opening_date',
            'entry_point',
        ]));
    }

    protected function rules(): array
    {
        return [
            'scelle_number' => 'nullable|string|max:255',
            'manifest_number' => 'nullable|string|max:255',
            'incoterm' => 'nullable|string|max:255',
            'customs_regime' => 'nullable|string|max:255',
            'additional_code' => 'nullable|string|max:255',
            'quotation_date' => 'nullable|date',
            'opening_date' => 'nullable|date',
            'entry_point' => 'nullable|string|max:255',
        ];
    }

    public function save(): void
    {
        $data = $this->validate();
        $this->folder->update($data);
        session()->flash('success', 'Informations mises à jour');
    }

    public function render()
    {
        return view('livewire.admin.folder.partials.folder-extra-fields');
    }
}
