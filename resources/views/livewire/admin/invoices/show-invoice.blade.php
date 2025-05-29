<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🧾 Facture Proforma</h1>
            <p class="text-sm text-gray-600">N° : {{ $invoice->invoice_number }}</p>
            <p class="text-sm text-gray-600">Date : {{ $invoice->invoice_date->format('d/m/Y') }}</p>
            <p class="text-sm text-gray-600">Mode de paiement : {{ ucfirst($invoice->payment_mode) }}</p>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Client :</p>
            <p class="font-semibold text-gray-800">{{ $invoice->company->name }}</p>
            <p class="text-xs text-gray-500">{{ $invoice->company->email }}</p>
            <p class="text-xs text-gray-500">{{ $invoice->company->phone_number }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
        <div><strong>Produit :</strong> {{ $invoice->product ?? '—' }}</div>
        <div><strong>Poids :</strong> {{ $invoice->weight ?? '—' }}</div>
        <div><strong>FOB :</strong> {{ number_format($invoice->fob_amount, 2) }} USD</div>
        <div><strong>Fret :</strong> {{ number_format($invoice->freight_amount, 2) }} USD</div>
        <div><strong>Assurance :</strong> {{ number_format($invoice->insurance_amount, 2) }} USD</div>
        <div><strong>CIF :</strong> {{ number_format($invoice->cif_amount, 2) }} USD</div>
    </div>

    <div class="border-t pt-4">
        <h2 class="text-lg font-semibold mb-2">🧾 Lignes de facture</h2>
        <table class="w-full text-sm border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Catégorie</th>
                    <th class="border px-2 py-1">Libellé</th>
                    <th class="border px-2 py-1 text-right">Montant (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td class="border px-2 py-1">{{ strtoupper($item->category) }}</td>
                        <td class="border px-2 py-1">{{ $item->label }}</td>
                        <td class="border px-2 py-1 text-right">{{ number_format($item->amount_usd, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50 font-bold">
                    <td colspan="2" class="border px-2 py-1 text-right">TOTAL</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($invoice->total_usd, 2) }} USD</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-right">
        <button wire:click="downloadPdf" class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            📥 Télécharger PDF
        </button>
    </div>
</div>
