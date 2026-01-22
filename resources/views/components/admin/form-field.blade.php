@props([
    'label' => '',
    'required' => false,
    'type' => 'text',
    'name' => '',
    'value' => '',
    'readonly' => false,
    'placeholder' => '',
    'class' => ''
])

<div class="mb-4 {{ $class }}">
    <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @if($type === 'textarea')
    <textarea 
        name="{{ $name }}" 
        {{ $readonly ? 'readonly' : '' }}
        placeholder="{{ $placeholder }}"
        class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-transparent"
        style="border-color: var(--border-default); color: var(--text-primary); background: {{ $readonly ? 'var(--bg-hover)' : 'var(--bg-input)' }};"
    >{{ $value }}</textarea>
    @else
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        value="{{ $value }}"
        {{ $readonly ? 'readonly' : '' }}
        placeholder="{{ $placeholder }}"
        class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-transparent"
        style="border-color: var(--border-default); color: var(--text-primary); background: {{ $readonly ? 'var(--bg-hover)' : 'var(--bg-input)' }};"
    >
    @endif
</div>

