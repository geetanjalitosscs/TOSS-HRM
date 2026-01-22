@props(['class' => 'flex-1'])

<div class="{{ $class }}" style="min-width: 0;">
    <div class="text-xs {{ isset($bold) && $bold ? 'font-medium text-gray-900' : 'text-gray-700' }} break-words">
        {{ $slot }}
    </div>
</div>

