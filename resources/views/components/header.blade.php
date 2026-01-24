@props(['title'])

<!-- Top bar - Fixed at top, Professional Lavender Theme -->
<header class="hr-header">
    <h1 class="hr-header-title">{{ $title }}</h1>
    <div class="hr-header-actions">
        <button class="hr-theme-toggle" data-theme-toggle title="Toggle theme">
            <i class="fas fa-moon theme-icon"></i>
        </button>
        <button class="hr-btn-upgrade">
            <i class="fas fa-arrow-up"></i> Upgrade
        </button>
        <div class="hr-user-menu relative group" data-profile-dropdown-trigger data-logout-url="{{ route('logout') }}" onclick="toggleProfileDropdown(event)">
            <div class="hr-user-avatar">A</div>
            <span class="hr-user-name">Admin</span>
            <x-dropdown-arrow color="#a78bfa" />
        </div>
    </div>
</header>

