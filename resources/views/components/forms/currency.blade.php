<div>
    @props([
        'label' => '',
        'model' => '',
        'placeholder' => '0.00'
    ])
    
    <div>
        <label for="{{ $model }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
        </label>
        <div class="relative">
            <span class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-500 dark:text-white/30">$</span>
            <input type="number" step="0.01" id="{{ $model }}" wire:model.defer="{{ $model }}"
                placeholder="{{ $placeholder }}"
                class="pl-8 dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
        </div>
        @error($model)
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>
    
</div>