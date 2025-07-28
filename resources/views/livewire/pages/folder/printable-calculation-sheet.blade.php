<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-xl font-bold mb-4">Feuille de calcul - Dossier {{ $folder->folder_number }}</h1>

    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div><strong>Client :</strong> {{ $folder->company?->name ?? $folder->client }}</div>
        <div><strong>Bureau de douane :</strong> {{ $folder->customsOffice?->name }}</div>
        <div><strong>Conteneur :</strong> {{ $folder->container_number }}</div>
        <div><strong>Poids :</strong> {{ number_format($folder->weight,2) }} kg</div>
    </div>

    @if($folder->invoice)
    <h2 class="text-lg font-semibold mb-2">Montants</h2>
    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div><strong>FOB :</strong> {{ number_format($folder->invoice->fob_amount,2) }} USD</div>
        <div><strong>Assurance :</strong> {{ number_format($folder->invoice->insurance_amount,2) }} USD</div>
        <div><strong>Fret :</strong> {{ number_format($folder->invoice->freight_amount,2) }} USD</div>
        <div><strong>CIF :</strong> {{ number_format($folder->invoice->cif_amount,2) }} USD</div>
    </div>
    @endif

    <h2 class="text-lg font-semibold mb-2">Lignes de cotation</h2>
    <table class="w-full text-sm border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Position</th>
                <th class="border px-2 py-1">Description</th>
                <th class="border px-2 py-1">Colis</th>
                <th class="border px-2 py-1 text-right">Poids Brut</th>
                <th class="border px-2 py-1 text-right">Poids Net</th>
                <th class="border px-2 py-1 text-right">FOB</th>
            </tr>
        </thead>
        <tbody>
            @foreach($folder->lines as $line)
            <tr>
                <td class="border px-2 py-1">{{ $line->position_code }}</td>
                <td class="border px-2 py-1">{{ $line->description }}</td>
                <td class="border px-2 py-1">{{ $line->colis }}</td>
                <td class="border px-2 py-1 text-right">{{ number_format($line->gross_weight,2) }}</td>
                <td class="border px-2 py-1 text-right">{{ number_format($line->net_weight,2) }}</td>
                <td class="border px-2 py-1 text-right">{{ number_format($line->fob_amount,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
