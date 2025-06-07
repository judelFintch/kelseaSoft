<div>
    <div class="max-w-3xl mx-auto py-10 px-6 space-y-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📄 Gestion des types de documents</h2>

        <!-- ✅ Message Flash -->
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- ✅ Formulaire -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <x-forms.input 
                        label="Nom du type de document" 
                        wire:model="name" 
                        placeholder="Ex: Facture, Quittance, etc." 
                    />
                    @error('name') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <!-- ✅ Bouton principal -->
                    <button type="submit"
                            class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        {{ $editingId ? '🔁 Mettre à jour' : '💾 Ajouter' }}
                    </button>

                    <!-- ✅ Annuler -->
                    @if($editingId)
                        <button wire:click="$set('editingId', null)" type="button"
                                class="text-sm text-gray-500 hover:underline">
                            Annuler
                        </button>
                    @endif

                    <!-- ✅ Réinitialiser -->
                    <button wire:click="resetForm" type="button"
                            class="text-sm text-red-500 hover:underline">
                        Réinitialiser tout
                    </button>
                </div>
            </form>
        </div>

        <!-- ✅ Recherche -->
        <div class="space-y-4">
            <x-forms.input 
                wire:model.debounce.300ms="search" 
                placeholder="🔍 Rechercher un type..." 
                class="w-full"
            />

            <!-- ✅ Tableau -->
            <div class="overflow-x-auto rounded-md border dark:border-gray-700 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Nom</th>
                            <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($types as $type)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $type->name }}</td>
                                <td class="px-4 py-2 flex gap-3">
                                    <button wire:click="edit({{ $type->id }})"
                                            class="text-indigo-600 text-xs font-medium hover:underline">
                                        ✏️ Modifier
                                    </button>
                                    <button wire:click="delete({{ $type->id }})"
                                            class="text-red-600 text-xs font-medium hover:underline">
                                        🗑️ Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-gray-500 text-center">
                                    Aucun type de document trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ✅ Pagination -->
            <div class="pt-4">
                {{ $types->links() }}
            </div>
        </div>
    </div>
</div>
