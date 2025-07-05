<?php

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Livewire\Component;

class CurrencyUpdate extends Component
{
    public Currency $currency;

    public $code;
    public $name;
    public $symbol;
    public $exchange_rate;

    public function mount(Currency $currency)
    {
        $this->currency = $currency;
        $this->code = $currency->code;
        $this->name = $currency->name;
        $this->symbol = $currency->symbol;
        $this->exchange_rate = $currency->exchange_rate;
    }

    protected function rules()
    {
        return [
            'code' => 'required|string|max:10|unique:currencies,code,' . $this->currency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
        ];
    }

    public function updateCurrency()
    {
        $data = $this->validate();
        $this->currency->update($data);

        session()->flash('success', 'Devise mise à jour avec succès.');

        return redirect()->route('currency.list');
    }

    public function render()
    {
        return view('livewire.admin.currency.currency-update');
    }
}
