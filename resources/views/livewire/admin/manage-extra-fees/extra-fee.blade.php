<div class="space-y-6">

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">🔧 Frais Divers</h2>
        <button wire:click="toggleForm" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            {{ $showForm ? 'Annuler' : '➕ Ajouter un frais' }}
        </button>
    </div>

    @if ($showForm)
        <div class="bg-gray-100 p-4 rounded space-y-4">
            <x-forms.input label="Code" model="code" />
            <x-forms.input label="Libellé" model="label" />
            <x-forms.textarea label="Description" model="description" />

            <div class="flex justify-end space-x-2">
                @if ($isEdit)
                    <button wire:click="update" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        💾 Mettre à jour
                    </button>
                @else
                    <button wire:click="save" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        💾 Enregistrer
                    </button>
                @endif
            </div>
        </div>
    @endif

    <div class="overflow-x-auto border rounded">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Code</th>
                    <th class="px-4 py-2">Libellé</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($extraFees as $i => $fee)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2">{{ $fee->code }}</td>
                        <td class="px-4 py-2">{{ $fee->label }}</td>
                        <td class="px-4 py-2">{{ $fee->description }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <button wire:click="edit({{ $fee->id }})"
                                class="text-yellow-600 hover:underline">✏️</button>
                            <button wire:click="delete({{ $fee->id }})" class="text-red-600 hover:underline"
                                onclick="return confirm('Confirmer la suppression ?')">🗑️</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
