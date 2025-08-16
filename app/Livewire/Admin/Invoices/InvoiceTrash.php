<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;
use App\Models\GlobalInvoice;

class InvoiceTrash extends Component
{
    use WithPagination;

    public function restoreInvoice(int $id): void
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();
        session()->flash('success', 'Facture restaurée avec succès.');
    }

    public function restoreGlobalInvoice(int $id): void
    {
        $globalInvoice = GlobalInvoice::onlyTrashed()->findOrFail($id);
        $globalInvoice->restore();
        session()->flash('success', 'Facture globale restaurée avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.invoices.invoice-trash', [
            'trashedInvoices' => Invoice::onlyTrashed()->with('company')->paginate(10),
            'trashedGlobalInvoices' => GlobalInvoice::onlyTrashed()->with('company')->paginate(10),
        ]);
    }
}
