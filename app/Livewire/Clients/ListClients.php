<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;

class ListClients extends Component
{
    use WithPagination;
    public $totalFiles = 10 ;
    public $totalInvoices = 10 ;
    public $totalClients = 10 ;

    public function render()
    {
        $clients = Client::latest()->paginate(10);

        return view('livewire.clients.list-clients', [
            'clients'=>$clients,'totalClients' => $clients, 'totalFiles' => $this->totalFiles, 'totalInvoices' => $this->totalInvoices
        ]);
    }
}
