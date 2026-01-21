@props(['title'])

<!-- Top bar - Fixed at top, Professional Lavender Theme -->
<header class="hr-header">
    <h1 class="hr-header-title">{{ $title }}</h1>
    <div class="hr-header-actions">
        <button class="hr-theme-toggle" data-theme-toggle title="Toggle theme">
            <span class="theme-icon">🌙</span>
        </button>
        <button class="hr-btn-upgrade">
            <span>⬆</span> Upgrade
        </button>
        <div class="hr-user-menu">
            <div class="hr-user-avatar">A</div>
            <span class="hr-user-name">Admin</span>
            <span class="text-purple-400">▼</span>
        </div>
        <button class="hr-btn-help">?</button>
    </div>
</header>

