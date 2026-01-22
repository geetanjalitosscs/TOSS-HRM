@props(['record' => []])

<div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
    <div class="flex-shrink-0" style="width: 24px;">
        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
    </div>
    {{ $slot }}
    <div class="flex-shrink-0" style="width: 70px;">
        <div class="flex items-center justify-center gap-1">
            <button class="p-0.5 rounded text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all flex-shrink-0" title="Delete">
                <i class="fas fa-trash-alt w-4 h-4"></i>
            </button>
            <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="Edit">
                <i class="fas fa-edit w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

