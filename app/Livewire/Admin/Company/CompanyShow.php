<?php

namespace App\Livewire\Admin\Company;

use Livewire\Component;
use App\Services\Company\CompanyService;

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
