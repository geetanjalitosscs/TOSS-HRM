<div class="relative group" onclick="toggleDropdown(event)" style="overflow: visible;">
    {{ $trigger ?? $slot }}
    <div class="hr-dropdown-menu absolute top-full {{ $position === 'right' ? 'right-0' : 'left-0' }} mt-0 {{ $width }} bg-white rounded-lg shadow-lg border border-purple-100" style="z-index: 9999; display: none;">
        @foreach($items as $item)
            <a href="{{ $item['url'] ?? '#' }}" 
               class="block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50 {{ isset($item['active']) && $item['active'] ? 'bg-purple-50 text-purple-600 font-medium' : '' }}">
                {{ $item['label'] ?? '' }}
            </a>
        @endforeach
    </div>
</div>
