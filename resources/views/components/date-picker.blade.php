@props([
    'name' => 'date',
    'id' => null,
    'value' => '',
    'label' => '',
    'required' => false,
    'placeholder' => '',
    'readonly' => false,
    'variant' => 'default', // 'default' or 'split' (text input + button)
    'dateFormat' => null, // Custom format function name for split variant
    'class' => '',
    'wrapperClass' => '',
])

@php
    $inputId = $id ?? 'date-' . uniqid();
    $hiddenDateId = $inputId . '-hidden';
@endphp

@if($label)
    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
        {{ $label }}@if($required)<span class="text-red-500">*</span>@endif
    </label>
@endif

@if($variant === 'split')
    {{-- Split variant: text input + button with hidden date input --}}
    <div class="flex items-stretch {{ $wrapperClass }}">
        <input 
            type="text" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            class="hr-input flex-1 px-3 py-2.5 text-sm rounded-l-lg rounded-r-none {{ $class }}"
            readonly
            id="{{ $inputId }}-display"
        >
        <button 
            type="button" 
            class="px-3 py-2.5 flex items-center justify-center rounded-r-lg transition-colors" 
            style="color: var(--text-muted); background-color: var(--bg-hover); border: 1px solid var(--border-default); border-left: 0;"
            onmouseover="this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--text-primary)';"
            onmouseout="this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--text-muted)';"
            onclick="document.getElementById('{{ $hiddenDateId }}').showPicker()"
        >
            <i class="fas fa-calendar-days text-sm"></i>
        </button>
        <input 
            type="date" 
            id="{{ $hiddenDateId }}"
            class="hidden"
            onchange="updateDateDisplay{{ $inputId }}(this.value)"
        >
    </div>
    <script>
        function updateDateDisplay{{ $inputId }}(dateValue) {
            if (!dateValue) return;
            @if($dateFormat)
                // Use custom format function if provided
                @if($dateFormat === 'updateDateDisplay')
                    // Special case: use existing updateDateDisplay function
                    if (typeof updateDateDisplay === 'function') {
                        updateDateDisplay(dateValue);
                    } else {
                        // Fallback: Convert YYYY-MM-DD to YYYY-DD-MM format
                        const [year, month, day] = dateValue.split('-');
                        const formattedDate = `${year}-${day}-${month}`;
                        document.getElementById('{{ $inputId }}-display').value = formattedDate;
                    }
                @elseif($dateFormat === 'updateDateDisplayFrom' || $dateFormat === 'updateDateDisplayTo')
                    // Special case for project-reports: use updateDateDisplay with input name
                    if (typeof updateDateDisplay === 'function') {
                        const inputName = '{{ $dateFormat === 'updateDateDisplayFrom' ? 'date_from' : 'date_to' }}';
                        updateDateDisplay(dateValue, inputName);
                    } else {
                        // Fallback: Convert YYYY-MM-DD to YYYY-DD-MM format
                        const [year, month, day] = dateValue.split('-');
                        const formattedDate = `${year}-${day}-${month}`;
                        document.getElementById('{{ $inputId }}-display').value = formattedDate;
                    }
                @else
                    if (typeof {{ $dateFormat }} === 'function') {
                        document.getElementById('{{ $inputId }}-display').value = {{ $dateFormat }}(dateValue);
                    } else {
                        document.getElementById('{{ $inputId }}-display').value = dateValue;
                    }
                @endif
            @else
                // Default format: YYYY-MM-DD
                document.getElementById('{{ $inputId }}-display').value = dateValue;
            @endif
        }
    </script>
@else
    {{-- Default variant: date input with icon overlay --}}
    <div class="relative {{ $wrapperClass }}">
        <input 
            type="date" 
            id="{{ $inputId }}"
            name="{{ $name }}" 
            value="{{ $value }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            placeholder="{{ $placeholder }}"
            class="hr-input w-full px-3 py-2.5 text-sm rounded-lg pr-10 {{ $class }}"
            style="@if(!$readonly)border-color: var(--border-strong);@endif background-color: var(--bg-input); color: var(--text-primary);"
        >
        <button 
            type="button" 
            class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center transition-colors"
            style="color: var(--color-hr-primary-soft);"
            onmouseover="this.style.color='var(--color-hr-primary)';"
            onmouseout="this.style.color='var(--color-hr-primary-soft)';"
            onclick="document.getElementById('{{ $inputId }}').showPicker()"
        >
            <i class="fas fa-calendar-days text-sm"></i>
        </button>
    </div>
@endif

