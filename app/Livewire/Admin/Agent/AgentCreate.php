<?php

namespace App\Livewire\Admin\Agent;

use Livewire\Component;
use App\Models\Agent;

class AgentCreate extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $position;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ];
    }

    public function createAgent()
    {
        $this->validate();

        Agent::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'position' => $this->position,
        ]);

        session()->flash('message', 'Agent created successfully.');
        return redirect()->route('agents.list');
    }

    public function render()
    {
        return view('livewire.admin.agent.agent-create')->layout('layouts.app');
    }
}
