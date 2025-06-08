<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Invoice;
use App\Livewire\Admin\Invoices\ShowInvoice as ShowInvoiceComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvoicePdfDownloadTest extends TestCase
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
    public function test_can_download_invoice_pdf(): void
    {
        $invoice = Invoice::factory()->for($this->company)->create();

        $response = Livewire::test(ShowInvoiceComponent::class, ['invoice' => $invoice])
            ->call('downloadPdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="Facture_' . $invoice->invoice_number . '.pdf"');
    }
}
