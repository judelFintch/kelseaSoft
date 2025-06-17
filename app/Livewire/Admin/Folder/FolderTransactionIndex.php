<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FolderTransaction;

class FolderTransactionIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $transactions = FolderTransaction::with('folder')->latest()->paginate(15);
        return view('livewire.admin.folder.folder-transaction-index', [
            'transactions' => $transactions,
        ]);
    }
}
