<div>
    @props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, text
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'as' => 'button', // button or a
])

@php
    $base = 'inline-flex items-center font-medium rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2';

    $sizes = [
        'sm' => 'px-3 py-1 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
    ];

    $variants = [
        'primary' => 'text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500',
        'secondary' => 'text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-gray-400 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600',
        'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'text' => 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white underline',
    ];

    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($as === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <x-dynamic-component :component="$icon" class="w-4 h-4 mr-2" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <x-dynamic-component :component="$icon" class="w-4 h-4 mr-2" />
        @endif
        {{ $slot }}
    </button>
@endif
<!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</div>