<?php

namespace App\Livewire\Admin\ManageAgencyFees;

use App\Models\AgencyFee;
use Livewire\Component;
use Livewire\WithPagination;

class ManageAgencyFee extends Component
{
    use WithPagination;

    public $agency_fee_id;
    public $code;
    public $label;
    public $description;

    public $showForm = false;
    public $isEditMode = false;
    public $search = '';

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:agency_fees,code' . ($this->agency_fee_id ? ',' . $this->agency_fee_id : ''),
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function render()
    {
        $fees = AgencyFee::query()
            ->when($this->search, fn($query) => $query
                ->where('label', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manage-agency-fees.manage-agency-fee', [
            'fees' => $fees,
        ]);
    }

    public function showForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->isEditMode = false;
    }

    public function save()
    {
        $this->validate();
        AgencyFee::create([
            'code' => $this->code,
            'label' => $this->label,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Frais agence enregistré avec succès.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $fee = AgencyFee::findOrFail($id);
        $this->agency_fee_id = $fee->id;
        $this->code = $fee->code;
        $this->label = $fee->label;
        $this->description = $fee->description;
        $this->isEditMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $fee = AgencyFee::findOrFail($this->agency_fee_id);
        $this->validate();
        $fee->update([
            'code' => $this->code,
            'label' => $this->label,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Frais agence mis à jour.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete($id)
    {
        AgencyFee::findOrFail($id)->delete();
        session()->flash('success', 'Frais agence supprimé.');
    }

    public function resetForm()
    {
        $this->reset(['agency_fee_id', 'code', 'label', 'description', 'isEditMode']);
    }
}
