<div>
    <div class="fixed top-5 left-2 z-50">
        <!-- Ton code original ici, inchangé -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15 mb-6 w-[400px]">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="-mt-0.5 text-success-500">
                            <!-- icône SVG ici -->
                        </div>
                        <div>
                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Success</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ session('message') }}
                            </p>
                        </div>
                    </div>
                    <button @click="show = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition">
                        <!-- bouton de fermeture -->
                    </button>
                </div>
            </div>
        @endif
    </div>



</div>
