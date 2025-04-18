<div>
    <div class="p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">📄 Liste des Licences</h2>
            <a href="{{ route('licences.create') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-md hover:bg-brand-600 transition">
                ➕ Nouvelle Licence
            </a>
        </div>
    
        <div class="relative">
            <input type="text" wire:model.debounce.500ms="search"
                   placeholder="🔍 Rechercher une licence..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 dark:bg-gray-900 dark:text-white" />
        </div>
    
        <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200 dark:border-gray-700 mt-4">
            <table class="min-w-full text-sm text-left text-gray-700 dark:text-white">
                <thead class="bg-gray-50 dark:bg-gray-800 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3 text-center">FOB Restant</th>
                        <th class="px-6 py-3 text-center">Poids</th>
                        <th class="px-6 py-3 text-center">Dossiers</th>
                        <th class="px-6 py-3 text-center">Échéance</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($licenses as $license)
                        <tr class="{{ $license->remaining_folders < 2 ? 'bg-red-50 dark:bg-red-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-800/40' }}">
                            <td class="px-6 py-4 font-semibold">{{ $license->license_number }}</td>
                            <td class="px-6 py-4">{{ $license->license_type }}</td>
                            <td class="px-6 py-4 text-center">{{ number_format($license->remaining_fob_amount, 2) }} {{ $license->currency }}</td>
                            <td class="px-6 py-4 text-center">{{ $license->remaining_weight }} kg</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-brand-100 dark:bg-brand-600/20 text-brand-700 dark:text-brand-300">
                                    {{ $license->remaining_folders }} / {{ $license->max_folders }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">{{ optional($license->expiry_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open"
                                            class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                            
                                    <!-- Menu déroulant -->
                                    <div x-show="open" @click.away="open = false"
                                         class="absolute right-0 z-10 mt-2 w-40 origin-top-right bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg">
                                        <div class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                            <a href="{{ route('licences.show', $license->id) }}"
                                               class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">👁️ Voir</a>
                                            <a href=""
                                               class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">✏️ Modifier</a>
                                            <button wire:click="delete({{ $license->id }})"
                                                    onclick="confirm('Confirmer la suppression ?') || event.stopImmediatePropagation()"
                                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                🗑️ Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-white/50">
                                Aucune licence trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <div class="mt-4">
            {{ $licenses->links() }}
        </div>
    </div>
    
    
</div>
