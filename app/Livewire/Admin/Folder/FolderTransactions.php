<?php

namespace App\Livewire\Admin\Folder;

use Livewire\Component;
use App\Models\Folder;
use App\Models\FolderTransaction;
use App\Models\Currency;
use App\Models\CashRegister;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FolderTransactions extends Component
{
    public Folder $folder;
    public $type = 'income';
    public $amount;
    public $currency_id;
    public $cash_register_id;
    public $label;
    public $transaction_date;
    public $currencies = [];
    public $cashRegisters = [];

    protected $rules = [
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:0',
        'currency_id' => 'required|exists:currencies,id',
        'cash_register_id' => 'required|exists:cash_registers,id',
        'label' => 'required|string|max:255',
        'transaction_date' => 'nullable|date',
    ];

    public function mount(Folder $folder)
    {
        $this->folder = $folder;
        $this->currencies = Currency::all();
        $this->cashRegisters = CashRegister::all();
        $this->currency_id = $folder->currency_id;
        $this->cash_register_id = $this->cashRegisters->first()->id ?? null;
    }

    public function saveTransaction()
    {
        $this->validate();

        $transaction = $this->folder->transactions()->create([
            'type' => $this->type,
            'amount' => $this->amount,
            'currency_id' => $this->currency_id,
            'label' => $this->label,
            'transaction_date' => $this->transaction_date,
            'cash_register_id' => $this->cash_register_id,
            'user_id' => Auth::id(),
        ]);

        if ($transaction->cashRegister) {
            if ($transaction->type === 'income') {
                $transaction->cashRegister->increment('balance', $transaction->amount);
            } else {
                $transaction->cashRegister->decrement('balance', $transaction->amount);
            }
        }

        $this->reset('type', 'amount', 'currency_id', 'cash_register_id', 'label', 'transaction_date');
        $this->type = 'income';
        $this->currency_id = $this->folder->currency_id;
        $this->cash_register_id = $this->cashRegisters->first()->id ?? null;
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->folder->transactions()->find($id);
        if ($transaction) {
            $cash = $transaction->cashRegister;
            if ($cash) {
                if ($transaction->type === 'income') {
                    $cash->decrement('balance', $transaction->amount);
                } else {
                    $cash->increment('balance', $transaction->amount);
                }
            }
            $transaction->delete();
        }
    }

    public function getIncomeProperty()
    {
        return $this->folder->transactions()->where('type', 'income')->sum('amount');
    }

    public function getExpenseProperty()
    {
        return $this->folder->transactions()->where('type', 'expense')->sum('amount');
    }

    public function getBalanceProperty()
    {
        return $this->income - $this->expense;
    }

    public function downloadPdf(): StreamedResponse
    {
        $transactions = $this->folder->transactions()
            ->with(['currency', 'cashRegister'])
            ->orderBy('transaction_date')
            ->get();

        $pdf = Pdf::loadView('pdf.folder_transactions', [
            'folder' => $this->folder,
            'transactions' => $transactions,
            'income' => $this->income,
            'expense' => $this->expense,
            'balance' => $this->balance,
        ]);

        $sanitizedNumber = str_replace(['/', '\\'], '-', $this->folder->folder_number);
        $filename = 'Transactions_Dossier_' . $sanitizedNumber . '.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename
        );
    }

    public function render()
    {
        $transactions = $this->folder->transactions()->latest()->get();
        return view('livewire.admin.folder.folder-transactions', [
            'transactions' => $transactions,
            'balance' => $this->balance,
            'income' => $this->income,
            'expense' => $this->expense,
            'folder' => $this->folder,
        ]);
    }
}
