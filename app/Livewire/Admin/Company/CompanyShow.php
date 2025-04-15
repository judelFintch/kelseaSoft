<?php

namespace App\Livewire\Admin\Company;

use App\Services\Company\CompanyService;
use Livewire\Component;

class CompanyShow extends Component
{
    public $company;

    public function mount($id)
    {
        $this->company = CompanyService::getCompanyById($id);

    }

    public function render()
    {
        return view('livewire.admin.company.company-show');
    }
}
