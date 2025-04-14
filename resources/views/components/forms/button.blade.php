<div>
    <button {{ $attributes->merge([
        'type' => 'button',
        'class' => 'inline-flex ipx-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600'
    ]) }}>
        {{ $slot }}
    </button>
    
</div>