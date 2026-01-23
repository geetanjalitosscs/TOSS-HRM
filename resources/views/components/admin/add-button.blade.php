@props([
    'label' => '+ Add',
    'onClick' => null,
    'icon' => null,
    'class' => ''
])

<div class="{{ $class ?: 'mb-3' }} relative" style="z-index: 10; overflow: visible;">
    <button 
        class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform"
        style="transform-origin: center; position: relative; z-index: 10;"
        @if($onClick) onclick="{{ $onClick }}" @endif
    >
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $label }}
    </button>
</div>

