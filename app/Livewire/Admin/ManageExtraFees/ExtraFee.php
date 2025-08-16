<?php

namespace App\Livewire\Admin\ManageExtraFees;

use Livewire\Component;
use App\Models\ExtraFee as ExtraFeeModel;

class ExtraFee extends Component
{
    public $showForm = false;
    public $isEdit = false;
    public $extraFees = [];
    public $extra_fee_id;
    public $code;
    public $label;
    public $description;

    protected $rules = [
        'code' => 'required|string|unique:extra_fees,code',
        'label' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ];

    public function mount(): void
    {
        $this->loadExtraFees();
    }

    public function loadExtraFees(): void
    {
        $this->extraFees = ExtraFeeModel::orderBy('label')->get();
    }

    public function toggleForm(): void
    {
        $this->resetForm();
        $this->showForm = !$this->showForm;
        $this->isEdit = false;
    }

    public function edit($id): void
    {
        $fee = ExtraFeeModel::findOrFail($id);
        $this->extra_fee_id = $fee->id;
        $this->code = $fee->code;
        $this->label = $fee->label;
        $this->description = $fee->description;
        $this->isEdit = true;
        $this->showForm = true;
        $this->resetValidation();
    }

    public function save(): void
    {
        $validated = $this->validate($this->rules);

        ExtraFeeModel::create($validated);
        session()->flash('success', 'Frais divers ajouté avec succès.');
        $this->resetForm();
        $this->loadExtraFees();
    }

    public function update(): void
    {
        $this->rules['code'] .= ',' . $this->extra_fee_id;
        $validated = $this->validate($this->rules);
        $fee = ExtraFeeModel::findOrFail($this->extra_fee_id);
        $fee->update($validated);
        session()->flash('success', 'Frais divers mis à jour avec succès.');
        $this->resetForm();
        $this->loadExtraFees();
    }

    public function delete($id): void
    {
        ExtraFeeModel::findOrFail($id)->delete();
        session()->flash('success', 'Frais divers supprimé avec succès.');
        $this->loadExtraFees();
    }

    public function resetForm(): void
    {
        $this->reset(['extra_fee_id', 'code', 'label', 'description', 'isEdit', 'showForm']);
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.admin.manage-extra-fees.extra-fee');
    }
}
