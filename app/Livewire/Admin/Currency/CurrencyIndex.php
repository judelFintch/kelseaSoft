<?php

namespace App\Livewire\Admin\Currency;

use Livewire\Component;
use App\Models\Currency;

class CurrencyIndex extends Component
{

    public $code, $name, $symbol, $exchange_rate;
    public $currencyIdBeingUpdated = null;

    protected function rules()
    {
        return [
            'code' => 'required|string|max:10|unique:currencies,code,' . $this->currencyIdBeingUpdated,
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
        ];
    }

    public function create()
    {
        $this->validate();

        Currency::create([
            'code' => strtoupper($this->code),
            'name' => $this->name,
            'symbol' => $this->symbol,
            'exchange_rate' => $this->exchange_rate,
        ]);

        $this->resetForm();
        session()->flash('success', 'Devise ajoutée avec succès.');
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        $this->currencyIdBeingUpdated = $id;
        $this->code = $currency->code;
        $this->name = $currency->name;
        $this->symbol = $currency->symbol;
        $this->exchange_rate = $currency->exchange_rate;
    }

    public function update()
    {
        $this->validate();

        $currency = Currency::findOrFail($this->currencyIdBeingUpdated);
        $currency->update([
            'code' => strtoupper($this->code),
            'name' => $this->name,
            'symbol' => $this->symbol,
            'exchange_rate' => $this->exchange_rate,
        ]);

        $this->resetForm();
        session()->flash('success', 'Devise mise à jour avec succès.');
    }

    public function delete($id)
    {
        Currency::findOrFail($id)->delete();
        session()->flash('success', 'Devise supprimée.');
    }

    public function setAsDefault($id)
    {
        Currency::query()->update(['is_default' => false]);
        Currency::where('id', $id)->update(['is_default' => true]);
        session()->flash('success', 'Devise par défaut définie.');
    }

    public function resetForm()
    {
        $this->code = '';
        $this->name = '';
        $this->symbol = '';
        $this->exchange_rate = '';
        $this->currencyIdBeingUpdated = null;
    }

    public function render()
    {
        return view('livewire.admin.currency.currency-index', [
            'currencies' => Currency::orderBy('is_default', 'desc')->get(),
        ]);
    }
}
