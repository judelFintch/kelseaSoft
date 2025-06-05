<div>
    <h2 class="text-xl font-semibold mb-4">Liste des agents</h2>
    <div class="mb-4">
        <input wire:model="search" type="text" placeholder="Recherche..." class="border rounded px-2 py-1" />
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $agent)
                <tr>
                    <td class="px-4 py-2">{{ $agent->name }}</td>
                    <td class="px-4 py-2">{{ $agent->email }}</td>
                    <td class="px-4 py-2">{{ $agent->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $agents->links() }}</div>
</div>
