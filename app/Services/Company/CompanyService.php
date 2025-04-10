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
}
