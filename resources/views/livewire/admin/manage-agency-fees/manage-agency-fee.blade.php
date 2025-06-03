<div class="w-full mx-auto p-6 bg-white rounded-xl shadow space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">🏢 Gestion des frais agence</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Bouton d'ajout --}}
    <div class="flex justify-between items-center">
        <input type="text" wire:model.debounce.300ms="search"
               placeholder="🔍 Rechercher..." class="border rounded px-3 py-2 w-1/3" />
        <button wire:click="showForm"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            ➕ Ajouter un frais
        </button>
    </div>

    {{-- Formulaire dynamique --}}
    @if ($showForm)
        <div class="bg-gray-50 p-4 rounded-lg shadow-inner space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold">Code</label>
                    <input type="text" wire:model.defer="code" class="w-full border rounded px-3 py-2">
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold">Libellé</label>
                    <input type="text" wire:model.defer="label" class="w-full border rounded px-3 py-2">
                    @error('label') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold">Description</label>
                <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button wire:click="$set('showForm', false)"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Annuler
                </button>
                @if ($isEditMode)
                    <button wire:click="update"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        💾 Mettre à jour
                    </button>
                @else
                    <button wire:click="save"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        💾 Enregistrer
                    </button>
                @endif
            </div>
        </div>
    @endif

    {{-- Tableau --}}
    <table class="w-full mt-6 border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Code</th>
                <th class="border px-4 py-2">Libellé</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fees as $i => $fee)
                <tr class="text-sm">
                    <td class="border px-4 py-2">{{ $fees->firstItem() + $i }}</td>
                    <td class="border px-4 py-2 font-mono">{{ $fee->code }}</td>
                    <td class="border px-4 py-2">{{ $fee->label }}</td>
                    <td class="border px-4 py-2 text-gray-600">{{ $fee->description }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <button wire:click="edit({{ $fee->id }})"
                                class="text-blue-600 hover:underline text-xs">✏️ Modifier</button>
                        <button wire:click="delete({{ $fee->id }})"
                                class="text-red-600 hover:underline text-xs"
                                onclick="confirm('Confirmer la suppression ?') || event.stopImmediatePropagation()">
                            🗑 Supprimer
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Aucun frais trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $fees->links() }}
    </div>
</div>
