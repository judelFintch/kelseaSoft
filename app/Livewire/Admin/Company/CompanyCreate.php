<?php

namespace App\Livewire\Admin\Company;

use App\Services\Company\CompanyService;
use Livewire\Component;

class CompanyCreate extends Component
{
    public $name;

    public $business_category;

    public $tax_id;

    public $code;

    public $national_identification;

    public $commercial_register;

    public $import_export_number;

    public $nbc_number;

    public $phone_number;

    public $email;

    public $physical_address;

    protected $rules = [
        'name' => 'required|string|max:255',
        'business_category' => 'nullable|string|max:255',
        'tax_id' => 'nullable|string|max:50',
        'code' => 'nullable|string|max:50',
        'national_identification' => 'nullable|string|max:50',
        'commercial_register' => 'nullable|string|max:50',
        'import_export_number' => 'nullable|string|max:50',
        'nbc_number' => 'nullable|string|max:50',
        'phone_number' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'physical_address' => 'nullable|string|max:255',
    ];

    public function submitForm()
    {
        $validatedData = $this->validate();

        try {
            $debug = CompanyService::createCompany($validatedData);
            session()->flash('message', 'Company created successfully!');

            $this->reset();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating the company.');

        }
    }

    public function render()
    {
        return view('livewire.admin.company.company-create');
    }
}
