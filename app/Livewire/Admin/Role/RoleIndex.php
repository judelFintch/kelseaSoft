<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class RoleIndex extends Component
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
        if (!Gate::allows('manage roles')) {
            abort(403);
        }

        $roles = Role::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('display_name', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.role.role-index', [
            'roles' => $roles,
        ])->layout('layouts.app');
    }

    public function deleteRole($roleId)
    {
        // Add a more specific 'delete role' permission if needed
        if (!Gate::allows('manage roles')) {
            abort(403);
        }
        $role = Role::findOrFail($roleId);
        if ($role->name === 'root') {
            session()->flash('error', 'The root role cannot be deleted.');
            return;
        }
        $role->delete();
        session()->flash('message', 'Role deleted successfully.');
    }
}
