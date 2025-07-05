<div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold mb-4">Comptabilité du dossier</h2>

    <form wire:submit.prevent="saveTransaction" class="space-y-4 mb-6">
        <div class="flex gap-4">
            <select wire:model.defer="type" class="border rounded p-2">
                <option value="income">Montant perçu</option>
                <option value="expense">Dépense</option>
            </select>
            <select wire:model.defer="currency_id" class="border rounded p-2">
                @foreach($currencies as $c)
                    <option value="{{ $c->id }}">{{ $c->code }}</option>
                @endforeach
            </select>
            <select wire:model.defer="cash_register_id" class="border rounded p-2">
                @foreach($cashRegisters as $cr)
                    <option value="{{ $cr->id }}">{{ $cr->name }}</option>
                @endforeach
            </select>
            <input type="text" wire:model.defer="label" placeholder="Libellé" class="border rounded p-2 flex-1">
            <input type="number" step="0.01" wire:model.defer="amount" placeholder="Montant" class="border rounded p-2 w-32">
            <input type="date" wire:model.defer="transaction_date" class="border rounded p-2">
            <button type="submit" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">Ajouter</button>
        </div>
        @error('label') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </form>

    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th class="px-3 py-2 text-left">Date</th>
                <th class="px-3 py-2 text-left">Libellé</th>
                <th class="px-3 py-2 text-right">Montant</th>
                <th class="px-3 py-2 text-left">Devise</th>
                <th class="px-3 py-2 text-left">Caisse</th>
                <th class="px-3 py-2 text-left">Type</th>
                <th class="px-3 py-2"></th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($transactions as $transaction)
                <tr>
                    <td class="px-3 py-2">{{ optional($transaction->transaction_date)->format('d/m/Y') }}</td>
                    <td class="px-3 py-2">{{ $transaction->label }}</td>
                    <td class="px-3 py-2 text-right">{{ number_format($transaction->amount, 2, ',', ' ') }}</td>
                    <td class="px-3 py-2">{{ $transaction->currency->code ?? '' }}</td>
                    <td class="px-3 py-2">{{ $transaction->cashRegister->name ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $transaction->type === 'income' ? 'Perçu' : 'Dépense' }}</td>
                    <td class="px-3 py-2 text-right">
                        <button wire:click="deleteTransaction({{ $transaction->id }})" class="text-red-500">Supprimer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">Aucune transaction</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="font-semibold">
                <td colspan="2" class="px-3 py-2 text-right">Total perçu</td>
                <td class="px-3 py-2 text-right">{{ number_format($income, 2, ',', ' ') }}</td>
                <td>{{ $folder->currency->code ?? '' }}</td>
                <td colspan="3"></td>
            </tr>
            <tr class="font-semibold">
                <td colspan="2" class="px-3 py-2 text-right">Total sortie</td>
                <td class="px-3 py-2 text-right">{{ number_format($expense, 2, ',', ' ') }}</td>
                <td>{{ $folder->currency->code ?? '' }}</td>
                <td colspan="3"></td>
            </tr>
            <tr class="font-semibold">
                <td colspan="2" class="px-3 py-2 text-right">Solde</td>
                <td class="px-3 py-2 text-right">{{ number_format($balance, 2, ',', ' ') }}</td>
                <td>{{ $folder->currency->code ?? '' }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>
