@props([
    'showSearch' => true,
])

<!-- Sidebar - Fixed -->
<aside class="hr-sidebar">
    <!-- Logo -->
    <div class="hr-sidebar-logo">
        <div class="hr-logo-icon">T</div>
        <div class="ml-3">
            <div class="text-sm font-bold text-slate-800 tracking-tight">TOAI HR Suite</div>
            <div class="text-[10px] text-purple-500 font-medium">Professional Edition</div>
        </div>
    </div>

    <!-- Search Bar -->
    @if($showSearch)
        <div class="hr-sidebar-search">
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-400 text-sm">🔍</span>
                <input type="text" placeholder="Search" class="hr-input-search">
            </div>
        </div>
    @endif

    <!-- Navigation Menu - Scrollable -->
    <nav class="hr-sidebar-nav">
        <a href="{{ route('admin') }}" class="sidebar-link {{ request()->routeIs('admin') ? 'sidebar-link--active' : '' }}">
            <span>🛠️</span> Admin
        </a>
        <a href="{{ route('pim') }}" class="sidebar-link {{ request()->routeIs('pim') ? 'sidebar-link--active' : '' }}">
            <span>👥</span> PIM
        </a>
        <a href="{{ route('leave') }}" class="sidebar-link {{ request()->routeIs('leave') ? 'sidebar-link--active' : '' }}">
            <span>🗓️</span> Leave
        </a>
        <a href="{{ route('time') }}" class="sidebar-link {{ request()->routeIs('time') ? 'sidebar-link--active' : '' }}">
            <span>⏱️</span> Time
        </a>
        <a href="{{ route('recruitment') }}" class="sidebar-link {{ request()->routeIs('recruitment') ? 'sidebar-link--active' : '' }}">
            <span>💼</span> Recruitment
        </a>
        <a href="{{ route('myinfo') }}" class="sidebar-link {{ request()->routeIs('myinfo') ? 'sidebar-link--active' : '' }}">
            <span>👤</span> My Info
        </a>
        <a href="{{ route('performance') }}" class="sidebar-link {{ request()->routeIs('performance') ? 'sidebar-link--active' : '' }}">
            <span>📈</span> Performance
        </a>
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}">
            <span>🏠</span> Dashboard
        </a>
        <a href="{{ route('directory') }}" class="sidebar-link {{ request()->routeIs('directory') ? 'sidebar-link--active' : '' }}">
            <span>📇</span> Directory
        </a>
        <a href="{{ route('maintenance.auth') }}" class="sidebar-link {{ request()->routeIs('maintenance.*') ? 'sidebar-link--active' : '' }}">
            <span>🔧</span> Maintenance
        </a>
        <a href="{{ route('claim') }}" class="sidebar-link {{ request()->routeIs('claim') ? 'sidebar-link--active' : '' }}">
            <span>💰</span> Claim
        </a>
        <a href="{{ route('buzz') }}" class="sidebar-link {{ request()->routeIs('buzz') ? 'sidebar-link--active' : '' }}">
            <span>💬</span> Buzz
        </a>
    </nav>

    <div class="hr-sidebar-footer">
        © {{ date('Y') }} TOAI HR. All rights reserved.
    </div>
</aside>

