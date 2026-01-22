@props([
    'showSearch' => true,
])

<!-- Sidebar - Fixed -->
<aside class="hr-sidebar" id="hr-sidebar">
    <!-- Sidebar Toggle Button -->
    <button class="hr-sidebar-toggle" id="sidebar-toggle" title="Toggle Sidebar">
        <i class="fas fa-chevron-left sidebar-toggle-icon"></i>
    </button>
    
    <!-- Logo -->
    <div class="hr-sidebar-logo">
        <div class="hr-logo-icon">T</div>
        <div class="ml-3 sidebar-logo-text">
            <div class="text-sm font-bold text-slate-800 tracking-tight">TOAI HR Suite</div>
            <div class="text-[10px] text-purple-500 font-medium">Professional Edition</div>
        </div>
    </div>

    <!-- Search Bar -->
    @if($showSearch)
        <div class="hr-sidebar-search">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-400 text-sm"></i>
                <input type="text" placeholder="Search" class="hr-input-search">
            </div>
        </div>
    @endif

    <!-- Navigation Menu - Scrollable -->
    <nav class="hr-sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('myinfo') }}" class="sidebar-link {{ request()->routeIs('myinfo') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-user-circle"></i> My Info
        </a>
        <a href="{{ route('pim') }}" class="sidebar-link {{ request()->routeIs('pim*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-users"></i> PIM
        </a>
        <a href="{{ route('leave') }}" class="sidebar-link {{ request()->routeIs('leave*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Leave
        </a>
        <a href="{{ route('time') }}" class="sidebar-link {{ request()->routeIs('time*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-user-clock"></i> Time
        </a>
        <a href="{{ route('performance') }}" class="sidebar-link {{ request()->routeIs('performance*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-star"></i> Performance
        </a>
        <a href="{{ route('recruitment') }}" class="sidebar-link {{ request()->routeIs('recruitment*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-briefcase"></i> Recruitment
        </a>
        <a href="{{ route('directory') }}" class="sidebar-link {{ request()->routeIs('directory*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-search"></i> Directory
        </a>
        <a href="{{ route('claim') }}" class="sidebar-link {{ request()->routeIs('claim*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-hand-holding-usd"></i> Claim
        </a>
        <a href="{{ route('buzz') }}" class="sidebar-link {{ request()->routeIs('buzz*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-comments"></i> Buzz
        </a>
        <a href="{{ route('admin') }}" class="sidebar-link {{ request()->routeIs('admin*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-id-card"></i> Admin
        </a>
        <a href="{{ route('maintenance.auth') }}" class="sidebar-link {{ request()->routeIs('maintenance.*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-wrench"></i> Maintenance
        </a>
    </nav>

    <div class="hr-sidebar-footer">
        © {{ date('Y') }} TOAI HR. All rights reserved.
    </div>
</aside>

