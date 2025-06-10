<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Invoice;
use App\Livewire\Admin\Invoices\InvoiceIndex;
use App\Livewire\Admin\Invoices\InvoiceTrash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->company = Company::factory()->create();
    }

    /** @test */
    public function test_invoice_soft_delete_and_restore(): void
    {
        $invoice = Invoice::factory()->for($this->company)->create();

        Livewire::test(InvoiceIndex::class)
            ->call('deleteInvoice', $invoice->id);

        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);

        Livewire::test(InvoiceTrash::class)
            ->call('restoreInvoice', $invoice->id);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'deleted_at' => null,
        ]);
    }
}
