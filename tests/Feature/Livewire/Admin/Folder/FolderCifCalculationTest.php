<?php

namespace Tests\Feature\Livewire\Admin\Folder;

use App\Livewire\Admin\Folder\FolderCreate;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderCifCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_cif_is_calculated_when_amounts_change(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Currency::factory()->create(['code' => 'USD']);

        Livewire::test(FolderCreate::class)
            ->set('fob_amount', 100)
            ->assertSet('cif_amount', 100.0)
            ->set('insurance_amount', 50)
            ->assertSet('cif_amount', 150.0)
            ->set('freight_amount', 25)
            ->assertSet('cif_amount', 175.0);
    }
}
