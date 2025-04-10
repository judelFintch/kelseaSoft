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
    public $companyIdToDelete = null;

    public function setCompanyIdToDelete($id)
    {
        $this->companyIdToDelete = $id;
    }

    public function confirmDelete($id)
    {
        try {
            CompanyService::deleteCompany($id);
            session()->flash('message', 'Entreprise supprimée avec succès.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression.');
        }
    }

    public function render()
    {
        $companies = CompanyService::getAllCompaniesPaginated($this->perPage);

        return view('livewire.admin.company.company-list', [
            'companies' => $companies,
        ]);
    }
}
