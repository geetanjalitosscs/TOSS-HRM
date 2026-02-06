@props([
    'id' => null,
    'checked' => false,
    'onChange' => null,
    'bgId' => null,
    'circleId' => null
])

@php
    $toggleId = $id ?? 'toggle-' . uniqid();
    $toggleBgId = $bgId ?? 'toggle-bg-' . uniqid();
    $toggleCircleId = $circleId ?? 'toggle-circle-' . uniqid();
    $isChecked = $checked;
    // Clear visual difference between ON / OFF, using theme primary color
    $onBackgroundStyle = 'background: var(--color-primary); border-color: var(--border-strong);';
    $offBackgroundStyle = 'background: var(--bg-input); border-color: var(--border-default);'; // neutral
@endphp

<div class="relative inline-flex items-center flex-shrink-0" style="width: auto; min-width: 0; min-height: auto;">
    <input 
        type="checkbox" 
        class="sr-only toggle-switch" 
        id="{{ $toggleId }}" 
        {{ $isChecked ? 'checked' : '' }}
        @if($onChange) onchange="{{ $onChange }}" @endif
    >
    <label 
        for="{{ $toggleId }}" 
        class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center border flex-shrink-0"
        id="{{ $toggleBgId }}"
        style="{{ $isChecked ? $onBackgroundStyle : $offBackgroundStyle }}"
    >
        <div 
            class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 {{ $isChecked ? 'translate-x-5' : 'translate-x-0.5' }}"
            id="{{ $toggleCircleId }}"
            style="background: {{ $isChecked ? '#ffffff' : 'var(--bg-card)' }}; border: 1px solid var(--border-default);"
        ></div>
    </label>
</div>

@if(!$onChange)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('{{ $toggleId }}');
        if (toggle) {
            const label = toggle.nextElementSibling;
            const circle = label.querySelector('div');
            
            toggle.addEventListener('change', function() {
                if (this.checked) {
                    // ON state: theme primary color, white knob
                    label.style.background = 'var(--color-primary)';
                    label.style.borderColor = 'var(--border-strong)';
                    circle.style.background = '#ffffff';
                    circle.style.borderColor = '#ffffff';
                    circle.classList.add('translate-x-5');
                    circle.classList.remove('translate-x-0.5');
                } else {
                    // OFF state: neutral grey, default knob
                    label.style.background = 'var(--bg-input)';
                    label.style.borderColor = 'var(--border-default)';
                    circle.style.background = 'var(--bg-card)';
                    circle.style.borderColor = 'var(--border-default)';
                    circle.classList.remove('translate-x-5');
                    circle.classList.add('translate-x-0.5');
                }
            });
        }
    });
</script>
@endif

