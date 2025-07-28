<?php

namespace Tests\Feature\Livewire\Admin\Folder;

use App\Livewire\Admin\Folder\FolderExtraFields;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderExtraFieldsPrefillTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_extra_fields_are_prefilled_on_mount(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $folder = Folder::factory()->create([
            'scelle_number' => 'SC123',
            'manifest_number' => 'MN456',
            'incoterm' => 'FOB',
            'customs_regime' => 'Import',
            'additional_code' => 'AC789',
            'quotation_date' => '2024-01-15',
            'opening_date' => '2024-02-20',
            'entry_point' => 'Port',
        ]);

        Livewire::test(FolderExtraFields::class, ['folder' => $folder])
            ->assertSet('scelle_number', 'SC123')
            ->assertSet('manifest_number', 'MN456')
            ->assertSet('incoterm', 'FOB')
            ->assertSet('customs_regime', 'Import')
            ->assertSet('additional_code', 'AC789')
            ->assertSet('quotation_date', '2024-01-15')
            ->assertSet('opening_date', '2024-02-20')
            ->assertSet('entry_point', 'Port');
    }
}
