<?php

namespace App\Livewire\Admin\Payroll;

use Livewire\Component;
use App\Models\Payroll;
use Livewire\WithPagination;

class PayrollIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $payrolls = Payroll::with('agent')
            ->when($this->search, function ($query) {
                $query->whereHas('agent', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('pay_date', 'desc')
            ->paginate(10);

        return view('livewire.admin.payroll.payroll-index', [
            'payrolls' => $payrolls,
        ])->layout('layouts.app');
    }
}
