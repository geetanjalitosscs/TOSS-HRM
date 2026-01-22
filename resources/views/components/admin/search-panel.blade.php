@props([
    'title' => 'Search',
    'collapsible' => true,
    'collapsed' => false
])

@php
    $panelId = 'search-panel-' . uniqid();
@endphp

<div class="rounded-lg p-3 mb-3 border border-purple-100" style="background-color: var(--bg-hover);">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-bold" style="color: var(--text-primary);">{{ $title }}</h3>
        @if($collapsible)
        <button onclick="toggleSearchPanel{{ $panelId }}()" class="transition-colors" style="color: var(--text-muted);" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i class="fas fa-chevron-up text-sm" id="chevron-{{ $panelId }}"></i>
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
    const chevron = document.getElementById('chevron-{{ $panelId }}');
    if (panel) {
        panel.classList.toggle('hidden');
        if (chevron) {
            chevron.classList.toggle('fa-chevron-up');
            chevron.classList.toggle('fa-chevron-down');
        }
    }
}
</script>

