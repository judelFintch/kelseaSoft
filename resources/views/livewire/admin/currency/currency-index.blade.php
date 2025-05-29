<div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h2 class="text-xl font-bold">💱 Gestion des devises</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-3 gap-4">
        <x-forms.input label="Code" model="code" placeholder="USD, CDF..." />
        <x-forms.input label="Nom" model="name" placeholder="Dollar américain" />
        <x-forms.input label="Symbole" model="symbol" placeholder="$, FC..." />
    </div>

    <div class="flex gap-2">
        @if ($currencyIdBeingUpdated)
            <button wire:click="update" class="bg-yellow-500 text-white px-4 py-2 rounded">🔁 Mettre à jour</button>
            <button wire:click="resetForm" class="bg-gray-300 px-4 py-2 rounded">Annuler</button>
        @else
            <button wire:click="create" class="bg-blue-600 text-white px-4 py-2 rounded">💾 Ajouter</button>
        @endif
    </div>

    <table class="w-full mt-4 border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Code</th>
                <th class="border px-2 py-1">Nom</th>
                <th class="border px-2 py-1">Symbole</th>
                <th class="border px-2 py-1">Par défaut</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($currencies as $currency)
                <tr>
                    <td class="border px-2 py-1">{{ $currency->code }}</td>
                    <td class="border px-2 py-1">{{ $currency->name }}</td>
                    <td class="border px-2 py-1">{{ $currency->symbol }}</td>
                    <td class="border px-2 py-1 text-center">
                        @if ($currency->is_default)
                            ✅
                        @else
                            <button wire:click="setAsDefault({{ $currency->id }})"
                                class="text-blue-600 text-xs hover:underline">Définir</button>
                        @endif
                    </td>
                    <td class="border px-2 py-1 space-x-2 text-center">
                        <button wire:click="edit({{ $currency->id }})" class="text-yellow-600 text-sm">✏️</button>
                        <button wire:click="delete({{ $currency->id }})" class="text-red-600 text-sm">🗑️</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

