<div>
    <div>
        <div>
            <div class="space-y-5 sm:space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Liste des licences
                        </h3>
                        <a href="{{ route('licence.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-md hover:bg-brand-600 transition">
                            ➕ Nouvelle Licence
                        </a>
                    </div>
    
                    <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                        <div class="overflow-visible rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="w-full overflow-x-auto overflow-y-visible">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="border-b border-gray-100 dark:border-gray-800 text-theme-xs text-left text-gray-500 dark:text-gray-400">
                                            <th class="px-5 py-3 sm:px-6">Numéro</th>
                                            <th class="px-5 py-3 sm:px-6">Type</th>
                                            <th class="px-5 py-3 sm:px-6 text-center">FOB</th>
                                            <th class="px-5 py-3 sm:px-6 text-center">Poids</th>
                                            <th class="px-5 py-3 sm:px-6 text-center">Dossiers</th>
                                            <th class="px-5 py-3 sm:px-6 text-center">Échéance</th>
                                            <th class="px-5 py-3 sm:px-6 text-left">Actions</th>
                                        </tr>
                                    </thead>
    
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                        @forelse ($licenses as $license)
                                            <tr class="{{ $license->remaining_folders <= 1 ? 'bg-red-50 dark:bg-red-900/20' : '' }}">
                                                <td class="px-5 py-4 sm:px-6 font-medium text-theme-sm text-gray-800 dark:text-white/90">
                                                    {{ $license->license_number }}
                                                </td>
                                                <td class="px-5 py-4 sm:px-6 text-gray-500 text-theme-sm dark:text-gray-400">
                                                    {{ $license->license_type }}
                                                </td>
                                                <td class="px-5 py-4 sm:px-6 text-center text-theme-sm">
                                                    <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                                        {{ number_format($license->remaining_fob_amount, 0) }} {{ $license->currency }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 sm:px-6 text-center text-theme-sm">
                                                    <span class="px-2 py-1 rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                        {{ $license->remaining_weight }} kg
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 sm:px-6 text-center text-theme-sm">
                                                    <span class="px-2 py-1 rounded bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300">
                                                        {{ $license->remaining_folders }} / {{ $license->max_folders }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 sm:px-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                                                    {{ optional($license->expiry_date)->format('d/m/Y') ?? '—' }}
                                                </td>
                                                <td class="px-5 py-4 sm:px-6">
                                                    <div x-data="{ open: false }" class="relative">
                                                        <button @click="open = !open"
                                                            class="text-gray-500 hover:text-gray-700">
                                                            •••
                                                        </button>
                                                        <div x-show="open" @click.away="open = false"
                                                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                                                            <a href="{{ route('licence.show', $license->id) }}"
                                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Afficher</a>
                                                            <a href="{{ route('licence.edit', $license->id) }}"
                                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>
                                                            <button wire:click="delete({{ $license->id }})"
                                                                onclick="return confirm('Confirmer la suppression ?');"
                                                                class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                                Supprimer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-5 py-4 text-center text-sm text-gray-400 dark:text-white/50">
                                                    Aucune licence trouvée.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
    
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $licenses->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
