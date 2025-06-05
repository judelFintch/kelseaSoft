<div>
    <h2 class="text-xl font-semibold mb-4">Enregistrer une paie</h2>
    <form wire:submit.prevent="createPayroll" class="space-y-4">
        <div>
            <label class="block mb-1">Agent</label>
            <select wire:model="agent_id" class="border rounded px-2 py-1 w-full">
                <option value="">-- Sélectionner --</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
            @error('agent_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1">Montant</label>
            <input type="number" wire:model="amount" step="0.01" class="border rounded px-2 py-1 w-full" />
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1">Date de paie</label>
            <input type="date" wire:model="pay_date" class="border rounded px-2 py-1 w-full" />
            @error('pay_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1">Statut</label>
            <select wire:model="status" class="border rounded px-2 py-1 w-full">
                <option value="pending">En attente</option>
                <option value="paid">Payé</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
