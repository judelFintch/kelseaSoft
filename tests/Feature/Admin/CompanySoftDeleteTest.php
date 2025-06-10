<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Services\Company\CompanyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanySoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_soft_deletes_and_restores_a_company(): void
    {
        $company = Company::factory()->create();

        CompanyService::deleteCompany($company->id);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'is_deleted' => true,
        ]);

        CompanyService::restoreCompany($company->id);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'is_deleted' => false,
        ]);
    }
}

