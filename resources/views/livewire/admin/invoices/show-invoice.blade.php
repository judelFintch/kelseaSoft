<div class="w-full max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    {{-- En-tête de la facture --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🧾 Facture Proforma</h1>
            <p class="text-sm text-gray-600">N° : {{ $invoice->invoice_number }}</p>
            <p class="text-sm text-gray-600">Date : {{ $invoice->invoice_date->format('d/m/Y') }}</p>
            <p class="text-sm text-gray-600">Mode de paiement : {{ ucfirst($invoice->payment_mode) }}</p>
            <p class="text-sm text-gray-600">Code opération : {{ $invoice->operation_code ?? '—' }}</p>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Client :</p>
            <p class="font-semibold text-gray-800">{{ $invoice->company->name }}</p>
            <p class="text-xs text-gray-500">{{ $invoice->company->email }}</p>
            <p class="text-xs text-gray-500">{{ $invoice->company->phone_number }}</p>
            <p class="text-xs text-gray-500">RCCM : {{ $invoice->company->commercial_register }}</p>
            <p class="text-xs text-gray-500">N° Impôt : {{ $invoice->company->tax_id }}</p>
        </div>
    </div>

    {{-- Section pour le Dossier Associé --}}
    @if($invoice->folder)
        <div class="mb-4 p-4 bg-sky-50 border border-sky-200 rounded-md">
            <h4 class="text-md font-semibold mb-1 text-sky-700">Dossier Associé</h4>
            <p>
                <a href="{{ route('folder.show', $invoice->folder->id) }}" class="text-blue-600 hover:underline font-medium">
                    Voir Dossier N° {{ $invoice->folder->folder_number ?? 'N/A' }}
                </a>
            </p>
            <p class="text-sm text-gray-600 mt-1">
                Référence client du dossier : {{ $invoice->folder->company?->name ?? ($invoice->folder->client ?? 'N/A') }}
            </p>
        </div>
    @endif
    {{-- Fin Section Dossier Associé --}}

    {{-- Informations douanières --}}
    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
        <div><strong>Produit :</strong> {{ $invoice->product ?? '—' }}</div>
        <div><strong>Poids :</strong> {{ $invoice->weight ?? '—' }} Kg</div>
        <div><strong>FOB :</strong> {{ number_format($invoice->fob_amount, 2) }} USD</div>
        <div><strong>Fret :</strong> {{ number_format($invoice->freight_amount, 2) }} USD</div>
        <div><strong>Assurance :</strong> {{ number_format($invoice->insurance_amount, 2) }} USD</div>
        <div><strong>CIF :</strong> {{ number_format($invoice->cif_amount, 2) }} USD</div>
        <div><strong>Devise :</strong> {{ $invoice->currency->code ?? 'USD' }}</div>
        <div><strong>Taux de change :</strong> {{ number_format($invoice->exchange_rate, 2) }}</div>
    </div>

    {{-- Lignes de facture groupées par catégorie --}}
    @foreach(['import_tax' => 'A. IMPORT DUTY & TAXES', 'agency_fee' => 'B. AGENCY FEES', 'extra_fee' => 'C. AUTRES FRAIS'] as $category => $label)
        @php $items = $invoice->items->where('category', $category); @endphp
        @if($items->count())
            <div class="border-t pt-4">
                <h2 class="text-lg font-semibold mb-2">{{ $label }}</h2>
                <table class="w-full text-sm border border-gray-200 mb-2">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">Libellé</th>
                            <th class="border px-2 py-1 text-right">Montant (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="border px-2 py-1">{{ $item->label }}</td>
                                <td class="border px-2 py-1 text-right">{{ number_format($item->amount_usd, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach

    {{-- Totaux --}}
    <div class="border-t pt-4">
        <table class="w-full text-sm">
            <tr>
                <td class="text-right font-semibold pr-4">💰 Total (USD) :</td>
                <td class="text-right font-bold text-lg text-gray-800">{{ number_format($invoice->total_usd, 2) }} USD</td>
            </tr>
            <tr>
                <td class="text-right font-semibold pr-4">💱 Montant Converti (CDF) :</td>
                <td class="text-right font-bold text-lg text-gray-800">{{ number_format($invoice->converted_total, 2) }} CDF</td>
            </tr>
        </table>
    </div>

    {{-- Bouton PDF --}}
    <div class="text-right">
        <button wire:click="downloadPdf"
            class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            📥 Télécharger PDF
        </button>
    </div>
</div>
