<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Livewire\WithFileUploads;

class UserCreate extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRoles = [];

    public $avatar;

    public $roles;

    public function mount()
    {
        if (!Gate::allows('create user')) {
            abort(403);
        }
        $this->roles = Role::all();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'selectedRoles' => 'nullable|array',
            'selectedRoles.*' => 'exists:roles,id',
        ];
    }

    public function createUser()
    {
        $this->validate();

        $avatarPath = $this->avatar ? $this->avatar->store('avatars', 'public') : null;

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => $avatarPath,
        ]);

        $user->roles()->sync($this->selectedRoles);

        session()->flash('message', 'User created successfully.');
        return redirect()->route('admin.user.index');
    }

    public function render()
    {
        return view('livewire.admin.user.user-create')
            ->layout('layouts.app');
    }
}
