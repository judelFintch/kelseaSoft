<?php

namespace App\Livewire\Admin\CashRegister;

use Livewire\Component;
use App\Models\CashRegister;
use App\Models\Currency;

class CashRegisterIndex extends Component
{
    public $name;
    public $balance = 0;
    public $currency_id;
    public $currencies = [];

    public function mount()
    {
        $this->currencies = Currency::all();
        $this->currency_id = $this->currencies->first()->id ?? null;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'balance' => 'numeric',
        'currency_id' => 'required|exists:currencies,id',
    ];

    public function create()
    {
        $this->validate();

        CashRegister::create([
            'name' => $this->name,
            'balance' => $this->balance,
            'currency_id' => $this->currency_id,
        ]);

        $this->reset(['name', 'balance', 'currency_id']);
        session()->flash('success', 'Caisse créée avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.cash-register.cash-register-index', [
            'cashRegisters' => CashRegister::with('currency')->get(),
            'currencies' => $this->currencies,
        ]);
    }
}
