<?php

namespace App\Livewire\Dossiers;

use Livewire\Component;
use App\Models\Dossier;
use App\Models\Client;

class CreateDossier extends Component
{
    public $client_id, $supplier, $goods_type, $quantity, $total_weight, $declared_value, $fob, $insurance, $currency, $file_type, $expected_arrival_date, $status, $file_number;

    public function save()
    {
        Dossier::create([
            'client_id' => $this->client_id,
            'supplier' => $this->supplier,
            'goods_type' => $this->goods_type,
            'quantity' => $this->quantity,
            'total_weight' => $this->total_weight,
            'declared_value' => $this->declared_value,
            'fob' => $this->fob,
            'insurance' => $this->insurance,
            'currency' => $this->currency,
            'file_type' => $this->file_type,
            'expected_arrival_date' => $this->expected_arrival_date,
            'status' => $this->status,
            'file_number' => uniqid('DOC_'),
        ]);

        return redirect()->route('dossiers.index')->with('success', 'Dossier créé avec succès !');
    }

    public function render()
    {
        $clients = Client::all();
        return view('livewire.dossiers.create-dossier', compact('clients'));
    }
}
