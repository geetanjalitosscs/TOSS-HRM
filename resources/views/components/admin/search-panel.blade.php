@props([
    'title' => 'Search',
    'collapsible' => true,
    'collapsed' => false
])

@php
    $panelId = 'search-panel-' . uniqid();
@endphp

<div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-bold text-slate-800">{{ $title }}</h3>
        @if($collapsible)
        <button onclick="toggleSearchPanel{{ $panelId }}()" class="text-gray-400 hover:text-gray-600 transition-colors">
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

