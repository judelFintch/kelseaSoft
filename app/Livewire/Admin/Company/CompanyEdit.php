<?php

namespace App\Livewire\Admin\Company;

use App\Models\Company;
use App\Services\Company\CompanyService;
use Livewire\Component;

class CompanyEdit extends Component
{
    public Company $companyModel;

    public $name;
    public $acronym;
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
    public $website;
    public $country;
    public $status;

    public function mount(Company $company)
    {
        $this->companyModel = $company;
        $this->name = $company->name;
        $this->acronym = $company->acronym;
        $this->business_category = $company->business_category;
        $this->tax_id = $company->tax_id;
        $this->code = $company->code;
        $this->national_identification = $company->national_identification;
        $this->commercial_register = $company->commercial_register;
        $this->import_export_number = $company->import_export_number;
        $this->nbc_number = $company->nbc_number;
        $this->phone_number = $company->phone_number;
        $this->email = $company->email;
        $this->physical_address = $company->physical_address;
        $this->website = $company->website;
        $this->country = $company->country;
        $this->status = $company->status;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:10',
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
            'website' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ];
    }

    public function updateCompany()
    {
        $validated = $this->validate();
        try {
            CompanyService::updateCompany($this->companyModel->id, $validated);
            session()->flash('message', 'Company updated successfully!');
            return redirect()->route('company.show', $this->companyModel->id);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while updating the company.');
        }
    }

    public function render()
    {
        return view('livewire.admin.company.company-edit');
    }
}
