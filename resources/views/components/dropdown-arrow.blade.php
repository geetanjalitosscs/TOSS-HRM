@props([
    'color' => 'var(--color-hr-primary)',
    'size' => 'text-xs',
    'class' => ''
])

<i class="fas fa-chevron-down ml-1 {{ $size }} {{ $class }}" style="color: {{ $color }};"></i>

