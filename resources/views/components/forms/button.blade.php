<div>
    @props([
        'type' => 'button',
        'color' => 'purple',
    ])

    @php
        $colors = [
            'brand' => 'bg-brand-500 hover:bg-brand-600',
            'purple' => 'bg-purple-600 hover:bg-purple-700',
        ];
    @endphp

    <button {{ $attributes->merge([
        'type' => $type,
        'class' => 'inline-flex px-4 py-2 text-sm font-medium text-white rounded-lg ' . ($colors[$color] ?? $colors['brand'])
    ]) }}>
        {{ $slot }}
    </button>

</div>