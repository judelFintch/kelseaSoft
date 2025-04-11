<div>
    <div class="fixed top-2 right-2 z-50">
        @if ($errors->any())
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 7000)" 
                x-show="show" 
                x-transition 
                class="rounded-xl border border-red-500 bg-red-50 p-4 dark:border-red-500/30 dark:bg-red-500/15 w-[400px]"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="-mt-0.5 text-red-500">
                            <!-- Icône d'erreur -->
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path 
                                    fill-rule="evenodd" 
                                    clip-rule="evenodd" 
                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 
                                    6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 
                                    12C2 17.5228 6.47715 22 12 22ZM13 16H11V14H13V16ZM13 
                                    12H11V8H13V12Z" 
                                    fill="currentColor" 
                                />
                            </svg>
                        </div>
                        <div>
                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Erreur</h4>
                            <ul class="list-disc text-sm pl-5 text-gray-600 dark:text-gray-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path 
                                fill-rule="evenodd" 
                                d="M4.293 4.293a1 1 0 011.414 0L10 
                                8.586l4.293-4.293a1 1 0 111.414 
                                1.414L11.414 10l4.293 4.293a1 1 0 
                                01-1.414 1.414L10 11.414l-4.293 
                                4.293a1 1 0 01-1.414-1.414L8.586 
                                10 4.293 5.707a1 1 0 010-1.414z" 
                                clip-rule="evenodd" 
                            />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
    
</div>