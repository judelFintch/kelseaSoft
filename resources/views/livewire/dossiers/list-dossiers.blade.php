<div>
    <main>
        <a href="{{ route('dossiers.create')}}"><button>Nouveau Dossier</button></a>
        <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
            <div x-data="{ pageName: `Liste des Dossiers` }">
                <include src="./partials/breadcrumb.html" />
            </div>
            <div
                class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full">
                        <!-- table header start -->
                        <thead>
                            <tr class="border-gray-100 border-y dark:border-gray-800">
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Numéro de dossier
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Client
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Type de marchandise
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Valeur déclarée
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Statut
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Actions
                                        </p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- table header end -->

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($dossiers as $dossier)
                            <!-- table item -->
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ $dossier->file_number }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $dossier->client->name }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ $dossier->goods_type }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ number_format($dossier->declared_value, 2) }} {{ $dossier->currency }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="rounded-full px-2 py-0.5 text-theme-xs font-medium
                                            {{ $dossier->status == 'pending' ? 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500' : '' }}
                                            {{ $dossier->status == 'validated' ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500' : '' }}
                                            {{ $dossier->status == 'completed' ? 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500' : '' }}">
                                            {{ ucfirst($dossier->status) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('dossiers.show', $dossier->id) }}" class="text-blue-600 dark:text-blue-400">Voir</a>
                                        <a href="{{ route('dossiers.edit', $dossier->id) }}" class="text-yellow-600 dark:text-yellow-400">Modifier</a>
                                        <button wire:click="delete({{ $dossier->id }})" class="text-red-600 dark:text-red-400">Supprimer</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $dossiers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
