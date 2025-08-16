<div>
    @props([
    'label' => '',
    'model' => '',
    'placeholder' => '',
    'rows' => 3,
])

<div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}
    </label>
    <textarea
        wire:model.defer="{{ $model }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder ?: 'Enter ' . strtolower($label) }}"
        {{ $attributes->merge(['class' => 'dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30']) }}
    ></textarea>
    @error($model)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>

</div>