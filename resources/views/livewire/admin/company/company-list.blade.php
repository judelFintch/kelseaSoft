<div>
    <div>
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Liste des entreprises
                    </h3>
                </div>
               
                <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <!-- ====== Table Start -->
                    <div class="overflow-visible rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="w-full overflow-x-auto overflow-y-visible">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6 text-left">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Nom
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6 text-left">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Catégorie
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6 text-left">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Téléphone
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6 text-left">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Statut
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6 text-left">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Code
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6 text-left">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Actions
                                            </p>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse ($companies as $company)
                                        <tr>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 overflow-hidden rounded-full">
                                                        <img src="{{ $company->logo ?? 'https://ui-avatars.com/api/?name=' . urlencode($company->name) }}"
                                                            alt="{{ $company->name }}" />
                                                    </div>
                                                    <div>
                                                        <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                            {{ $company->name }}
                                                        </span>
                                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                                            {{ $company->email ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6 text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $company->business_category ?? '—' }}
                                            </td>
                                            <td class="px-5 py-4 sm:px-6 text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $company->phone_number ?? '—' }}
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <span
                                                    class="rounded-full px-2 py-0.5 text-theme-xs font-medium
                                                    {{ $company->status === 'active'
                                                        ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500'
                                                        : 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500' }}">
                                                    {{ ucfirst($company->status) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6 text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $company->code ?? '—' }}
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div x-data="{ open: false }" class="relative">
                                                    <button @click="open = !open"
                                                        class="text-gray-500 hover:text-gray-700">
                                                        •••
                                                    </button>
                                                    <div x-show="open" @click.away="open = false"
                                                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                                                        <a href="{{ route('company.show', $company->id) }}"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Afficher</a>
                                                        <a href="{{ route('company.edit', $company->id) }}"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>

                                                        <button wire:click="confirmDelete({{ $company->id }})"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');"
                                                            class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                            Supprimer
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-5 py-4 text-center text-sm text-gray-400 dark:text-white/50">
                                                Aucune entreprise trouvée.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $companies->links('vendor.pagination.tailwind') }}
                    </div>
                    <!-- ====== Table End -->
                </div>
            </div>
        </div>
    </div>
</div>
