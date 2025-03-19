<?php

namespace App\Livewire\Dossiers;

use Livewire\Component;
use App\Models\Dossier;
use App\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Exception;

class CreateDossier extends Component
{
    public $client_id, 
           $supplier, 
           $goods_type, 
           $description, 
           $quantity, 
           $total_weight, 
           $declared_value, 
           $fob, 
           $insurance, 
           $currency, 
           $manifest_number, 
           $container_number, 
           $vehicle_plate, 
           $contract_type, 
           $delivery_place, 
           $file_type, 
           $expected_arrival_date, 
           $border_arrival_date, 
           $invoice_number, 
           $invoice_date, 
           $status, 
           $file_number;

    public function mount()
    {
        $this->client_id = null;
        $this->supplier = 'MARCHANDISE';
        $this->goods_type = 'SOUFFRE';
        $this->description = 'SOUFFRE';
        $this->quantity = 1;
        $this->total_weight = 0.00;
        $this->declared_value = 0.00;
        $this->fob = 0.00;
        $this->insurance = 0.00;
        $this->currency = 'USD';
        $this->manifest_number = '0';
        $this->container_number = 'MKRUUDD';
        $this->vehicle_plate = 'T3098/T456UY';
        $this->contract_type = 'CIF';
        $this->delivery_place = 'LUBUMBASHI';
        $this->file_type = 'Dossier Import';
        $this->expected_arrival_date = date('Y-m-d');
        $this->border_arrival_date = null;
        $this->invoice_number = 'INVOO';
        $this->invoice_date = null;
        $this->status = 'pending';
        $this->file_number = uniqid('DOC_');
    }

    /**
     * Définition des règles de validation
     */
    protected function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'supplier' => 'required|string|max:255',
            'goods_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'total_weight' => 'required|numeric|min:0',
            'declared_value' => 'required|numeric|min:0',
            'fob' => 'required|numeric|min:0',
            'insurance' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'manifest_number' => 'nullable|string|max:50',
            'container_number' => 'nullable|string|max:50',
            'vehicle_plate' => 'nullable|string|max:50',
            'contract_type' => 'required|string|max:100',
            'delivery_place' => 'nullable|string|max:255',
            'file_type' => 'required|string|max:100',
            'expected_arrival_date' => 'required|date',
            'border_arrival_date' => 'nullable|date',
            'invoice_number' => 'nullable|string|max:50',
            'invoice_date' => 'nullable|date',
            'status' => ['required', Rule::in(['pending', 'validated', 'completed'])],
        ];
    }

    public function submit()
    {
        try {
            // ✅ Validation des données
            $validatedData = $this->validate();

            // ✅ Génération automatique du numéro de dossier unique
            $validatedData['file_number'] = uniqid('DOC_');

            // ✅ Création du dossier
            Dossier::create($validatedData);

            // ✅ Message de succès
            session()->flash('success', 'Dossier créé avec succès !');

            // ✅ Redirection vers la liste des dossiers
            return redirect()->route('dossiers.index');

        } catch (Exception $e) {
            // 🔴 Capture des erreurs et log
            Log::error('Erreur lors de la création du dossier : ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la création du dossier.');
        }
    }

    public function render()
    {
        $clients = Client::all();
        return view('livewire.dossiers.create-dossier', compact('clients'));
    }
}
