<?php

namespace Tests\Feature\Admin;

use App\Enums\DossierType;
use App\Livewire\Admin\Folder\FolderCreate;
use App\Models\Company;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Licence;
use App\Models\Location;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderLicenseUsageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function folder_creation_with_license_updates_license_counters(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::create(['name' => 'Comp', 'acronym' => 'CMP']);
        $transporter = Transporter::create(['name' => 'Trans']);
        $location = Location::create(['name' => 'Loc']);
        $customsOffice = CustomsOffice::create(['name' => 'Office']);
        $declarationType = DeclarationType::create(['name' => 'Type']);

        $license = Licence::create([
            'license_number' => 'LIC-100',
            'license_type' => 'Import',
            'company_id' => $company->id,
            'max_folders' => 1,
            'remaining_folders' => 1,
            'initial_weight' => 100,
            'remaining_weight' => 100,
            'initial_fob_amount' => 200,
            'remaining_fob_amount' => 200,
            'quantity_total' => 10,
            'remaining_quantity' => 10,
        ]);

        Livewire::actingAs($user)
            ->test(FolderCreate::class)
            ->set('company_id', $company->id)
            ->set('dossier_type', DossierType::AVEC->value)
            ->set('license_id', $license->id)
            ->set('license_code', 'LIC-100')
            ->set('folder_number', 'TEST-001')
            ->set('invoice_number', 'INV-001')
            ->set('folder_date', now()->toDateString())
            ->set('goods_type', 'Goods')
            ->set('transporter_id', $transporter->id)
            ->set('transport_mode', 'Route')
            ->set('weight', 50)
            ->set('quantity', 2)
            ->set('fob_amount', 20)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('folders', [
            'folder_number' => 'TEST-001',
            'license_id' => $license->id,
        ]);

        $license->refresh();
        $this->assertEquals(0, $license->remaining_folders);
        $this->assertEquals(50, $license->remaining_weight);
        $this->assertEquals(180, $license->remaining_fob_amount);
        $this->assertEquals(8, $license->remaining_quantity);
    }
}
