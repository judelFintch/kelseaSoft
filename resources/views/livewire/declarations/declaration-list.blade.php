
<div>
<div class="min-h-screen bg-zinc-900 text-white px-4 py-6 md:px-10 md:py-10">
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-white">
                <thead class="bg-zinc-700 text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">N° Déclaration</th>
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($declarations as $declaration)
                        <tr class="border-b border-zinc-700 hover:bg-zinc-700 transition">
                            <td class="px-4 py-3 text-blue-400 font-semibold">{{ $declaration->numero }}</td>
                            <td class="px-4 py-3">{{ $declaration->client }}</td>
                            <td class="px-4 py-3">{{ $declaration->type }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColor = [
                                        'En cours' => 'bg-yellow-500 text-black',
                                        'Validée' => 'bg-green-600 text-white',
                                        'En attente' => 'bg-orange-500 text-white',
                                        'Liquidée' => 'bg-blue-600 text-white',
                                    ][$declaration->statut] ?? 'bg-gray-600 text-white';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                    {{ $declaration->statut }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $declaration->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
