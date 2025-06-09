<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\GlobalInvoice;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GlobalInvoiceIndex extends Component
{
    use WithPagination;

    public string $search = '';
    protected $paginationTheme = 'bootstrap'; // Ou le thème de votre choix si configuré

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteGlobalInvoice(int $id): void
    {
        DB::transaction(function () use ($id) {
            $globalInvoice = GlobalInvoice::with('invoices')->findOrFail($id);

            foreach ($globalInvoice->invoices as $invoice) {
                $invoice->global_invoice_id = null;
                $invoice->status = 'pending';
                $invoice->save();
            }

            $globalInvoice->delete();
        });

        session()->flash('success', 'Facture globale supprimée avec succès.');
    }

    public function render()
    {
        $globalInvoices = GlobalInvoice::with('company') // Eager load la relation company
            ->when($this->search, function ($query) {
                $query->where('global_invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($companyQuery) {
                        $companyQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest() // Ou orderBy('issue_date', 'desc')
            ->paginate(15);

        return view('livewire.admin.invoices.global-invoice-index', [
            'globalInvoices' => $globalInvoices,
        ]);
    }
}
