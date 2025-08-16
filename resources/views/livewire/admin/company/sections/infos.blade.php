<div class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 bg-white dark:bg-white/[0.03] shadow-sm">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div class="w-full">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h3.586a1 1 0 01.707.293l1.414 1.414A1 1 0 0013.414 6H17a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                </svg>
                Informations de l’entreprise
            </h4>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-2 2xl:gap-x-24">
                @php
                    $infoItems = [
                        ['icon' => '🏢', 'label' => 'Nom', 'value' => $company->name ?? '—'],
                        ['icon' => '🔠', 'label' => 'Acronyme', 'value' => $company->acronym ?? '—'],
                        ['icon' => '📂', 'label' => 'Catégorie', 'value' => $company->business_category ?? '—'],
                        ['icon' => '📞', 'label' => 'Téléphone', 'value' => $company->phone_number ?? '—'],
                        ['icon' => '✉️', 'label' => 'Email', 'value' => $company->email ?? '—'],
                        ['icon' => '🌐', 'label' => 'Site Web', 'value' => $company->website ?? '—'],
                        ['icon' => '📍', 'label' => 'Adresse', 'value' => $company->physical_address ?? '—'],
                        ['icon' => '🏳️', 'label' => 'Pays', 'value' => $company->country ?? '—'],
                        ['icon' => '🆔', 'label' => 'Code', 'value' => $company->code ?? '—'],
                        ['icon' => '🟢', 'label' => 'Statut', 'value' => ucfirst($company->status), 'status' => true],
                    ];
                @endphp

                @foreach ($infoItems as $item)
                    <div>
                        <p class="mb-1 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                            <span class="text-sm">{{ $item['icon'] }}</span> {{ $item['label'] }}
                        </p>
                        <p class="text-sm font-medium
                            {{ isset($item['status']) ?
                                ($company->status === 'active' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400')
                                : 'text-gray-800 dark:text-white/90' }}">
                            {{ $item['value'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bouton Modifier -->
        <a href="{{ route('company.edit', $company->id) }}"
           class="mt-4 lg:mt-0 flex items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 shadow hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] dark:hover:text-white transition-all">
            ✏️ Modifier
        </a>
    </div>
</div>
