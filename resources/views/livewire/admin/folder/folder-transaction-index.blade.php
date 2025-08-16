<div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold mb-4">Transactions des dossiers</h2>

    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th class="px-3 py-2 text-left">Dossier</th>
                <th class="px-3 py-2 text-left">Date</th>
                <th class="px-3 py-2 text-left">Libellé</th>
                <th class="px-3 py-2 text-right">Montant</th>
                <th class="px-3 py-2 text-left">Devise</th>
                <th class="px-3 py-2 text-left">Type</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200">
            @foreach($transactions as $transaction)
                <tr>
                    <td class="px-3 py-2">
                        <a href="{{ route('folder.transactions', $transaction->folder_id) }}" class="text-indigo-600 hover:underline">
                            {{ $transaction->folder->folder_number ?? '#' . $transaction->folder_id }}
                        </a>
                    </td>
                    <td class="px-3 py-2">{{ optional($transaction->transaction_date)->format('d/m/Y') }}</td>
                    <td class="px-3 py-2">{{ $transaction->label }}</td>
                    <td class="px-3 py-2 text-right">{{ number_format($transaction->amount, 2, ',', ' ') }}</td>
                    <td class="px-3 py-2">{{ $transaction->currency->code ?? '' }}</td>
                    <td class="px-3 py-2">{{ $transaction->type === 'income' ? 'Perçu' : 'Dépense' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $transactions->links('vendor.pagination.tailwind') }}
    </div>
</div>
