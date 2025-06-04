<?php

namespace App\Livewire\Admin\Permission;

use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class PermissionIndex extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!Gate::allows('manage permissions')) {
            abort(403);
        }

        $permissions = Permission::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('display_name', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'asc') // Often good to sort permissions by name
            ->paginate(20); // Show more permissions per page perhaps

        return view('livewire.admin.permission.permission-index', [
            'permissions' => $permissions,
        ])->layout('layouts.app');
    }

    // Delete permission - generally not recommended unless you are sure it's not used
    // and have a way to clean up associations or handle missing permissions.
    // For now, we will omit delete functionality for permissions from the UI.
    // public function deletePermission($permissionId)
    // {
    //     if (!Gate::allows('manage permissions')) { // Or a more specific 'delete permission'
    //         abort(403);
    //     }
    //     Permission::findOrFail($permissionId)->delete();
    //     session()->flash('message', 'Permission deleted successfully.');
    // }
}
