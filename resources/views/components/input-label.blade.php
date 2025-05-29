@props([
    'label' => '',
    'model' => '',
    'type' => 'text',
    'placeholder' => '',
    'step' => null,
])

<div class="space-y-1">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        @if ($step) step="{{ $step }}" @endif
        wire:model.defer="{{ $model }}"
        {{ $attributes->merge(['class' => 'dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90']) }}
    />

    @error($model)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
