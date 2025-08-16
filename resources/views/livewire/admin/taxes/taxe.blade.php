<div class="w-full  mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">🧾 Gestion des Taxes</h2>

    @if ($showForm)
        <div class="bg-white p-4 shadow rounded mb-4">
            <div class="grid grid-cols-3 gap-4">
                <x-forms.input label="Code" model="code" />
                <x-forms.input label="Label" model="label" />
            </div>
            <x-forms.textarea label="Description" model="description" class="mt-4" />
            <div class="flex justify-end gap-4 mt-4">
                <button wire:click="resetFields" class="text-gray-600 hover:underline">❌ Annuler</button>
                <button wire:click="save" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    💾 {{ $editMode ? 'Mettre à jour' : 'Créer' }}
                </button>
            </div>
        </div>
    @else
        <div class="flex justify-end mb-4">
            <button wire:click="showCreateForm" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                ➕ Nouvelle Taxe
            </button>
        </div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="w-full table-auto">
            <thead class="bg-gray-100 text-sm text-gray-700">
                <tr>
                    <th class="p-2 text-left">Code</th>
                    <th class="p-2 text-left">Libellé</th>
                    <th class="p-2 text-left">Description</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($taxes as $tax)
                    <tr class="border-t text-sm">
                        <td class="p-2">{{ $tax->code }}</td>
                        <td class="p-2">{{ $tax->label }}</td>
                        <td class="p-2">{{ $tax->description }}</td>
                        <td class="p-2 space-x-2">
                            <button wire:click="showEditForm({{ $tax->id }})"
                                class="text-blue-600 hover:underline">✏️</button>
                            <button wire:click="delete({{ $tax->id }})"
                                class="text-red-600 hover:underline">🗑️</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
