<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
    <h2 class="text-xl font-bold">🗑 Factures Supprimées</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <h3 class="font-semibold mt-4">Factures Individuelles</h3>
    <table class="w-full border mt-2 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Numéro</th>
                <th class="border px-2 py-1">Client</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trashedInvoices as $invoice)
                <tr>
                    <td class="border px-2 py-1">{{ $invoice->invoice_number }}</td>
                    <td class="border px-2 py-1">{{ $invoice->company?->name }}</td>
                    <td class="border px-2 py-1">
                        <button wire:click="restoreInvoice({{ $invoice->id }})" class="text-blue-600 hover:underline">Restaurer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">Aucune facture.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $trashedInvoices->links() }}

    <h3 class="font-semibold mt-8">Factures Globales</h3>
    <table class="w-full border mt-2 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Numéro</th>
                <th class="border px-2 py-1">Client</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trashedGlobalInvoices as $global)
                <tr>
                    <td class="border px-2 py-1">{{ $global->global_invoice_number }}</td>
                    <td class="border px-2 py-1">{{ $global->company?->name }}</td>
                    <td class="border px-2 py-1">
                        <button wire:click="restoreGlobalInvoice({{ $global->id }})" class="text-blue-600 hover:underline">Restaurer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">Aucune facture globale.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $trashedGlobalInvoices->links() }}
</div>
