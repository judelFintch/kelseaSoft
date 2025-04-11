<div class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                Logo de l’entreprise
            </h4>

            <div class="flex items-center gap-4">
                <div class="w-24 h-24 overflow-hidden rounded-full border border-gray-300 dark:border-gray-700">
                    <img src="{{ $company->logo ? asset($company->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($company->name) }}"
                         alt="Logo {{ $company->name }}" class="w-full h-full object-cover" />
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $company->name }}
                </p>
            </div>
        </div>

        <a href="{{ route('company.edit', $company->id) }}"
            class="flex items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:w-auto">
            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18"
                xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911...Z"/></svg>
            Modifier le logo
        </a>
    </div>
</div>
