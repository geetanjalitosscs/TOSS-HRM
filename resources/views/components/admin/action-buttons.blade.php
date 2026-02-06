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
        class="hr-btn-secondary px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200 hover:scale-105" 
        style="background: linear-gradient(135deg, var(--text-muted), var(--text-secondary)); color: white; box-shadow: 0 0 10px rgba(107, 114, 128, 0.2), 0 0 20px rgba(107, 114, 128, 0.1);"
        @if($resetOnClick) onclick="{{ $resetOnClick }}" @endif
    >
        {{ $resetLabel }}
    </button>
    <button 
        type="{{ $searchType }}"
        class="hr-btn-primary px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200 hover:scale-105" 
        style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); color: white; box-shadow: 0 0 15px rgba(228, 87, 69, 0.2), 0 0 30px rgba(228, 87, 69, 0.1);"
        @if($searchOnClick) onclick="{{ $searchOnClick }}" @endif
    >
        {{ $searchLabel }}
    </button>
</div>

