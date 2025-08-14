<div>
    <!-- ===== Main Content Start ===== -->
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
            <!-- Titre du Tableau de Bord -->
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-2xl font-semibold text-slate-800 dark:text-white">
                    Tableau de Bord KelseaSoft
                </h2>
                <!-- Section Raccourcis -->
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('folder.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        Nouveau Dossier
                    </a>
                   
                    <a href="{{ route('admin.global-invoices.index') }}" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-warning px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Factures Globales
                    </a>
                     <a href="{{ route('licence.list') }}" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7h1a2 2 0 012 2v1a2 2 0 01-2 2H7m6 0v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h3.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15z"></path></svg>
                        Gérer les Licences
                    </a>
                </div>
            </div>

            <!-- Section Indicateurs (KPIs) -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5 mb-8">
                <!-- KPI Card Start -->
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-sky-100 dark:bg-sky-800">
                        <svg class="fill-sky-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 20H7V22H17V20ZM20.31 2.92999L18.89 1.51999L17.48 2.92999L16.07 1.51999L14.66 2.92999L13.25 1.51999L11.84 2.92999L10.43 1.51999L9.02 2.92999L7.61 1.51999L6.2 2.92999L4.79 1.51999L3.38 2.92999L2.73 2.26999L1.5 3.5L3 5V19H21V5L22.5 3.5L21.27 2.26999L20.31 2.92999ZM19 17H5V5.00001H19V17Z"/></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $totalCompanies }}</h4>
                            <span class="text-sm font-medium text-slate-500">Total Clients</span>
                        </div>
                    </div>
                </div>
                <!-- KPI Card End -->
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-sky-100 dark:bg-sky-800">
                         <svg class="fill-sky-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $totalFolders }}</h4>
                            <span class="text-sm font-medium text-slate-500">Total Dossiers</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-sky-100 dark:bg-sky-800">
                         <svg class="fill-sky-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10v11h6M3 10l6-6m0 0l6 6M12 4v7h6M12 4a2 2 0 10-4 0v7h-2a2 2 0 00-2 2v11h10V13a2 2 0 00-2-2h-2V4z"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $foldersThisMonth }}</h4>
                            <span class="text-sm font-medium text-slate-500">Dossiers (Mois)</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-800">
                         <svg class="fill-emerald-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $totalInvoices }}</h4>
                            <span class="text-sm font-medium text-slate-500">Total Factures</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                     <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-800">
                         <svg class="fill-emerald-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $invoicesThisMonth }}</h4>
                            <span class="text-sm font-medium text-slate-500">Factures (Mois)</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
                        <svg class="fill-purple-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $totalGlobalInvoices }}</h4>
                            <span class="text-sm font-medium text-slate-500">Factures Globales</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-teal-100 dark:bg-teal-800">
                        <svg class="fill-teal-600 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7h1a2 2 0 012 2v1a2 2 0 01-2 2H7m6 0v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h3.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15z"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $activeLicences }}</h4>
                            <span class="text-sm font-medium text-slate-500">Licences Actives</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white px-7.5 py-6 shadow-default dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-800">
                        <svg class="fill-orange-500 dark:fill-white" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-slate-800 dark:text-white">{{ $expiringSoonLicences }}</h4>
                            <span class="text-sm font-medium text-slate-500">Licences Expirant Bientôt</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====== Placeholder pour futurs graphiques ====== -->
            <!--
            <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
                <div class="col-span-12 xl:col-span-8">
                    Commentaire: Placeholder pour futur graphique ChartOne
                </div>
                <div class="col-span-12 xl:col-span-4">
                    Commentaire: Placeholder pour futur graphique ChartTwo
                </div>
                 <div class="col-span-12 xl:col-span-7">
                    Commentaire: Placeholder pour futur graphique ChartThree (Statistics)
                </div>
                 <div class="col-span-12 xl:col-span-5">
                    Commentaire: Placeholder pour futur graphique MapOne (Customers Demographic)
                </div>
            </div>
            -->
            <!-- ====== Fin Placeholder Graphiques ====== -->


            <!-- Section Listes Récentes -->
            <div class="mt-7.5 grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-3 2xl:gap-7.5">
                 <!-- Derniers Clients Ajoutés -->
                <div class="col-span-12 xl:col-span-1">
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-default dark:border-slate-800 dark:bg-slate-900 sm:p-7.5">
                        <h4 class="mb-6 text-xl font-semibold text-slate-800 dark:text-white">
                            Derniers Clients Ajoutés
                        </h4>
                        @if($latestCompanies->isNotEmpty())
                            <div class="flex flex-col gap-5">
                                @foreach ($latestCompanies as $company)
                                    <a href="{{ route('company.show', $company->id) }}" class="block rounded-md p-3 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <h5 class="text-md font-medium text-slate-700 dark:text-white">{{ $company->name }}</h5>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $company->email ?? 'Email non disponible' }}</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Ajouté le: {{ $company->created_at->format('d/m/Y') }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-500 py-4">Aucun client récent.</p>
                        @endif
                    </div>
                </div>

                <!-- Derniers Dossiers Créés -->
                 <div class="col-span-12 xl:col-span-1">
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-default dark:border-slate-800 dark:bg-slate-900 sm:p-7.5">
                        <h4 class="mb-6 text-xl font-semibold text-slate-800 dark:text-white">
                            Derniers Dossiers Créés
                        </h4>
                        @if($latestFolders->isNotEmpty())
                            <div class="flex flex-col gap-5">
                                @foreach ($latestFolders as $folder)
                                    <a href="{{ route('folder.show', $folder->id) }}" class="block rounded-md p-3 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <h5 class="text-md font-medium text-slate-700 dark:text-white">N° {{ $folder->folder_number ?? 'N/A' }}</h5>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Client: {{ $folder->company?->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Créé le: {{ $folder->created_at->format('d/m/Y') }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-500 py-4">Aucun dossier récent.</p>
                        @endif
                    </div>
                </div>

                <!-- Dernières Factures Créées -->
                 <div class="col-span-12 xl:col-span-1">
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-default dark:border-slate-800 dark:bg-slate-900 sm:p-7.5">
                        <h4 class="mb-6 text-xl font-semibold text-slate-800 dark:text-white">
                            Dernières Factures Créées
                        </h4>
                        @if($latestInvoices->isNotEmpty())
                            <div class="flex flex-col gap-5">
                                @foreach ($latestInvoices as $invoice)
                                     <a href="{{ route('invoices.show', $invoice->id) }}" class="block rounded-md p-3 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <h5 class="text-md font-medium text-slate-700 dark:text-white">N° {{ $invoice->invoice_number }}</h5>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Client: {{ $invoice->company?->name ?? 'N/A' }}</p>
                                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">
                                            {{ number_format($invoice->total_usd, 2, ',', ' ') }} {{-- $invoice->currency?->code ?? 'USD' --}}
                                        </p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">Statut: {{ $invoice->status ?? 'N/A' }} - Créée le: {{ $invoice->created_at->format('d/m/Y') }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-500 py-4">Aucune facture récente.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Liste des dernières factures globales -->
            <div class="mt-7.5 grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-1 2xl:gap-7.5"> <!-- Prend toute la largeur -->
                 <div class="col-span-12"> <!-- S'assure qu'il prend toute la largeur disponible sur toutes les tailles d'écran -->
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-default dark:border-slate-800 dark:bg-slate-900 sm:p-7.5">
                        <div class="mb-6 flex items-center justify-between">
                            <h4 class="text-xl font-semibold text-slate-800 dark:text-white">
                                Dernières Factures Globales Créées
                            </h4>
                             <a href="{{ route('admin.global-invoices.index') }}" class="text-sm font-medium text-primary hover:underline">Voir tout</a>
                        </div>
                        @if($latestGlobalInvoices->isNotEmpty())
                            <div class="flex flex-col">
                                <div class="overflow-x-auto">
                                    <div class="inline-block min-w-full align-middle">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full table-auto">
                                                <thead class="bg-slate-100 dark:bg-slate-800">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">N° Facture Globale</th>
                                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">Client/Compagnie</th>
                                                        <th class="px-4 py-3 text-right text-sm font-semibold text-slate-600 dark:text-slate-300">Montant Total</th>
                                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">Date Création</th>
                                                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600 dark:text-slate-300">Statut</th>
                                                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600 dark:text-slate-300">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                                                    @foreach ($latestGlobalInvoices as $globalInvoice)
                                                        <tr>
                                                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-200">{{ $globalInvoice->global_invoice_number }}</td>
                                                            <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $globalInvoice->company?->name ?? 'N/A' }}</td>
                                                            <td class="px-4 py-3 text-right text-sm font-medium text-slate-700 dark:text-slate-200">{{ number_format($globalInvoice->total_amount, 2, ',', ' ') }} {{-- Devise --}}</td>
                                                            <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $globalInvoice->created_at->format('d/m/Y') }}</td>
                                                            <td class="px-4 py-3 text-center text-sm text-slate-500 dark:text-slate-400">{{ $globalInvoice->is_paid ? 'Payée' : 'En attente' }}</td>
                                                            <td class="px-4 py-3 text-center">
                                                                <a href="{{ route('admin.global-invoices.show', $globalInvoice->id) }}" class="text-sm font-medium text-primary hover:underline">Voir</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center text-slate-500 py-4">Aucune facture globale récente.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>
    <!-- ===== Main Content End ===== -->
</div>
