<?php

namespace App\Livewire\Admin\Billing;

use Livewire\Component;
use App\Models\Folder;

class BillingIndex extends Component
{
    public function render()
    {
        $folders = Folder::with('transactions')->get();

        return view('livewire.admin.billing.billing-index', [
            'folders' => $folders,
        ]);
    }
}
