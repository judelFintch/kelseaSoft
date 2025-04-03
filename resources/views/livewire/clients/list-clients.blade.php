<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-300 dark:from-zinc-900 dark:to-zinc-800 p-6 md:p-10">

    <!-- En-tête : Titre + Bouton -->
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Gestion des clients</h1>
        <a href="{{ route('clients.create') }}">
            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
                <i class="fas fa-plus mr-2"></i> Nouveau Client
            </button>
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid gap-6 md:grid-cols-3 mb-12">
        <!-- Total Clients -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-md p-6 text-center transition hover:scale-105">
            <div class="text-5xl font-extrabold text-blue-600 dark:text-blue-400 flex items-center justify-center gap-2">
                {{ $totalClients }}
                <i class="fas fa-users"></i>
            </div>
            <p class="mt-2 text-gray-700 dark:text-gray-300 font-semibold">Total Clients</p>
        </div>

        <!-- Total Files -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-md p-6 text-center transition hover:scale-105">
            <div class="text-5xl font-extrabold text-green-600 dark:text-green-400 flex items-center justify-center gap-2">
                {{ $totalFiles }}
                <i class="fas fa-folder-open"></i>
            </div>
            <p class="mt-2 text-gray-700 dark:text-gray-300 font-semibold">Total Dossiers</p>
        </div>

        <!-- Total Invoices -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-md p-6 text-center transition hover:scale-105">
            <div class="text-5xl font-extrabold text-red-600 dark:text-red-400 flex items-center justify-center gap-2">
                {{ $totalInvoices }}
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <p class="mt-2 text-gray-700 dark:text-gray-300 font-semibold">Total Factures</p>
        </div>
    </div>

    <!-- Liste des Clients -->
    <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Liste des Clients</h2>

        <div class="overflow-x-auto rounded-lg">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-200">
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Nom Entreprise</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Téléphone</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr class="border-b border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition">
                            <td class="px-4 py-3">{{ $client->id }}</td>
                            <td class="px-4 py-3 font-medium">{{ $client->company_name }}</td>
                            <td class="px-4 py-3">{{ $client->email }}</td>
                            <td class="px-4 py-3">{{ $client->phone }}</td>
                            <td class="px-4 py-3 flex gap-3">
                                <a href="{{ route('clients.show', $client->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <a href="{{ route('clients.edit', $client->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:underline">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <button wire:click="delete({{ $client->id }})" class="text-red-600 dark:text-red-400 hover:underline">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">Aucun client enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $clients->links() }}
        </div>
    </div>

</div>
