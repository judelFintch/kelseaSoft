<div class="w-full max-w-6xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">📋 Factures Générées</h2>
        <input type="text" wire:model.debounce.500ms="search" placeholder="🔍 Rechercher..."
            class="border rounded px-3 py-1 text-sm w-1/3" />
    </div>
    <table class="w-full border mt-4 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">#</th>
                <th class="border px-2 py-1">Facture</th>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Client</th>
                <th class="border px-2 py-1 text-right">Total (USD)</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr>
                    <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-2 py-1 font-semibold">{{ $invoice->invoice_number }}</td>
                    <td class="border px-2 py-1">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                    <td class="border px-2 py-1">{{ $invoice->company->name }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($invoice->total_usd, 2) }}</td>
                    <td class="border px-2 py-1 space-x-2 text-center">
                        <a href="{{ route('invoices.show', $invoice->id) }}"
                            class="text-blue-600 hover:underline text-sm cursor-pointer">
                            👁 Voir
                        </a>

                        <button wire:click="exportPdf({{ $invoice->id }})"
                            class="text-green-600 hover:underline text-sm cursor-pointer">
                            📥 PDF
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">Aucune facture trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>
