@props([
    'collapsible' => true,
    'collapsed' => false
])

<div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-4">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-700">Search</h3>
        @if($collapsible)
        <button onclick="toggleSearchPanel()" class="text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fas fa-chevron-up text-sm"></i>
        </button>
        @endif
    </div>
    <div id="search-panel-content" class="{{ $collapsed ? 'hidden' : '' }}">
        {{ $slot }}
    </div>
</div>

<script>
function toggleSearchPanel() {
    const panel = document.getElementById('search-panel-content');
    if (panel) {
        panel.classList.toggle('hidden');
    }
}
</script>

