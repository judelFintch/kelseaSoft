<?php

namespace App\Livewire\Admin\ManageTransporters;

use Livewire\Component;
use App\Models\Transporter;
use Livewire\WithPagination;

class TransportersCreate extends Component
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

        Transporter::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'country' => $this->country,
            ]
        );

        session()->flash('success', 'Transporter ' . ($this->editingId ? 'updated' : 'added') . ' successfully.');

        $this->reset(['name', 'phone', 'email', 'country', 'editingId']);
    }

    public function edit($id)
    {
        $transporter = Transporter::findOrFail($id);
        $this->name = $transporter->name;
        $this->phone = $transporter->phone;
        $this->email = $transporter->email;
        $this->country = $transporter->country;
        $this->editingId = $transporter->id;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function delete($id)
    {
        Transporter::findOrFail($id)->delete();
        session()->flash('success', 'Transporter deleted successfully.');
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
        $transporters = Transporter::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('country', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.manage-transporters.transporters-create', [
            'transporters' => $transporters,
        ]);
    }
}