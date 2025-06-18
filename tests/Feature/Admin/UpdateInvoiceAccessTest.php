<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\GlobalInvoice;
use App\Livewire\Admin\Invoices\UpdateInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateInvoiceAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_edit_grouped_invoice(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();
        $global = GlobalInvoice::factory()->for($company)->create();
        $invoice = Invoice::factory()->for($company)->create([
            'status' => 'grouped_in_global_invoice',
            'global_invoice_id' => $global->id,
        ]);

        Livewire::test(UpdateInvoice::class, ['invoice' => $invoice->id])
            ->assertRedirect(route('invoices.show', $invoice->id))
            ->assertSessionHas('error');
    }
}
