<?php

namespace App\Livewire\Admin\Billing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Folder;

class BillingIndex extends Component
{
    use WithPagination;

    public $search = '';
    public int $perPage = 10;
    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $folders = Folder::with('transactions', 'company')
            ->when($this->search, function ($query) {
                $query->where('folder_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.billing.billing-index', [
            'folders' => $folders,
        ]);
    }
}
