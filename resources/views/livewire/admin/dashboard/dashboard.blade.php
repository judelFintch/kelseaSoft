<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-10 px-6">
    <!-- Title & Action Buttons -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Tableau de Bord KelseaSoft</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Vue d'ensemble des activités récentes</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('folder.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Nouveau Dossier
            </a>
            <a href="{{ route('admin.global-invoices.index') }}" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h6l2 2h6a2 2 0 012 2v12a2 2 0 01-2 2z"/></svg>
                Factures Globales
            </a>
            <a href="{{ route('licence.list') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Gérer les Licences
            </a>
        </div>
    </div>

    <!-- KPIs Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        @php
            $kpis = [
                ['label' => 'Total Clients', 'value' => $totalCompanies, 'icon' => '🏢', 'color' => 'bg-indigo-100'],
                ['label' => 'Total Dossiers', 'value' => $totalFolders, 'icon' => '📁', 'color' => 'bg-blue-100'],
                ['label' => 'Factures (Mois)', 'value' => $invoicesThisMonth, 'icon' => '🧾', 'color' => 'bg-green-100'],
                ['label' => 'Licences Actives', 'value' => $activeLicences, 'icon' => '🔐', 'color' => 'bg-teal-100'],
            ];
        @endphp
        @foreach ($kpis as $kpi)
            <div class="p-6 rounded-xl shadow bg-white dark:bg-slate-800 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $kpi['value'] }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $kpi['label'] }}</p>
                </div>
                <div class="text-3xl {{ $kpi['color'] }} rounded-full p-3">
                    {{ $kpi['icon'] }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Clients -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Clients Récents</h3>
            @forelse($latestCompanies as $company)
                <div class="mb-3">
                    <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $company->name }}</p>
                    <p class="text-sm text-gray-500">{{ $company->email ?? 'Email non défini' }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucun client trouvé.</p>
            @endforelse
        </div>

        <!-- Dossiers -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Dossiers Récents</h3>
            @forelse($latestFolders as $folder)
                <div class="mb-3">
                    <p class="text-gray-700 dark:text-gray-300 font-medium">N° {{ $folder->folder_number }}</p>
                    <p class="text-sm text-gray-500">{{ $folder->company?->name ?? 'Client inconnu' }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucun dossier récent.</p>
            @endforelse
        </div>

        <!-- Factures -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Factures Récentes</h3>
            @forelse($latestInvoices as $invoice)
                <div class="mb-3">
                    <p class="text-gray-700 dark:text-gray-300 font-medium">Facture {{ $invoice->invoice_number }}</p>
                    <p class="text-sm text-gray-500">Montant : {{ number_format($invoice->total_usd, 2, ',', ' ') }} $</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucune facture disponible.</p>
            @endforelse
        </div>
    </div>
</div>
