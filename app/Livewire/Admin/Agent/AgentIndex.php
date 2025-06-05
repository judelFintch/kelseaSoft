<?php

namespace App\Livewire\Admin\Agent;

use Livewire\Component;
use App\Models\Agent;
use Livewire\WithPagination;

class AgentIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $agents = Agent::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.agent.agent-index', [
            'agents' => $agents,
        ])->layout('layouts.app');
    }
}
