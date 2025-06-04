<?php

namespace App\Livewire\Admin\Permission;

use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionCreate extends Component
{
    public $name;
    public $display_name;
    public $description;

    public function mount()
    {
        if (!Gate::allows('manage permissions')) { // Or a more specific 'create permission'
            abort(403);
        }
        // Typically permissions are defined in code/migrations,
        // but if you want to allow dynamic creation:
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function createPermission()
    {
        $this->validate();

        Permission::create([
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Permission created successfully.');
        return redirect()->route('admin.permission.index');
    }

    public function render()
    {
        // Decide if this view should actually be used or if permissions are managed differently.
        // For now, it provides a basic form.
        return view('livewire.admin.permission.permission-create')
            ->layout('layouts.app');
    }
}
