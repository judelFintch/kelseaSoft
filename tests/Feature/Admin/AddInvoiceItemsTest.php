<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Tax;
use App\Models\AgencyFee;
use App\Models\ExtraFee;
use App\Livewire\Admin\Invoices\AddInvoiceItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddInvoiceItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_can_be_added_to_invoice(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();
        $invoice = Invoice::factory()->for($company)->create();

        $tax = Tax::factory()->create();
        $agency = AgencyFee::factory()->create();
        $extra = ExtraFee::factory()->create();

        Livewire::test(AddInvoiceItems::class, ['invoice' => $invoice->id])
            ->set('taxItems', [['tax_id' => $tax->id, 'amount_usd' => 10]])
            ->set('agencyFeeItems', [['agency_fee_id' => $agency->id, 'amount_usd' => 20]])
            ->set('extraFeeItems', [['extra_fee_id' => $extra->id, 'amount_usd' => 5]])
            ->call('save');

        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'tax_id' => $tax->id,
            'category' => 'import_tax',
            'amount_usd' => 10,
        ]);

        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'agency_fee_id' => $agency->id,
            'category' => 'agency_fee',
            'amount_usd' => 20,
        ]);

        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'extra_fee_id' => $extra->id,
            'category' => 'extra_fee',
            'amount_usd' => 5,
        ]);
    }
}
