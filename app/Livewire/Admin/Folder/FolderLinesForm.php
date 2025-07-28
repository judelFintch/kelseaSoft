<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;
use App\Models\FolderLine;

class FolderLinesForm extends Component
{
    public Folder $folder;
    public array $lines = [];

    protected $rules = [
        'lines.*.position_code' => 'nullable|string',
        'lines.*.description' => 'nullable|string',
        'lines.*.invoice_number' => 'nullable|string',
        'lines.*.colis' => 'nullable|string',
        'lines.*.emballage' => 'nullable|string',
        'lines.*.gross_weight' => 'nullable|numeric',
        'lines.*.net_weight' => 'nullable|numeric',
        'lines.*.fob_amount' => 'nullable|numeric',
        'lines.*.license_code' => 'nullable|string',
        'lines.*.fxi' => 'nullable|string',
    ];

    public function mount(Folder $folder): void
    {
        $this->folder = $folder->load('lines');
        $this->lines = $this->folder->lines->toArray();
        if (!$this->lines) {
            $this->addLine();
        }
    }

    public function addLine(): void
    {
        $this->lines[] = [
            'position_code' => '',
            'description' => '',
            'invoice_number' => '',
            'colis' => '',
            'emballage' => '',
            'gross_weight' => null,
            'net_weight' => null,
            'fob_amount' => null,
            'license_code' => '',
            'fxi' => '',
        ];
    }

    public function removeLine($index): void
    {
        unset($this->lines[$index]);
        $this->lines = array_values($this->lines);
    }

    public function save(): void
    {
        $data = $this->validate()['lines'];
        $this->folder->lines()->delete();
        foreach ($data as $line) {
            $this->folder->lines()->create($line);
        }
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.admin.folder.folder-lines-form');
    }
}
