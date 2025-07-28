<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;

class FolderExtraFieldsForm extends Component
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

    protected $rules = [
        'scelle_number' => 'nullable|string',
        'manifest_number' => 'nullable|string',
        'incoterm' => 'nullable|string',
        'customs_regime' => 'nullable|string',
        'additional_code' => 'nullable|string',
        'quotation_date' => 'nullable|date',
        'opening_date' => 'nullable|date',
        'entry_point' => 'nullable|string',
    ];

    public function mount(Folder $folder): void
    {
        $this->folder = $folder;
        $this->scelle_number = $folder->scelle_number;
        $this->manifest_number = $folder->manifest_number;
        $this->incoterm = $folder->incoterm;
        $this->customs_regime = $folder->customs_regime;
        $this->additional_code = $folder->additional_code;
        $this->quotation_date = $folder->quotation_date;
        $this->opening_date = $folder->opening_date;
        $this->entry_point = $folder->entry_point;
    }

    public function save(): void
    {
        $data = $this->validate();
        $this->folder->update($data);
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-extra-fields-form');
    }
}
