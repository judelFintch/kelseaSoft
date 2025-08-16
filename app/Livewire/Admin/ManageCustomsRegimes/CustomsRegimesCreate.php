<?php

namespace App\Livewire\Admin\ManageCustomsRegimes;

use App\Models\CustomsRegime;
use Livewire\Component;
use Livewire\WithPagination;

class CustomsRegimesCreate extends Component
{
    use WithPagination;

    public $name;

    public $editingId = null;

    public $search = '';

    public $confirmingReset = false;

    public $confirmingDelete = null;

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
    ];

    public function save()
    {
        $this->validate();

        CustomsRegime::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        session()->flash('success', 'Customs regime '.($this->editingId ? 'updated' : 'added').' successfully.');

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $regime = CustomsRegime::findOrFail($id);
        $this->name = $regime->name;
        $this->editingId = $regime->id;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function delete($id)
    {
        CustomsRegime::findOrFail($id)->delete();
        session()->flash('success', 'Regime deleted successfully.');
        $this->confirmingDelete = null;
    }

    public function confirmReset()
    {
        $this->confirmingReset = true;
    }

    public function resetForm()
    {
        $this->reset(['name', 'editingId', 'search', 'confirmingReset']);
    }

    public function render()
    {
        $regimes = CustomsRegime::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.manage-customs-regimes.customs-regimes-create', [
            'regimes' => $regimes,
        ]);
    }
}
