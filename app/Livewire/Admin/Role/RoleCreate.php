<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleCreate extends Component
{
    public $name;
    public $display_name;
    public $description;
    public $selectedPermissions = [];

    public $permissions;

    public function mount()
    {
        if (!Gate::allows('manage roles')) {
            abort(403);
        }
        $this->permissions = Permission::all()->sortBy('name');
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'selectedPermissions' => 'nullable|array',
            'selectedPermissions.*' => 'exists:permissions,id',
        ];
    }

    public function createRole()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        session()->flash('message', 'Role created successfully.');
        return redirect()->route('admin.role.index');
    }

    public function render()
    {
        return view('livewire.admin.role.role-create')
            ->layout('layouts.app');
    }
}
