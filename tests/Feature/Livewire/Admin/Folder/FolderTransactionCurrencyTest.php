<?php

namespace Tests\Feature\Livewire\Admin\Folder;

use App\Livewire\Admin\Folder\FolderTransactions;
use App\Models\User;
use App\Models\Folder;
use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderTransactionCurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_can_be_created_with_currency(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $currency = Currency::factory()->create(['code' => 'USD']);
        $folder = Folder::factory()->create(['currency_id' => $currency->id]);

        Livewire::test(FolderTransactions::class, ['folder' => $folder])
            ->set('type', 'income')
            ->set('label', 'Paiement')
            ->set('amount', 100)
            ->set('currency_id', $currency->id)
            ->call('saveTransaction');

        $this->assertDatabaseHas('folder_transactions', [
            'folder_id' => $folder->id,
            'type' => 'income',
            'label' => 'Paiement',
            'amount' => 100,
            'currency_id' => $currency->id,
        ]);
    }
}
