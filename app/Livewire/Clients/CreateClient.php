<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;

class CreateClient extends Component
{
    public $company_name;
    public $contact_person;
    public $email;
    public $phone;
    public $secondary_phone;
    public $address;
    public $city;
    public $state;
    public $country;
    public $tax_id;
    public $registration_number;
    public $identification_number;
    public $rccm;
    public $website;
    public $notes;


    protected function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'identification_number' => 'nullable|string|max:50',
            'rccm' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function submit()
{
    $validatedData = $this->validate();
    Client::create($validatedData);
    $this->reset();
    session()->flash('success', 'Client created successfully.');
}
    public function render()
    {
        return view('livewire.clients.create-client');
    }
}
