<?php

namespace App\Services\Company;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Exception;

class CompanyService
{
    /**
     * Create a new company using the validated data.
     *
     * @param array $data
     * @return \App\Models\Company
     *
     * @throws \Exception
     */
    public static function createCompany(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Add any additional business logic here if needed.
            return Company::create($data);
        });
    }


    public static function updateCompany($id, $data){
        return DB::transaction(function () use ($id, $data) {
            $company = Company::findOrFail($id);
            $company->update($data);
            return $company;
        });
    }

    public static function deleteCompany($id){
        return DB::transaction(function () use ($id) {
            $company = Company::findOrFail($id);
            $company->delete();
            return $company;
        });
    }
    public static function restoreCompany($id){
        return DB::transaction(function () use ($id) {
            $company = Company::withTrashed()->findOrFail($id);
            $company->restore();
            return $company;
        });
    }
    public static function forceDeleteCompany($id){
        return DB::transaction(function () use ($id) {
            $company = Company::withTrashed()->findOrFail($id);
            $company->forceDelete();
            return $company;
        });
    }
    public static function getCompany($id){
        return DB::transaction(function () use ($id) {
            $company = Company::findOrFail($id);
            return $company;
        });
    }
    public static function getAllCompanies(){
        return DB::transaction(function () {
            $companies = Company::all();
            return $companies;
        });
    }
    public static function getAllCompaniesWithTrashed(){
        return DB::transaction(function () {
            $companies = Company::withTrashed()->get();
            return $companies;
        });
    }
    public static function getAllCompaniesPaginated($perPage = 10){
        return DB::transaction(function () use ($perPage) {
            $companies = Company::paginate($perPage);
            return $companies;
        });
    }
    public static function getAllCompaniesPaginatedBySearch($search, $perPage = 10){
        return DB::transaction(function () use ($search, $perPage) {
            $companies = Company::where('name', 'like', '%'.$search.'%')->paginate($perPage);
            return $companies;
        });
    }
  
    public static function getAllCompaniesBySearch($search){
        return DB::transaction(function () use ($search) {
            $companies = Company::where('name', 'like', '%'.$search.'%')->get();
            return $companies;
        });
    }
}
