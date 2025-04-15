<?php

namespace App\Livewire\Admin\ManageSupplier;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supplier;

class SupplierCreate extends Component
{
    use WithPagination;

    public $name;
    public $phone;
    public $email;
    public $country;
    public $editingId = null;
    public $search = '';
    public $confirmingReset = false;
    public $confirmingDelete = null;

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'phone' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'country' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        Supplier::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'country' => $this->country,
            ]
        );

        session()->flash('success', 'Supplier ' . ($this->editingId ? 'updated' : 'added') . ' successfully.');

        $this->reset(['name', 'phone', 'email', 'country', 'editingId']);
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->name = $supplier->name;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->country = $supplier->country;
        $this->editingId = $supplier->id;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function delete($id)
    {
        Supplier::findOrFail($id)->delete();
        session()->flash('success', 'Supplier deleted successfully.');
        $this->confirmingDelete = null;
    }

    public function confirmReset()
    {
        $this->confirmingReset = true;
    }

    public function resetForm()
    {
        $this->reset(['name', 'phone', 'email', 'country', 'editingId', 'search', 'confirmingReset']);
    }

    public function render()
    {
        $suppliers = Supplier::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('country', 'like', '%' . $this->search . '%');
        })
            ->orderBy('name')
            ->paginate(10);
        return view('livewire.admin.manage-supplier.supplier-create', [
            'suppliers' => $suppliers,
        ]);
    }
}
