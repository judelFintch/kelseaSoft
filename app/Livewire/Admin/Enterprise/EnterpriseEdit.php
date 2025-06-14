<?php

namespace App\Livewire\Admin\Enterprise;

use Livewire\Component;
use App\Services\Enterprise\EnterpriseService;
use App\Models\Enterprise;

class EnterpriseEdit extends Component
{
    public Enterprise $enterprise;

    public $name;
    public $tagline;
    public $tax_id;
    public $commercial_register;
    public $national_identification;
    public $agreement_number;
    public $phone_number;
    public $email;
    public $physical_address;
    public $footer_note;
    public $logo;

    public function mount(): void
    {
        $this->enterprise = EnterpriseService::getEnterprise();
        $this->fill($this->enterprise->toArray());
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:100',
            'commercial_register' => 'nullable|string|max:100',
            'national_identification' => 'nullable|string|max:100',
            'agreement_number' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'physical_address' => 'nullable|string|max:255',
            'footer_note' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
        ];
    }

    public function save(): void
    {
        $data = $this->validate();
        EnterpriseService::updateEnterprise($data);
        session()->flash('success', 'Informations mises à jour.');
    }

    public function render()
    {
        return view('livewire.admin.enterprise.enterprise-edit');
    }
}
