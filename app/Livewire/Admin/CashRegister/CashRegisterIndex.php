<?php

namespace App\Livewire\Admin\CashRegister;

use Livewire\Component;
use App\Models\CashRegister;

class CashRegisterIndex extends Component
{
    public $name;
    public $balance = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'balance' => 'numeric',
    ];

    public function create()
    {
        $this->validate();

        CashRegister::create([
            'name' => $this->name,
            'balance' => $this->balance,
        ]);

        $this->reset(['name', 'balance']);
        session()->flash('success', 'Caisse créée avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.cash-register.cash-register-index', [
            'cashRegisters' => CashRegister::all(),
        ]);
    }
}
