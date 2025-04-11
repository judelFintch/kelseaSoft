<div class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 bg-white dark:bg-white/[0.03] shadow-sm">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div class="w-full">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
                Autres informations
            </h4>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-2 2xl:gap-x-24">
                @php
                    $extraItems = [
                        ['icon' => '🪪', 'label' => 'Numéro Identité Nationale', 'value' => $company->national_identification ?? '—'],
                        ['icon' => '🏛️', 'label' => 'Registre de commerce', 'value' => $company->commercial_register ?? '—'],
                        ['icon' => '🚢', 'label' => 'N° import/export', 'value' => $company->import_export_number ?? '—'],
                        ['icon' => '📘', 'label' => 'Numéro NBC', 'value' => $company->nbc_number ?? '—'],
                    ];
                @endphp

                @foreach ($extraItems as $item)
                    <div>
                        <p class="mb-1 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                            <span class="text-sm">{{ $item['icon'] }}</span> {{ $item['label'] }}
                        </p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $item['value'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bouton de modification -->
        <a href="{{ route('company.edit', $company->id) }}"
           class="mt-4 lg:mt-0 flex items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 shadow hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05] dark:hover:text-white transition-all">
            🛠️ Modifier
        </a>
    </div>
</div>
