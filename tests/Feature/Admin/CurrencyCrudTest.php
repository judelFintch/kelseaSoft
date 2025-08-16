<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Currency;
use App\Livewire\Admin\Currency\CurrencyIndex;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CurrencyCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function test_currency_crud_operations(): void
    {
        Livewire::test(CurrencyIndex::class)
            ->set('code', 'GBP')
            ->set('name', 'Livre')
            ->set('symbol', '£')
            ->set('exchange_rate', 1.5)
            ->call('create');

        $currency = Currency::where('code', 'GBP')->first();
        $this->assertNotNull($currency);

        Livewire::test(CurrencyIndex::class)
            ->call('edit', $currency->id)
            ->set('code', 'GBP')
            ->set('name', 'Livre Sterling')
            ->set('symbol', '£')
            ->set('exchange_rate', 1.6)
            ->call('update');

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            'name' => 'Livre Sterling',
            'exchange_rate' => 1.6,
        ]);

        Livewire::test(CurrencyIndex::class)
            ->call('delete', $currency->id);

        $this->assertDatabaseMissing('currencies', ['id' => $currency->id]);
    }
}
