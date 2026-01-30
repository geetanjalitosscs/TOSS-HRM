@props([
    'showSearch' => true,
])

<!-- Sidebar - Fixed -->
<aside class="hr-sidebar" id="hr-sidebar">
    <!-- Logo -->
    <div class="hr-sidebar-logo">
        <div class="hr-logo-icon">T</div>
        <div class="ml-3 sidebar-logo-text">
            <div class="text-sm font-bold text-slate-800 tracking-tight">TOAI HR Suite</div>
            <div class="text-[10px] text-purple-500 font-medium">Professional Edition</div>
        </div>
        
        <!-- Sidebar Toggle Button (kept inside logo row to avoid overlap) -->
        <button class="hr-sidebar-toggle" id="sidebar-toggle" title="Toggle Sidebar" type="button">
            <i class="fas fa-chevron-left sidebar-toggle-icon"></i>
        </button>
    </div>

    <!-- Navigation Menu - Scrollable -->
    <nav class="hr-sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('myinfo') }}" class="sidebar-link {{ request()->routeIs('myinfo') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-user-circle"></i> My Info
        </a>
        <a href="{{ route('pim') }}" class="sidebar-link {{ request()->routeIs('pim*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-users"></i> PIM (Personal Information Management)
        </a>
        <a href="{{ route('leave') }}" class="sidebar-link {{ request()->routeIs('leave*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Leave
        </a>
        <a href="{{ route('time') }}" class="sidebar-link {{ request()->routeIs('time*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-user-clock"></i> Time
        </a>
        {{-- <a href="{{ route('performance') }}" class="sidebar-link {{ request()->routeIs('performance*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-star"></i> Performance
        </a> 
        <a href="{{ route('recruitment') }}" class="sidebar-link {{ request()->routeIs('recruitment*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-briefcase"></i> Recruitment
        </a> --}}
        <a href="{{ route('directory') }}" class="sidebar-link {{ request()->routeIs('directory*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-search"></i> Directory
        </a>
        <a href="{{ route('claim') }}" class="sidebar-link {{ request()->routeIs('claim*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-hand-holding-usd"></i> Claim
        </a>
        {{-- <a href="{{ route('buzz') }}" class="sidebar-link {{ request()->routeIs('buzz*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-comments"></i> Buzz
        </a> --}}
        <a href="{{ route('admin') }}" class="sidebar-link {{ request()->routeIs('admin*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-id-card"></i> Admin
        </a>
        {{-- <a href="{{ route('maintenance.auth') }}" class="sidebar-link {{ request()->routeIs('maintenance.*') ? 'sidebar-link--active' : '' }}">
            <i class="fas fa-wrench"></i> Maintenance
        </a> --}}
    </nav>

    <div class="hr-sidebar-footer">
        © {{ date('Y') }} TOAI HR. All rights reserved.
    </div>
</aside>

<!-- Apply collapsed state and scroll position immediately after sidebar renders to prevent flicker -->
<script>
(function() {
    'use strict';
    // Check localStorage and apply collapsed state immediately
    if (localStorage.getItem('hr-sidebar-collapsed') === 'true') {
        const sidebar = document.getElementById('hr-sidebar');
        const body = document.body;
        if (sidebar) {
            sidebar.classList.add('collapsed');
        }
        if (body) {
            body.classList.add('sidebar-collapsed');
        }
    }
    
    // Apply scroll position to active link immediately to prevent scroll jump
    function scrollToActiveLink() {
        const sidebarNav = document.querySelector('.hr-sidebar-nav');
        const activeLink = document.querySelector('.sidebar-link--active');
        
        if (sidebarNav && activeLink) {
            const navHeight = sidebarNav.offsetHeight;
            const linkTop = activeLink.offsetTop;
            const linkHeight = activeLink.offsetHeight;
            
            if (navHeight > 0 && linkTop > 0) {
                // Center the active link in the visible area
                const scrollPosition = linkTop - (navHeight / 2) + (linkHeight / 2);
                // Apply scroll immediately without animation
                sidebarNav.scrollTop = Math.max(0, scrollPosition);
            }
        }
    }
    
    // Try immediately
    scrollToActiveLink();
    
    // Fallback: If layout not ready, use requestAnimationFrame
    if (document.readyState === 'loading') {
        requestAnimationFrame(function() {
            scrollToActiveLink();
        });
    }
})();
</script>

