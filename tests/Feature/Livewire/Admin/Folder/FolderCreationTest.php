<?php

namespace Tests\Feature\Livewire\Admin\Folder;

use App\Livewire\Admin\Folder\FolderCreate;
use App\Models\Company;
use App\Models\Currency;
use App\Models\MerchandiseType;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_folder_can_be_created_without_invoice_number(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();
        $currency = Currency::factory()->create(['code' => 'USD']);
        $transporter = Transporter::create([
            'name' => 'Trans',
            'phone' => '123',
            'email' => 't@example.com',
            'country' => 'US',
        ]);
        $type = MerchandiseType::create(['name' => 'Goods']);

        Livewire::test(FolderCreate::class)
            ->set('company_id', $company->id)
            ->set('currency_id', $currency->id)
            ->set('folder_date', now()->toDateString())
            ->set('goods_type', $type->name)
            ->set('dossier_type', 'sans')
            ->set('transporter_id', $transporter->id)
            ->set('truck_number', 'TRK-123')
            ->set('transport_mode', 'Route')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('folders', 1);
        $folder = \App\Models\Folder::first();
        $this->assertNull($folder->invoice_number);
        $this->assertEquals('TRK-123', $folder->truck_number);
        $this->assertEquals($company->id, $folder->company_id);
        $this->assertEquals($type->name, $folder->goods_type);
    }
}
