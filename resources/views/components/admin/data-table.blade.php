@props([
    'title' => '',
    'records' => [],
    'columns' => [],
    'addButton' => true,
    'addButtonText' => '+ Add',
    'showActions' => true
])

<div>
    @if($title || $addButton)
    <div class="flex items-center justify-between mb-3">
        @if($title)
        <h2 class="text-sm font-bold" style="color: var(--text-primary);">{{ $title }}</h2>
        @endif
        @if($addButton)
        <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-[var(--color-primary-light)] transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
            {{ $addButtonText }}
        </button>
        @endif
    </div>
    @endif

    @if(count($records) > 0)
    <!-- Records Count -->
    <x-records-found :count="count($records)" />
    @endif

    <!-- Table Wrapper -->
    <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
        <!-- Table Header -->
        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
            <div class="flex-shrink-0" style="width: 24px;">
                <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" onfocus="this.style.outline='2px solid var(--color-hr-primary)'" onblur="this.style.outline='none'">
            </div>
            @foreach($columns as $column)
            <div class="{{ $column['class'] ?? 'flex-1' }}" style="min-width: 0;">
                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words {{ isset($column['align']) && $column['align'] === 'center' ? 'text-center' : '' }} {{ isset($column['sortable']) && $column['sortable'] ? 'flex items-center gap-1' : '' }}" style="color: var(--text-primary);">
                    {{ $column['label'] }}
                    @if(isset($column['sortable']) && $column['sortable'])
                    <div class="flex items-center gap-0.5">
                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @if($showActions)
            <div class="flex-shrink-0" style="width: 90px;">
                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
            </div>
            @endif
        </div>

        <!-- Data Rows -->
        <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
            {{ $slot }}
        </div>
    </div>
</div>

