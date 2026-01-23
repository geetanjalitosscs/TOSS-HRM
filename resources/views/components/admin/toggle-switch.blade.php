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
@endphp

<div class="relative">
    <input 
        type="checkbox" 
        class="sr-only toggle-switch" 
        id="{{ $toggleId }}" 
        {{ $isChecked ? 'checked' : '' }}
        @if($onChange) onchange="{{ $onChange }}" @endif
    >
    <label 
        for="{{ $toggleId }}" 
        class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center border {{ $isChecked ? '' : 'bg-gray-200' }}"
        id="{{ $toggleBgId }}"
        style="{{ $isChecked ? 'background: var(--color-hr-primary); border-color: var(--border-strong);' : 'background: #E5E7EB; border-color: #D1D5DB;' }}"
    >
        <div 
            class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 {{ $isChecked ? 'translate-x-5' : 'translate-x-0.5' }}"
            id="{{ $toggleCircleId }}"
            style="background: white;"
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
                    label.style.background = 'var(--color-hr-primary)';
                    label.style.borderColor = 'var(--border-strong)';
                    circle.classList.add('translate-x-5');
                    circle.classList.remove('translate-x-0.5');
                } else {
                    label.style.background = '#E5E7EB';
                    label.style.borderColor = '#D1D5DB';
                    circle.classList.remove('translate-x-5');
                    circle.classList.add('translate-x-0.5');
                }
            });
        }
    });
</script>
@endif

