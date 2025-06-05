<div>
    <h2 class="text-xl font-semibold mb-4">Paie des agents</h2>
    <div class="mb-4">
        <input wire:model="search" type="text" placeholder="Recherche par agent..." class="border rounded px-2 py-1" />
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2">Agent</th>
                <th class="px-4 py-2">Montant</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $payroll)
                <tr>
                    <td class="px-4 py-2">{{ $payroll->agent->name }}</td>
                    <td class="px-4 py-2">{{ $payroll->amount }}</td>
                    <td class="px-4 py-2">{{ $payroll->pay_date }}</td>
                    <td class="px-4 py-2">{{ $payroll->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $payrolls->links() }}</div>
</div>
