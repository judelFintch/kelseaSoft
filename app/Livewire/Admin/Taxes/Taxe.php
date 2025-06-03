<?php

namespace App\Livewire\Admin\Taxes;

use App\Models\Currency;
use App\Models\Tax;
use Livewire\Component;


class Taxe extends Component
{
    public $taxes = [];
    public $currencies = [];

    public $showForm = false;
    public $editMode = false;
    public $selectedTaxId = null;

    public $code, $label, $description;

    protected $rules = [
        'code' => 'required|string|unique:taxes,code',
        'label' => 'required|string',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->taxes = Tax::latest()->get();
        $this->currencies = Currency::all();
    }

    public function showCreateForm()
    {
        $this->resetFields();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function showEditForm($id)
    {
        $tax = Tax::findOrFail($id);
        $this->selectedTaxId = $tax->id;
        $this->code = $tax->code;
        $this->label = $tax->label;
        $this->description = $tax->description;
        $this->showForm = true;
        $this->editMode = true;
    }

    public function save()
    {
        $this->validate();


        if ($this->editMode) {
            $tax = Tax::findOrFail($this->selectedTaxId);
            $tax->update([
                'code' => $this->code,
                'label' => $this->label,
                'description' => $this->description,
            ]);
        } else {
            Tax::create([
                'code' => $this->code,
                'label' => $this->label,
                'description' => $this->description,
            ]);
        }

        $this->loadData();
        $this->resetFields();
        $this->dispatch('notify', message: 'Enregistré avec succès.');
    }

    public function delete($id)
    {
        Tax::findOrFail($id)->delete();
        $this->loadData();
        $this->dispatch('notify', message: 'Supprimé avec succès.');
    }

    public function resetFields()
    {
        $this->reset([
            'code',
            'label',
            'description',
            'selectedTaxId',
        ]);
        $this->showForm = false;
        $this->editMode = false;
    }
    public function render()
    {
        return view('livewire.admin.taxes.taxe');
    }
}
