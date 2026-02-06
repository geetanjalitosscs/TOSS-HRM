@props([
    'title' => '',
    'editMode' => false,
    'showEditToggle' => false
])

@php
    $toggleId = 'edit-toggle-' . uniqid();
    $bgId = 'toggle-bg-' . uniqid();
    $circleId = 'toggle-circle-' . uniqid();

    // Consistent, high-contrast toggle colors using theme primary color
    $onBackgroundStyle = 'background: var(--color-primary); border-color: var(--border-strong);';
    $offBackgroundStyle = 'background: var(--bg-input); border-color: var(--border-default);'; // neutral
@endphp

<section class="hr-card p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2">
            <i class="fas fa-info-circle text-[var(--color-primary)]"></i> <span class="mt-0.5">{{ $title }}</span>
        </h2>
        @if($showEditToggle)
        <label class="flex items-center gap-2 cursor-pointer">
            <span class="text-sm" style="color: var(--text-primary);">Edit</span>
            <div class="relative">
                <input type="checkbox" class="sr-only" id="{{ $toggleId }}" {{ $editMode ? 'checked' : '' }} onchange="toggleEditModeForm(this, '{{ $bgId }}', '{{ $circleId }}')">
                <label 
                    for="{{ $toggleId }}" 
                    class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center border"
                    id="{{ $bgId }}"
                    style="{{ $editMode ? $onBackgroundStyle : $offBackgroundStyle }}"
                >
                    <div 
                        class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 {{ $editMode ? 'translate-x-5' : 'translate-x-0.5' }}"
                        id="{{ $circleId }}"
                        style="background: {{ $editMode ? '#ffffff' : 'var(--bg-card)' }}; border: 1px solid var(--border-default);"
                    ></div>
                </label>
            </div>
        </label>
        @endif
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
    <div class="mt-4">
        {{ $footer }}
    </div>
    @endif
</section>

@if($showEditToggle)
<script>
    function toggleEditModeForm(checkbox, bgId, circleId) {
        const bg = document.getElementById(bgId);
        const circle = document.getElementById(circleId);
        const section = checkbox.closest('section') || checkbox.closest('.hr-card');
        if (!section) return;
        
        const inputs = section.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], input[type="tel"], textarea, select');
        
        // Update toggle visual state
        if (checkbox.checked) {
            // ON state: theme primary color, white knob
            bg.style.background = 'var(--color-primary)';
            bg.style.borderColor = 'var(--border-strong)';
            circle.style.background = '#ffffff';
            circle.style.borderColor = '#ffffff';
            circle.classList.remove('translate-x-0.5');
            circle.classList.add('translate-x-5');
        } else {
            // OFF state: neutral grey, default knob
            bg.style.background = 'var(--bg-input)';
            bg.style.borderColor = 'var(--border-default)';
            circle.style.background = 'var(--bg-card)';
            circle.style.borderColor = 'var(--border-default)';
            circle.classList.remove('translate-x-5');
            circle.classList.add('translate-x-0.5');
        }
        
        // Update input fields
        inputs.forEach(input => {
            if (!input.id.includes('edit-toggle') && !input.closest('label')) {
                input.readOnly = !checkbox.checked;
                if (checkbox.checked) {
                    input.style.background = 'var(--bg-input)';
                    input.style.color = 'var(--text-primary)';
                } else {
                    input.style.background = 'var(--bg-hover)';
                    input.style.color = 'var(--text-primary)';
                }
            }
        });
    }
    
    // Make function globally available
    window.toggleEditModeForm = toggleEditModeForm;
</script>
@endif

