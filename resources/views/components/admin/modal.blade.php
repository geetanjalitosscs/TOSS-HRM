@props([
    'id',
    'title',
    'icon' => null,
    'maxWidth' => 'md',
    'backdropOnClick' => null,
])

@php
    $widthClass = match($maxWidth) {
        'xs' => 'max-w-xs',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-md',
    };
@endphp

<div 
    id="{{ $id }}" 
    class="hidden fixed inset-0 z-50 flex items-center justify-center"
>
    <div 
        class="absolute inset-0 bg-black/40"
        @if($backdropOnClick) onclick="{{ $backdropOnClick }}" @endif
    ></div>

    <div 
        class="relative w-full {{ $widthClass }} mx-4 rounded-2xl border shadow-xl"
        style="background-color: var(--bg-card); border-color: var(--border-strong);"
    >
        <div class="px-5 py-4 border-b" style="border-color: var(--border-default);">
            <h3 class="text-sm font-bold flex items-center gap-2" style="color: var(--text-primary);">
                @if($icon)
                    <i class="{{ $icon }} text-purple-500"></i>
                @endif
                {{ $title }}
            </h3>
        </div>

        <div class="px-5 py-4">
            {{ $slot }}

            @isset($footer)
                <div class="mt-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>


