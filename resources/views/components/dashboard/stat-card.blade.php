<div>
    @props(['title', 'value', 'icon', 'color' => 'indigo'])

    <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 shadow flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $title }}</p>
            <h3 class="text-2xl font-bold mt-1 text-{{ $color }}-600 dark:text-{{ $color }}-400">{{ $value }}</h3>
        </div>
        <div class="text-3xl text-{{ $color }}-400 dark:text-{{ $color }}-300">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    
</div>