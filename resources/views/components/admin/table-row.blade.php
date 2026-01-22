@props(['record' => []])

<div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
    <div class="flex-shrink-0" style="width: 24px;">
        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" onfocus="this.style.outline='2px solid var(--color-hr-primary)'" onblur="this.style.outline='none'">
    </div>
    {{ $slot }}
    <div class="flex-shrink-0" style="width: 70px;">
        <div class="flex items-center justify-center gap-1">
            <button class="p-0.5 rounded hr-action-delete flex-shrink-0" title="Delete">
                <i class="fas fa-trash-alt w-4 h-4"></i>
            </button>
            <button class="p-0.5 rounded hr-action-edit flex-shrink-0" title="Edit">
                <i class="fas fa-edit w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

