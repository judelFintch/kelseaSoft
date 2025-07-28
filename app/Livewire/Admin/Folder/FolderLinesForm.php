<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;
use App\Models\FolderLine;

class FolderLinesForm extends Component
{
    public Folder $folder;

    public array $line = [
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

    public function mount(Folder $folder): void
    {
        $this->folder = $folder->load('lines');
    }

    protected function rules(): array
    {
        return [
            'line.position_code' => 'nullable|string|max:255',
            'line.description' => 'nullable|string|max:255',
            'line.invoice_number' => 'nullable|string|max:255',
            'line.colis' => 'nullable|string|max:255',
            'line.emballage' => 'nullable|string|max:255',
            'line.gross_weight' => 'nullable|numeric',
            'line.net_weight' => 'nullable|numeric',
            'line.fob_amount' => 'nullable|numeric',
            'line.license_code' => 'nullable|string|max:255',
            'line.fxi' => 'nullable|string|max:255',
        ];
    }

    public function addLine(): void
    {
        $data = $this->validate()['line'];

        $exists = $this->folder->lines()
            ->where('position_code', $data['position_code'])
            ->where('description', $data['description'])
            ->where('invoice_number', $data['invoice_number'])
            ->where('colis', $data['colis'])
            ->where('emballage', $data['emballage'])
            ->where('gross_weight', $data['gross_weight'])
            ->where('net_weight', $data['net_weight'])
            ->where('fob_amount', $data['fob_amount'])
            ->where('license_code', $data['license_code'])
            ->where('fxi', $data['fxi'])
            ->exists();

        if ($exists) {
            session()->flash('error', 'Cette ligne existe déjà');
            return;
        }

        $this->folder->lines()->create($data);
        $this->folder->refresh();
        $this->reset('line');
        session()->flash('success', 'Ligne ajoutée');
    }

    public function deleteLine(int $id): void
    {
        $this->folder->lines()->where('id', $id)->delete();
        $this->folder->refresh();
    }

    public function render()
    {
        return view('livewire.admin.folder.partials.folder-lines-form');
    }
}
