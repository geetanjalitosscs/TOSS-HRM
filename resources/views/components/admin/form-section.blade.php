@props([
    'title' => '',
    'editMode' => false,
    'showEditToggle' => false
])

@php
    $toggleId = 'edit-toggle-' . uniqid();
    $bgId = 'toggle-bg-' . uniqid();
    $circleId = 'toggle-circle-' . uniqid();
@endphp

<section class="hr-card p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2">
            <i class="fas fa-info-circle text-purple-500"></i> <span class="mt-0.5">{{ $title }}</span>
        </h2>
        @if($showEditToggle)
        <label class="flex items-center gap-2 cursor-pointer">
            <span class="text-sm text-gray-700">Edit</span>
            <div class="relative">
                <input type="checkbox" class="sr-only" id="{{ $toggleId }}" {{ $editMode ? 'checked' : '' }} onchange="toggleEditModeForm(this, '{{ $bgId }}', '{{ $circleId }}')">
                <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 flex items-center {{ $editMode ? 'bg-[var(--color-hr-primary)]' : '' }}" id="{{ $bgId }}">
                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 {{ $editMode ? 'translate-x-5' : 'translate-x-0.5' }}" id="{{ $circleId }}"></div>
                </div>
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
        const inputs = checkbox.closest('.bg-white').querySelectorAll('input[type="text"], input[type="email"], textarea');
        
        // Update toggle visual state
        if (checkbox.checked) {
            bg.classList.add('bg-[var(--color-hr-primary)]');
            bg.classList.remove('bg-gray-200');
            circle.classList.remove('translate-x-0.5');
            circle.classList.add('translate-x-5');
        } else {
            bg.classList.remove('bg-[var(--color-hr-primary)]');
            bg.classList.add('bg-gray-200');
            circle.classList.remove('translate-x-5');
            circle.classList.add('translate-x-0.5');
        }
        
        // Update input fields
        inputs.forEach(input => {
            if (!input.id.includes('edit-toggle')) {
                input.readOnly = !checkbox.checked;
                input.classList.toggle('bg-gray-50', !checkbox.checked);
                input.classList.toggle('bg-white', checkbox.checked);
                input.classList.toggle('text-gray-600', !checkbox.checked);
                input.classList.toggle('text-gray-900', checkbox.checked);
            }
        });
    }
</script>
@endif

