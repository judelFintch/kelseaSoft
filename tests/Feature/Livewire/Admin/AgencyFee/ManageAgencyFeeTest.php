<?php

namespace Tests\Feature\Livewire\Admin\AgencyFee;

use App\Livewire\Admin\ManageAgencyFees\ManageAgencyFee;
use App\Models\AgencyFee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageAgencyFeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_agency_fee(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ManageAgencyFee::class)
            ->set('code', 'AF001')
            ->set('label', 'Agency Fee Test')
            ->set('description', 'Some description')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('agency_fees', [
            'code' => 'AF001',
            'label' => 'Agency Fee Test',
            'description' => 'Some description',
        ]);
    }

    public function test_can_update_agency_fee(): void
    {
        $user = User::factory()->create();
        $fee = AgencyFee::create([
            'code' => 'AF002',
            'label' => 'Old Label',
            'description' => 'Old description',
        ]);

        Livewire::actingAs($user)
            ->test(ManageAgencyFee::class)
            ->call('edit', $fee->id)
            ->set('code', 'AF002-UPDATED')
            ->set('label', 'Updated Label')
            ->set('description', 'Updated description')
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('agency_fees', [
            'id' => $fee->id,
            'code' => 'AF002-UPDATED',
            'label' => 'Updated Label',
            'description' => 'Updated description',
        ]);
    }
}
