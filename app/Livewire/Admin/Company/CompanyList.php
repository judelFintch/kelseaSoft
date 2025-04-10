<?php

namespace App\Livewire\Admin\Company;

use Livewire\Component;
use App\Services\Company\CompanyService;
use Livewire\WithPagination;

class CompanyList extends Component
{
    use WithPagination;

   
    public $search = '';
    public $perPage = 10;


    public function mount()
    {
        
    }

    public function render()
    {
        $companies = CompanyService::getAllCompaniesPaginated($this->perPage);

        return view('livewire.admin.company.company-list', [
            'companies' => $companies,
        ]);
    }
}
