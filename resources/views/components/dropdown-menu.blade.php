<div class="relative group" onclick="toggleDropdown(event)" style="overflow: visible;">
    {{ $trigger ?? $slot }}
    <div class="hr-dropdown-menu absolute top-full {{ $position === 'right' ? 'right-0' : 'left-0' }} mt-0 {{ $width }} rounded-lg shadow-lg border border-purple-100" style="z-index: 9999; display: none; background-color: var(--bg-card);">
        @foreach($items as $item)
            <a href="{{ $item['url'] ?? '#' }}" 
               class="block px-4 py-2 text-xs transition-colors {{ isset($item['active']) && $item['active'] ? 'font-medium' : '' }}"
               style="color: {{ isset($item['active']) && $item['active'] ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }}; background-color: {{ isset($item['active']) && $item['active'] ? 'var(--bg-hover)' : 'transparent' }};"
               onmouseover="if(!this.classList.contains('active')) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }"
               onmouseout="if(!this.classList.contains('active')) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                {{ $item['label'] ?? '' }}
            </a>
        @endforeach
    </div>
</div>
