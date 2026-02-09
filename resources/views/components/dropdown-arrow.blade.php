@props([
    'color' => null,
    'size' => 'text-xs',
    'class' => ''
])

<i class="fas fa-chevron-down ml-1 {{ $size }} {{ $class }}" @if($color) style="color: {{ $color }};" @endif></i>

