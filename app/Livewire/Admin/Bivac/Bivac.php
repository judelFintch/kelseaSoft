<?php

namespace App\Livewire\Admin\Bivac;

use Livewire\Component;
use App\Models\Bivac as BivacModel;

class Bivac extends Component
{
    public $showForm = false;
    public $isEdit = false;
    public $bivacs = [];
    public $bivac_id;
    public $code;
    public $label;
    public $description;

    protected $rules = [
        'code' => 'required|string|unique:bivacs,code',
        'label' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ];

    public function mount(): void
    {
        $this->loadBivacs();
    }

    public function loadBivacs(): void
    {
        $this->bivacs = BivacModel::orderBy('label')->get();
    }

    public function toggleForm(): void
    {
        $this->resetForm();
        $this->showForm = !$this->showForm;
        $this->isEdit = false;
    }

    public function edit($id): void
    {
        $bivac = BivacModel::findOrFail($id);
        $this->bivac_id = $bivac->id;
        $this->code = $bivac->code;
        $this->label = $bivac->label;
        $this->description = $bivac->description;
        $this->isEdit = true;
        $this->showForm = true;
        $this->resetValidation();
    }

    public function save(): void
    {
        $validated = $this->validate($this->rules);
        BivacModel::create($validated);
        session()->flash('success', 'BIVAC ajouté avec succès.');
        $this->resetForm();
        $this->loadBivacs();
    }

    public function update(): void
    {
        $this->rules['code'] .= ',' . $this->bivac_id;
        $validated = $this->validate($this->rules);
        $bivac = BivacModel::findOrFail($this->bivac_id);
        $bivac->update($validated);
        session()->flash('success', 'BIVAC mis à jour avec succès.');
        $this->resetForm();
        $this->loadBivacs();
    }

    public function delete($id): void
    {
        BivacModel::findOrFail($id)->delete();
        session()->flash('success', 'BIVAC supprimé avec succès.');
        $this->loadBivacs();
    }

    public function resetForm(): void
    {
        $this->reset(['bivac_id', 'code', 'label', 'description', 'isEdit', 'showForm']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.bivac.bivac');
    }
}
