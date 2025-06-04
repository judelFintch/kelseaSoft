<?php

namespace App\Livewire\Admin\Permission;

use Livewire\Component;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class PermissionEdit extends Component
{
    public Permission $permission;
    public $name;
    public $display_name;
    public $description;

    public function mount(Permission $permission)
    {
        if (!Gate::allows('manage permissions')) { // Or a more specific 'edit permission'
            abort(403);
        }
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->display_name = $permission->display_name;
        $this->description = $permission->description;
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($this->permission->id),
            ],
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function updatePermission()
    {
        $this->validate();

        // Generally, critical permissions (like 'manage users') should not have their name (code) changed easily
        // as it might break application logic tied to the permission name.
        // Consider adding checks here if certain permissions are immutable.
        // Example:
        // if (in_array($this->permission->name, ['manage users', 'manage roles']) && $this->name !== $this->permission->name) {
        //     session()->flash('error', 'This core permission name cannot be changed.');
        //     $this->name = $this->permission->name; // Reset
        //     return;
        // }


        $this->permission->name = $this->name;
        $this->permission->display_name = $this->display_name;
        $this->permission->description = $this->description;
        $this->permission->save();

        session()->flash('message', 'Permission updated successfully.');
        return redirect()->route('admin.permission.index');
    }

    public function render()
    {
        // Decide if this view should actually be used or if permissions are managed differently.
        // For now, it provides a basic form.
        return view('livewire.admin.permission.permission-edit')
            ->layout('layouts.app');
    }
}
