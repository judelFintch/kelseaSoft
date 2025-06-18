<div>
    <div class="fixed top-5 left-2 z-50">
        <!-- Ton code original ici, inchangé -->
        @if (session()->has('message') || session()->has('success') || session()->has('error'))
            @php
                $type = 'success';
                $content = session('message') ?? session('success');
                if (session()->has('error')) {
                    $type = 'error';
                    $content = session('error');
                }
            @endphp
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="rounded-xl border border-{{ $type === 'error' ? 'red' : 'success' }}-500 bg-{{ $type === 'error' ? 'red' : 'success' }}-50 p-4 dark:border-{{ $type === 'error' ? 'red' : 'success' }}-500/30 dark:bg-{{ $type === 'error' ? 'red' : 'success' }}-500/15 mb-6 w-[400px]">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="-mt-0.5 text-{{ $type === 'error' ? 'red' : 'success' }}-500">
                            <!-- icône SVG ici -->
                        </div>
                        <div>
                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                                {{ $type === 'error' ? 'Erreur' : 'Success' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $content }}
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
