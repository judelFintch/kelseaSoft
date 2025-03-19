<div class="p-8 bg-gradient-to-br from-gray-100 to-gray-300 dark:from-zinc-900 dark:to-zinc-800 min-h-screen">
   
  <a href="{{route('clients.create')}}"><button type="button" class="btn btn-primary">Nouveau</button></a>
  
  <div class="max-w-7xl mx-auto">
        <!-- Grid Statistiques -->
        <div class="grid gap-6 md:grid-cols-3">
           
            <!-- Total Clients -->
            <div class="relative bg-white dark:bg-zinc-800 shadow-lg rounded-xl p-6 flex flex-col items-center justify-center transition transform hover:scale-105">
                <div class="text-5xl font-bold flex items-center gap-2 text-blue-600 dark:text-blue-300">
                    <span>{{ $totalClients }}</span>
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-lg font-semibold mt-2 text-gray-700 dark:text-gray-300">Total Clients</h3>
            </div>

            <!-- Total Files -->
            <div class="relative bg-white dark:bg-zinc-800 shadow-lg rounded-xl p-6 flex flex-col items-center justify-center transition transform hover:scale-105">
                <div class="text-5xl font-bold flex items-center gap-2 text-green-600 dark:text-green-300">
                    <span>{{ $totalFiles }}</span>
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-semibold mt-2 text-gray-700 dark:text-gray-300">Total Files</h3>
            </div>

            <!-- Total Invoices -->
            <div class="relative bg-white dark:bg-zinc-800 shadow-lg rounded-xl p-6 flex flex-col items-center justify-center transition transform hover:scale-105">
                <div class="text-5xl font-bold flex items-center gap-2 text-red-600 dark:text-red-300">
                    <span>{{ $totalInvoices }}</span>
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="text-lg font-semibold mt-2 text-gray-700 dark:text-gray-300">Total Invoices</h3>
            </div>
        </div>

        <!-- Liste des Clients -->
        <div class="mt-8 p-6 bg-white dark:bg-zinc-800 shadow-lg rounded-xl">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-300">Clients List</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-gray-300 dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-zinc-700 text-gray-700 dark:text-gray-300">
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-3">ID</th>
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-3">Company Name</th>
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-3">Email</th>
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-3">Phone</th>
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-zinc-700 transition duration-150">
                                <td class="px-4 py-3">{{ $client->id }}</td>
                                <td class="px-4 py-3 font-semibold">{{ $client->company_name }}</td>
                                <td class="px-4 py-3">{{ $client->email }}</td>
                                <td class="px-4 py-3">{{ $client->phone }}</td>
                                <td class="px-4 py-3 flex gap-3">
                                    <a href="{{ route('clients.show', $client->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('clients.edit', $client->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:underline">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button wire:click="delete({{ $client->id }})" class="text-red-600 dark:text-red-400 hover:underline">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
