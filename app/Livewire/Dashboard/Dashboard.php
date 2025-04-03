<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }
}
