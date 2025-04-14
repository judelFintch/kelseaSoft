<div>
    @props([
    'label' => '',
    'model' => '',
])

<div>
    <label for="{{ $model }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}
    </label>
    <input type="date" id="{{ $model }}" wire:model.defer="{{ $model }}"
        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
    @error($model)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>

</div>