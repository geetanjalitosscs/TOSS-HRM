@props([
    'title' => 'Search',
    'collapsible' => true,
    'collapsed' => false
])

@php
    $panelId = 'search-panel-' . uniqid();
@endphp

<div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-bold" style="color: var(--text-primary);">{{ $title }}</h3>
        @if($collapsible)
        <button onclick="toggleSearchPanel{{ $panelId }}()" class="transition-colors" style="color: var(--text-muted);" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <!-- Arrow removed -->
        </button>
        @endif
    </div>
    <div id="search-panel-content-{{ $panelId }}" class="{{ $collapsed ? 'hidden' : '' }}">
        {{ $slot }}
    </div>
</div>

<script>
function toggleSearchPanel{{ $panelId }}() {
    const panel = document.getElementById('search-panel-content-{{ $panelId }}');
    if (panel) {
        panel.classList.toggle('hidden');
    }
}
</script>

