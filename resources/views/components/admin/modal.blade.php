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
        @if($backdropOnClick) onclick="event.stopPropagation(); {{ $backdropOnClick }}" @endif
    ></div>

    <div 
        class="relative w-full {{ $widthClass }} mx-4 rounded-2xl border shadow-xl flex flex-col"
        style="background-color: var(--bg-card); border-color: var(--border-strong); z-index: 51; pointer-events: auto; max-height: 90vh;"
        onclick="event.stopPropagation();"
    >
        <div class="px-5 py-4 border-b flex-shrink-0 flex items-center justify-between" style="border-color: var(--border-default);">
            <h3 class="text-sm font-bold flex items-center gap-2" style="color: var(--text-primary);">
                @if($icon)
                    <i class="{{ $icon }} text-[var(--color-primary)]"></i>
                @endif
                {{ $title }}
            </h3>
            @if((str_contains($id, 'view-modal') || str_contains($id, 'view')) && !str_contains($id, 'edit'))
                <button 
                    type="button" 
                    onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                    class="hr-btn-secondary px-3 py-1 text-xs"
                >
                    Close
                </button>
            @endif
        </div>

        <div class="px-5 py-4 overflow-y-auto flex-1" style="min-height: 0;">
            {{ $slot }}

            @isset($footer)
                <div class="mt-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>


