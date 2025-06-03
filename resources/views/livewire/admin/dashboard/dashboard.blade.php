<div>
    <div class="p-6 mx-auto max-w-screen-2xl">

        <!-- Section Indicateurs (KPIs) -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Statistiques Clés</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                <!-- Total Dossiers -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Total Dossiers</h3>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalFolders }}</p>
                </div>
                <!-- Dossiers ce Mois-ci -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Dossiers (Mois)</h3>
                    <p class="text-4xl font-bold text-blue-500 mt-2">{{ $foldersThisMonth }}</p>
                </div>
                <!-- Total Factures -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Total Factures</h3>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $totalInvoices }}</p>
                </div>
                <!-- Factures ce Mois-ci -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Factures (Mois)</h3>
                    <p class="text-4xl font-bold text-green-500 mt-2">{{ $invoicesThisMonth }}</p>
                </div>
                <!-- Factures Globales -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Factures Globales</h3>
                    <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $totalGlobalInvoices }}</p>
                </div>
                <!-- Licences Actives -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Licences Actives</h3>
                    <p class="text-4xl font-bold text-teal-600 mt-2">{{ $activeLicences }}</p>
                </div>
                <!-- Licences Expirant Bientôt -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-600">Licences Expirant Bientôt (<30j)</h3>
                    <p class="text-4xl font-bold text-orange-500 mt-2">{{ $expiringSoonLicences }}</p>
                </div>
            </div>
        </section>

        <!-- Section Raccourcis -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Accès Rapides</h2>
            <div class="flex flex-wrap gap-4">
                {{-- Vérifier les noms de routes exacts et ajuster si nécessaire --}}
                <a href="{{ route('folder.create') }}" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition duration-150">
                    Nouveau Dossier
                </a>
                <a href="{{ route('invoices.generate') }}" class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition duration-150">
                    Nouvelle Facture
                </a>
                <a href="{{ route('admin.global-invoices.index') }}" class="px-6 py-3 bg-indigo-500 text-white font-semibold rounded-lg shadow hover:bg-indigo-600 transition duration-150">
                    Factures Globales
                </a>
                <a href="{{ route('licence.list') }}" class="px-6 py-3 bg-teal-500 text-white font-semibold rounded-lg shadow hover:bg-teal-600 transition duration-150">
                    Gérer les Licences
                </a>
            </div>
        </section>

        <!-- Section Listes Récentes -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Activités Récentes</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Carte Derniers Dossiers -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Derniers Dossiers</h3>
                    @if($latestFolders->isNotEmpty())
                        <ul class="space-y-3">
                            @foreach ($latestFolders as $folder)
                                <li class="pb-3 border-b border-gray-100 last:border-b-0">
                                    <a href="{{ route('folder.show', $folder->id) }}" class="hover:text-blue-600 transition duration-150">
                                        <p class="font-medium text-gray-700">{{ $folder->folder_number ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ $folder->company?->name ?? 'Compagnie non spécifiée' }}</p>
                                        <p class="text-xs text-gray-400">{{ $folder->created_at->format('d/m/Y H:i') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Aucun dossier récent.</p>
                    @endif
                </div>

                <!-- Carte Dernières Factures -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Dernières Factures</h3>
                    @if($latestInvoices->isNotEmpty())
                        <ul class="space-y-3">
                            @foreach ($latestInvoices as $invoice)
                                <li class="pb-3 border-b border-gray-100 last:border-b-0">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="hover:text-green-600 transition duration-150">
                                        <p class="font-medium text-gray-700">{{ $invoice->invoice_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $invoice->company?->name ?? 'Compagnie non spécifiée' }}</p>
                                        <p class="text-sm text-gray-600 font-semibold">
                                            {{ number_format($invoice->total_usd, 2, ',', ' ') }} USD {{-- Ajuster la devise/champ si nécessaire --}}
                                        </p>
                                        <p class="text-xs text-gray-400">Statut: {{ $invoice->status ?? 'N/A' }} - {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Aucune facture récente.</p>
                    @endif
                </div>

                <!-- Carte Dernières Factures Globales -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Dernières Factures Globales</h3>
                    @if($latestGlobalInvoices->isNotEmpty())
                        <ul class="space-y-3">
                            @foreach ($latestGlobalInvoices as $globalInvoice)
                                <li class="pb-3 border-b border-gray-100 last:border-b-0">
                                    <a href="{{ route('admin.global-invoices.show', $globalInvoice->id) }}" class="hover:text-indigo-600 transition duration-150">
                                        <p class="font-medium text-gray-700">{{ $globalInvoice->global_invoice_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $globalInvoice->company?->name ?? 'Compagnie non spécifiée' }}</p>
                                        <p class="text-sm text-gray-600 font-semibold">
                                            {{ number_format($globalInvoice->total_amount, 2, ',', ' ') }} {{-- Devise à déterminer --}}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $globalInvoice->created_at->format('d/m/Y H:i') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Aucune facture globale récente.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
