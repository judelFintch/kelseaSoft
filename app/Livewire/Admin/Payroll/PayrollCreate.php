<?php

namespace App\Livewire\Admin\Payroll;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Agent;

class PayrollCreate extends Component
{
    public $agent_id;
    public $amount;
    public $pay_date;
    public $status = 'pending';

    protected function rules()
    {
        return [
            'agent_id' => 'required|exists:agents,id',
            'amount' => 'required|numeric|min:0',
            'pay_date' => 'required|date',
            'status' => 'required|string',
        ];
    }

    public function createPayroll()
    {
        $this->validate();

        Payroll::create([
            'agent_id' => $this->agent_id,
            'amount' => $this->amount,
            'pay_date' => $this->pay_date,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Payroll recorded.');
        return redirect()->route('payrolls.list');
    }

    public function render()
    {
        return view('livewire.admin.payroll.payroll-create', [
            'agents' => Agent::all(),
        ])->layout('layouts.app');
    }
}
