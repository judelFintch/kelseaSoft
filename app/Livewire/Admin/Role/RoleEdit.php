<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class RoleEdit extends Component
{
    public Role $role;
    public $name;
    public $display_name;
    public $description;
    public $selectedPermissions = [];

    public $permissions;

    public function mount(Role $role)
    {
        if (!Gate::allows('manage roles')) {
            abort(403);
        }
        $this->role = $role;
        $this->name = $role->name;
        $this->display_name = $role->display_name;
        $this->description = $role->description;
        $this->permissions = Permission::all()->sortBy('name');
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($this->role->id),
            ],
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'selectedPermissions' => 'nullable|array',
            'selectedPermissions.*' => 'exists:permissions,id',
        ];
    }

    public function updateRole()
    {
        if ($this->role->name === 'root' && $this->name !== 'root') {
            session()->flash('error', 'The name of the root role cannot be changed.');
            $this->name = 'root'; // Reset to original name
            // We might want to prevent editing other fields for root role as well
            // or simply redirect back with an error. For now, just name change is blocked.
            return;
        }

        $this->validate();

        $this->role->name = $this->name;
        $this->role->display_name = $this->display_name;
        $this->role->description = $this->description;
        $this->role->save();

        if ($this->role->name !== 'root') { // Prevent changing permissions for root role
            $this->role->permissions()->sync($this->selectedPermissions);
        }


        session()->flash('message', 'Role updated successfully.');
        return redirect()->route('admin.role.index');
    }

    public function render()
    {
        return view('livewire.admin.role.role-edit')
            ->layout('layouts.app');
    }
}
