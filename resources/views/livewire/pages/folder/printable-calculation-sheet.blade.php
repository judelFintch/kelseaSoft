<div class="p-6 bg-white">
    <h1 class="text-xl font-bold mb-4">Feuille de calcul - Dossier {{ $folder->folder_number }}</h1>

    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div><strong>Client :</strong> {{ $folder->company?->name }}</div>
        <div><strong>Douane :</strong> {{ $folder->customsOffice?->name }}</div>
        <div><strong>Camion :</strong> {{ $folder->truck_number }}</div>
        <div><strong>Conteneur :</strong> {{ $folder->container_number }}</div>
    </div>

    @if ($folder->invoice)
        <div class="mb-6">
            <h2 class="font-semibold">Montants de la facture</h2>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>FOB: {{ number_format($folder->invoice->fob_amount ?? 0, 2) }} USD</div>
                <div>Fret: {{ number_format($folder->invoice->freight_amount ?? 0, 2) }} USD</div>
                <div>Assurance: {{ number_format($folder->invoice->insurance_amount ?? 0, 2) }} USD</div>
                <div>CIF: {{ number_format($folder->invoice->cif_amount ?? 0, 2) }} USD</div>
            </div>
        </div>
    @endif

    <table class="w-full text-sm border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Position</th>
                <th class="border px-2 py-1">Description</th>
                <th class="border px-2 py-1">Colis</th>
                <th class="border px-2 py-1">Poids Brut</th>
                <th class="border px-2 py-1">Poids Net</th>
                <th class="border px-2 py-1">FOB</th>
                <th class="border px-2 py-1">Licence</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($folder->lines as $line)
                <tr>
                    <td class="border px-2 py-1">{{ $line->position_code }}</td>
                    <td class="border px-2 py-1">{{ $line->description }}</td>
                    <td class="border px-2 py-1">{{ $line->colis }}</td>
                    <td class="border px-2 py-1 text-right">{{ $line->gross_weight }}</td>
                    <td class="border px-2 py-1 text-right">{{ $line->net_weight }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($line->fob_amount, 2) }}</td>
                    <td class="border px-2 py-1">{{ $line->license_code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
