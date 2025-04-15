<?php

namespace App\Services\Company;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    /**
     * Crée une nouvelle entreprise avec les données validées.
     *
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function createCompany(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Company::create($data);
        });
    }

    /**
     * Met à jour une entreprise existante.
     *
     * @param  int  $id
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function updateCompany($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $company = Company::notDeleted()->findOrFail($id);
            $company->update($data);

            return $company;
        });
    }

    /**
     * Marque une entreprise comme supprimée (suppression douce).
     *
     * @param  int  $id
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function deleteCompany($id)
    {
        return DB::transaction(function () use ($id) {
            $company = Company::notDeleted()->findOrFail($id);
            $company->update(['is_deleted' => true]);

            return $company;
        });
    }

    /**
     * Restaure une entreprise précédemment supprimée.
     *
     * @param  int  $id
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function restoreCompany($id)
    {
        return DB::transaction(function () use ($id) {
            $company = Company::where('deleted', true)->findOrFail($id);
            $company->update(['deleted' => false]);

            return $company;
        });
    }

    /**
     * Supprime définitivement une entreprise.
     *
     * @param  int  $id
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function forceDeleteCompany($id)
    {
        return DB::transaction(function () use ($id) {
            $company = Company::findOrFail($id);
            $company->delete();

            return $company;
        });
    }

    /**
     * Récupère une entreprise non supprimée par son identifiant.
     *
     * @param  int  $id
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function getCompanyById($id)
    {
        return DB::transaction(function () use ($id) {
            return Company::notDeleted()->findOrFail($id);
        });
    }

    /**
     * Récupère toutes les entreprises non supprimées.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllCompanies()
    {
        return DB::transaction(function () {
            return Company::notDeleted()->get();
        });
    }

    /**
     * Récupère toutes les entreprises, y compris celles supprimées.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllCompaniesWithTrashed()
    {
        return DB::transaction(function () {
            return Company::all(); // Inclut toutes les entreprises, quelle que soit la valeur de 'deleted'
        });
    }

    /**
     * Récupère les entreprises non supprimées avec pagination.
     *
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getAllCompaniesPaginated($perPage = 10)
    {
        return DB::transaction(function () use ($perPage) {
            return Company::notDeleted()->paginate($perPage);
        });
    }

    /**
     * Recherche les entreprises non supprimées par nom avec pagination.
     *
     * @param  string  $search
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getAllCompaniesPaginatedBySearch($search, $perPage = 10)
    {
        return DB::transaction(function () use ($search, $perPage) {
            return Company::notDeleted()
                ->where('name', 'like', '%'.$search.'%')
                ->paginate($perPage);
        });
    }

    /**
     * Recherche les entreprises non supprimées par nom.
     *
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllCompaniesBySearch($search)
    {
        return DB::transaction(function () use ($search) {
            return Company::notDeleted()
                ->where('name', 'like', '%'.$search.'%')
                ->get();
        });
    }
}
