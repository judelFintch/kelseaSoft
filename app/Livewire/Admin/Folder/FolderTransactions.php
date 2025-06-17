<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;
use App\Models\FolderTransaction;

class FolderTransactions extends Component
{
    public Folder $folder;
    public $type = 'income';
    public $amount;
    public $label;
    public $transaction_date;

    protected $rules = [
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:0',
        'label' => 'required|string|max:255',
        'transaction_date' => 'nullable|date',
    ];

    public function mount(Folder $folder)
    {
        $this->folder = $folder;
    }

    public function saveTransaction()
    {
        $this->validate();

        $this->folder->transactions()->create([
            'type' => $this->type,
            'amount' => $this->amount,
            'label' => $this->label,
            'transaction_date' => $this->transaction_date,
        ]);

        $this->reset('type', 'amount', 'label', 'transaction_date');
        $this->type = 'income';
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->folder->transactions()->find($id);
        if ($transaction) {
            $transaction->delete();
        }
    }

    public function getBalanceProperty()
    {
        $income = $this->folder->transactions()->where('type', 'income')->sum('amount');
        $expense = $this->folder->transactions()->where('type', 'expense')->sum('amount');
        return $income - $expense;
    }

    public function render()
    {
        $transactions = $this->folder->transactions()->latest()->get();
        return view('livewire.admin.folder.folder-transactions', [
            'transactions' => $transactions,
            'balance' => $this->balance,
        ]);
    }
}
