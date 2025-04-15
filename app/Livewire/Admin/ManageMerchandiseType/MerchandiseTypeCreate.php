<?php

namespace App\Livewire\Admin\ManageMerchandiseType;

use App\Models\MerchandiseType;
use Livewire\Component;
use Livewire\WithPagination;

class MerchandiseTypeCreate extends Component
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

        MerchandiseType::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        session()->flash('success', 'Merchandise type '.($this->editingId ? 'updated' : 'added').' successfully.');

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $type = MerchandiseType::findOrFail($id);
        $this->name = $type->name;
        $this->editingId = $type->id;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function delete($id)
    {
        MerchandiseType::findOrFail($id)->delete();
        session()->flash('success', 'Type deleted successfully.');
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
        $types = MerchandiseType::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.manage-merchandise-type.merchandise-type-create', ['types' => $types]);
    }
}
