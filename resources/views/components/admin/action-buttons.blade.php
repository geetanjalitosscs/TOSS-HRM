@props([
    'resetLabel' => 'Reset',
    'searchLabel' => 'Search',
    'resetOnClick' => null,
    'searchOnClick' => null,
    'resetType' => 'button',
    'searchType' => 'button'
])

<div class="flex justify-end gap-2">
    <button 
        type="{{ $resetType }}"
        class="hr-btn-secondary px-3 py-1.5 text-xs font-medium"
        @if($resetOnClick) onclick="{{ $resetOnClick }}" @endif
    >
        {{ $resetLabel }}
    </button>
    <button 
        type="{{ $searchType }}"
        class="hr-btn-primary px-3 py-1.5 text-xs font-medium"
        @if($searchOnClick) onclick="{{ $searchOnClick }}" @endif
    >
        {{ $searchLabel }}
    </button>
</div>

