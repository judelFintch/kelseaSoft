<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UserEdit extends Component
{
    use WithFileUploads;
    public User $user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRoles = [];

    public $avatar;

    public $roles;

    public function mount(User $user)
    {
        if (!Gate::allows('edit user')) {
            abort(403);
        }
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = Role::all();
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'selectedRoles' => 'nullable|array',
            'selectedRoles.*' => 'exists:roles,id',
        ];
    }

    public function updateUser()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->email = $this->email;

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        if ($this->avatar) {
            if ($this->user->avatar) {
                Storage::disk('public')->delete($this->user->avatar);
            }
            $this->user->avatar = $this->avatar->store('avatars', 'public');
        }

        $this->user->save();
        $this->user->roles()->sync($this->selectedRoles);

        session()->flash('message', 'User updated successfully.');
        return redirect()->route('admin.user.index');
    }

    public function render()
    {
        return view('livewire.admin.user.user-edit')
            ->layout('layouts.app');
    }
}
