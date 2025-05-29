<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use Livewire\WithPagination;

class InvoiceIndex extends Component
{

    use WithPagination;
    public $search = '';

    public function render()
    {
        $invoices = Invoice::with('company')
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', "%{$this->search}%")
                    ->orWhereHas('company', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->latest()
            ->paginate(10);
        return view(
            'livewire.admin.invoices.invoice-index',
            [
                'invoices' => $invoices,
            ]
        );
    }
}
