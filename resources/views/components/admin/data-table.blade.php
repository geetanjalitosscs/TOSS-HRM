@props([
    'title' => '',
    'records' => [],
    'columns' => [],
    'addButton' => true,
    'addButtonText' => '+ Add',
    'showActions' => true
])

<div>
    <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-bold text-slate-800">{{ $title }}</h2>
            @if($addButton)
            <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                {{ $addButtonText }}
            </button>
            @endif
        </div>

        <!-- Records Count -->
        <div class="mb-3 text-xs text-slate-600 font-medium">
            ({{ count($records) }}) Records Found
        </div>

        <!-- Table Wrapper -->
        <div class="hr-table-wrapper">
            <!-- Table Header -->
            <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                </div>
                @foreach($columns as $column)
                <div class="{{ $column['class'] ?? 'flex-1' }}" style="min-width: 0;">
                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words {{ isset($column['align']) && $column['align'] === 'center' ? 'text-center' : '' }} {{ isset($column['sortable']) && $column['sortable'] ? 'flex items-center gap-1' : '' }}">
                        {{ $column['label'] }}
                        @if(isset($column['sortable']) && $column['sortable'])
                        <i class="fas fa-sort text-gray-400"></i>
                        @endif
                    </div>
                </div>
                @endforeach
                @if($showActions)
                <div class="flex-shrink-0" style="width: 70px;">
                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                </div>
                @endif
            </div>

            <!-- Data Rows -->
            <div class="border border-gray-200 border-t-0 rounded-b-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

