<?php

namespace Tests\Feature\Livewire\Admin\Folder;

use App\Livewire\Admin\Folder\FolderTransactions;
use App\Models\User;
use App\Models\Folder;
use App\Models\Currency;
use App\Models\CashRegister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FolderTransactionCashRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_updates_cash_register_balance_and_records_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $currency = Currency::factory()->create(['code' => 'USD']);
        $cashRegister = CashRegister::factory()->create(['balance' => 0]);
        $folder = Folder::factory()->create(['currency_id' => $currency->id]);

        Livewire::test(FolderTransactions::class, ['folder' => $folder])
            ->set('cash_register_id', $cashRegister->id)
            ->set('type', 'income')
            ->set('label', 'Paiement')
            ->set('amount', 100)
            ->set('currency_id', $currency->id)
            ->call('saveTransaction');

        $this->assertDatabaseHas('folder_transactions', [
            'folder_id' => $folder->id,
            'cash_register_id' => $cashRegister->id,
            'user_id' => $user->id,
            'type' => 'income',
            'amount' => 100,
        ]);

        $this->assertEquals(100, $cashRegister->fresh()->balance);
    }
}
