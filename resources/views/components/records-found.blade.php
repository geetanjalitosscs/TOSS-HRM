@props([
    'count' => 0,
    'label' => 'Records Found',
    'showWhenEmpty' => true
])

@if($count > 0 || $showWhenEmpty)
<div class="mb-3">
    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border" style="background-color: var(--color-hr-primary-light); border-color: var(--color-hr-primary-soft);">
        @if($count > 0)
        <span class="inline-flex items-center justify-center min-w-6 h-6 px-2 rounded-full border text-xs font-bold" style="background-color: var(--color-hr-primary-dark); border-color: var(--color-hr-primary-soft); color: #FFFFFF;">
            {{ $count }}
        </span>
        <span class="text-xs font-semibold" style="color: var(--color-hr-primary-dark);">{{ $label }}</span>
        @else
        <span class="text-xs font-semibold" style="color: var(--text-primary);">No {{ $label }}</span>
        @endif
    </div>
</div>
@endif

