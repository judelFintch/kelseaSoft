<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;

class ShowClient extends Component
{
    public $client;

    public function mount()

    {
        $this->client = Client::findOrFail($this->client);
    }

    public function render()
    {
        return view('livewire.clients.show-client', [
            'client' => $this->client
        ]);
    }
}
