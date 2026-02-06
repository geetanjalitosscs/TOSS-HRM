@props([
    'count' => 0,
    'label' => 'Records Found',
    'showWhenEmpty' => true
])

@if($count > 0 || $showWhenEmpty)
<div class="mb-3">
    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border" style="background-color: var(--color-primary-light); border-color: var(--color-primary); box-shadow: 0 0 8px rgba(228, 87, 69, 0.2), 0 0 16px rgba(228, 87, 69, 0.1);">
        @if($count > 0)
        <span class="inline-flex items-center justify-center min-w-6 h-6 px-2 rounded-full border text-xs font-bold" style="background-color: var(--color-primary); border-color: var(--color-primary-light); color: #FFFFFF; box-shadow: 0 0 4px rgba(228, 87, 69, 0.3);">
            {{ $count }}
        </span>
        <span class="text-xs font-semibold" style="color: var(--color-primary); font-weight: 600; box-shadow: 0 0 4px rgba(228, 87, 69, 0.2);">{{ $label }}</span>
        @else
        <span class="text-xs font-semibold" style="color: var(--text-primary); font-weight: 600; box-shadow: 0 0 4px rgba(228, 87, 69, 0.2);">No {{ $label }}</span>
        @endif
    </div>
</div>
@endif

