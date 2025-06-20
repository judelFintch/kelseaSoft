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
    public bool $showTrashed = false;
    protected $paginationTheme = 'bootstrap'; // Ou le thème de votre choix si configuré

    public function getGlobalInvoiceToDeleteProperty()
    {
        return $this->deleteGlobalInvoiceId ? GlobalInvoice::with('company')->find($this->deleteGlobalInvoiceId) : null;
    }

    public ?int $deleteGlobalInvoiceId = null;
    public string $deleteConfirmText = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteGlobalInvoice(int $id): void
    {
        $this->deleteGlobalInvoiceId = $id;
        $this->deleteConfirmText = '';
        $this->dispatch('open-modal', 'confirm-global-invoice-deletion');
    }

    public function deleteGlobalInvoice(): void
    {
        $expected = $this->globalInvoiceToDelete?->global_invoice_number;

        if ($this->deleteConfirmText !== (string) $expected) {
            $this->addError('deleteConfirmText', 'Veuillez saisir le numéro de la facture globale pour confirmer.');
            $this->dispatch('open-modal', 'confirm-global-invoice-deletion');
            return;
        }

        $id = $this->deleteGlobalInvoiceId;

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

        $this->reset(['deleteGlobalInvoiceId', 'deleteConfirmText']);
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
            ->when($this->showTrashed, fn($q) => $q->onlyTrashed())
            ->latest() // Ou orderBy('issue_date', 'desc')
            ->paginate(15);

        return view('livewire.admin.invoices.global-invoice-index', [
            'globalInvoices' => $globalInvoices,
        ]);
    }
}
