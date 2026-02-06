@props([
    'label' => '+ Add',
    'onClick' => null,
    'icon' => null,
    'class' => ''
])

<div class="{{ $class ?: 'mb-3' }} relative" style="z-index: 10; overflow: visible;">
    <button 
        class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white rounded-lg transition-all duration-200 flex items-center gap-1 hover:scale-105" 
        style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); box-shadow: 0 0 15px rgba(228, 87, 69, 0.2), 0 0 30px rgba(228, 87, 69, 0.1);"
        @if($onClick) onclick="{{ $onClick }}" @endif
    >
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $label }}
    </button>
</div>

