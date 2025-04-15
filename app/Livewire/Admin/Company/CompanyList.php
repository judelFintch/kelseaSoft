<?php

namespace App\Livewire\Admin\Company;

use App\Services\Company\CompanyService;
use Livewire\Component;
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
            $debug = CompanyService::deleteCompany($id);
            session()->flash('message', 'Entreprise supprimée avec succès.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression.');
        }
    }

    public function render()
    {

        $companies = CompanyService::getAllCompaniesPaginatedBySearch($this->search, 10);

        return view('livewire.admin.company.company-list', [
            'companies' => $companies,
        ]);
    }
}
