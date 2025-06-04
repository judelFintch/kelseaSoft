<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class UserIndex extends Component
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
        if (!Gate::allows('manage users')) {
            abort(403);
        }

        $users = User::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user.user-index', [
            'users' => $users,
        ])->layout('layouts.app'); // Assuming you have a main layout
    }

    public function deleteUser($userId)
    {
        if (!Gate::allows('delete user')) { // Or a more specific 'delete user' permission
            abort(403);
        }
        User::findOrFail($userId)->delete();
        session()->flash('message', 'User deleted successfully.');
    }
}
