import './bootstrap';

// Theme Toggle Functionality
(function() {
    'use strict';

    // Check if we're on login page - skip theme functionality
    const isLoginPage = window.location.pathname === '/' || window.location.pathname === '/login';
    if (isLoginPage) {
        // Force light mode on login page and exit
        document.documentElement.setAttribute('data-theme', 'light');
        return;
    }

    // Get theme from localStorage or system preference
    function getInitialTheme() {
        const storedTheme = localStorage.getItem('hr-theme');
        if (storedTheme) {
            return storedTheme;
        }
        // Check system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    // Apply theme
    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('hr-theme', theme);
    }

    // Initialize theme on page load
    const initialTheme = getInitialTheme();
    setTheme(initialTheme);

    // Listen for system theme changes
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            // Only auto-switch if user hasn't manually set a preference
            if (!localStorage.getItem('hr-theme')) {
                setTheme(e.matches ? 'dark' : 'light');
            }
        });
    }

    // Update theme icon based on current theme
    function updateThemeIcon() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const themeToggleButtons = document.querySelectorAll('.hr-theme-toggle, [data-theme-toggle]');
        
        themeToggleButtons.forEach(button => {
            const icon = button.querySelector('.theme-icon');
            if (icon) {
                if (currentTheme === 'dark') {
                    icon.className = 'fas fa-sun theme-icon';
                } else {
                    icon.className = 'fas fa-moon theme-icon';
                }
            }
        });
    }

    // Theme toggle button handler
    document.addEventListener('DOMContentLoaded', function() {
        // Skip theme toggle on login page
        const isLoginPage = window.location.pathname === '/' || window.location.pathname === '/login';
        if (isLoginPage) {
            return;
        }
        
        // Update icon on page load
        updateThemeIcon();
        
        const themeToggleButtons = document.querySelectorAll('.hr-theme-toggle, [data-theme-toggle]');
        
        themeToggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
                updateThemeIcon();
            });
        });
    });
})();

// Profile Dropdown Portal Implementation
function toggleProfileDropdown(event) {
    event.stopPropagation();
    
    const trigger = event.currentTarget || event.target.closest('[data-profile-dropdown-trigger]');
    if (!trigger) return;
    
    const portal = document.getElementById('hr-dropdown-portal');
    if (!portal) return;
    
    // Check if dropdown already exists and is open
    const existingDropdown = portal.querySelector('.hr-profile-dropdown-portal');
    const isOpen = existingDropdown && existingDropdown.style.display !== 'none';
    
    if (isOpen) {
        // Close dropdown
        if (existingDropdown) {
            existingDropdown.style.display = 'none';
        }
        return;
    }
    
    // Close any other dropdowns first
    document.querySelectorAll('.hr-dropdown-menu.show').forEach(menu => {
        menu.classList.remove('show');
    });
    
    // Remove existing portal dropdown if any
    if (existingDropdown) {
        existingDropdown.remove();
    }
    
    // Get trigger position
    const rect = trigger.getBoundingClientRect();
    const scrollY = window.scrollY || window.pageYOffset;
    const scrollX = window.scrollX || window.pageXOffset;
    
    // Calculate position - right aligned, below trigger
    const top = rect.bottom + scrollY;
    const right = window.innerWidth - rect.right - scrollX;
    
    // Get logout URL and CSRF token from data attributes
    const logoutUrl = trigger.dataset.logoutUrl || '/logout';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Create dropdown HTML with POST form for logout
    const dropdownHTML = `
        <div class="hr-profile-dropdown-portal" style="position: fixed; top: ${top}px; right: ${right}px; z-index: 99999; display: block;">
            <div class="hr-dropdown-menu-portal w-48 bg-white rounded-lg shadow-lg border border-purple-100">
                <a href="#" onclick="showAboutModal(event); return false;" class="block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50">About</a>
                <a href="/profile/support" class="block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50">Support</a>
                <a href="/profile/change-password" class="block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50">Change Password</a>
                <form action="${logoutUrl}" method="POST" class="m-0">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50">Logout</button>
                </form>
            </div>
        </div>
    `;
    
    // Insert dropdown into portal
    portal.innerHTML = dropdownHTML;
}

// Show About Modal
function showAboutModal(event) {
    event.preventDefault();
    event.stopPropagation();
    
    // Close dropdown first
    const portal = document.getElementById('hr-dropdown-portal');
    if (portal) {
        const existingDropdown = portal.querySelector('.hr-profile-dropdown-portal');
        if (existingDropdown) {
            existingDropdown.style.display = 'none';
        }
    }
    
    // Fetch about data
    fetch('/profile/about')
        .then(response => response.json())
        .then(data => {
            // Create modal HTML
            const modalHTML = `
                <div id="about-modal-overlay" class="hr-modal-overlay" onclick="closeAboutModal(event)">
                    <div class="hr-modal-content" onclick="event.stopPropagation()">
                        <div class="hr-modal-header">
                            <h2 class="hr-modal-title">About</h2>
                            <button onclick="closeAboutModal(event)" class="hr-modal-close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="hr-modal-body">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Company Name:</span>
                                    <span class="text-sm text-gray-900">${data.company_name}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Version:</span>
                                    <span class="text-sm text-gray-900">${data.version}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Active Employees:</span>
                                    <span class="text-sm text-gray-900">${data.active_employees}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Employees:</span>
                                    <span class="text-sm text-gray-900">${data.employees}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Terminated:</span>
                                    <span class="text-sm text-gray-900">${data.terminated || ''}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Append modal to body
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            
            // Show modal with animation
            setTimeout(() => {
                const overlay = document.getElementById('about-modal-overlay');
                if (overlay) {
                    overlay.classList.add('show');
                }
            }, 10);
        })
        .catch(error => {
            console.error('Error fetching about data:', error);
        });
}

// Close About Modal
function closeAboutModal(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const overlay = document.getElementById('about-modal-overlay');
    if (overlay) {
        overlay.classList.remove('show');
        setTimeout(() => {
            overlay.remove();
        }, 300);
    }
}

// Make functions available globally
window.showAboutModal = showAboutModal;
window.closeAboutModal = closeAboutModal;

// Close profile dropdown when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        const portal = document.getElementById('hr-dropdown-portal');
        if (!portal) return;
        
        const dropdown = portal.querySelector('.hr-profile-dropdown-portal');
        if (!dropdown) return;
        
        const trigger = document.querySelector('[data-profile-dropdown-trigger]');
        const isClickInsideDropdown = dropdown.contains(event.target);
        const isClickOnTrigger = trigger && trigger.contains(event.target);
        
        if (!isClickInsideDropdown && !isClickOnTrigger) {
            dropdown.style.display = 'none';
        }
    });
    
    // Close dropdown on scroll/resize
    window.addEventListener('scroll', function() {
        const portal = document.getElementById('hr-dropdown-portal');
        if (!portal) return;
        const dropdown = portal.querySelector('.hr-profile-dropdown-portal');
        if (dropdown && dropdown.style.display !== 'none') {
            dropdown.style.display = 'none';
        }
    });
    
    window.addEventListener('resize', function() {
        const portal = document.getElementById('hr-dropdown-portal');
        if (!portal) return;
        const dropdown = portal.querySelector('.hr-profile-dropdown-portal');
        if (dropdown && dropdown.style.display !== 'none') {
            dropdown.style.display = 'none';
        }
    });
});

// Regular Dropdown Toggle Functionality (for maintenance dropdowns)
function toggleDropdown(event) {
    // If clicking on a link inside dropdown, allow navigation
    if (event.target.tagName === 'A' || event.target.closest('a')) {
        const link = event.target.tagName === 'A' ? event.target : event.target.closest('a');
        if (link && link.closest('.hr-dropdown-menu')) {
            // Allow navigation - don't prevent default
            const clickedElement = event.currentTarget || event.target.closest('.group');
            if (clickedElement) {
                const dropdown = clickedElement.querySelector('.hr-dropdown-menu');
                if (dropdown) {
                    dropdown.classList.add('hidden');
                    dropdown.classList.remove('show');
                }
            }
            return; // Allow default link behavior
        }
    }
    
    event.stopPropagation();
    
    const clickedElement = event.currentTarget || event.target.closest('.group');
    if (!clickedElement) return;
    
    const dropdown = clickedElement.querySelector('.hr-dropdown-menu');
    if (!dropdown) return;
    
    // Close all other dropdowns
    document.querySelectorAll('.hr-dropdown-menu').forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.add('hidden');
            menu.classList.remove('show');
        }
    });
    
    // Toggle current dropdown
    const isOpen = dropdown.classList.contains('show');
    if (isOpen) {
        dropdown.classList.add('hidden');
        dropdown.classList.remove('show');
    } else {
        dropdown.classList.remove('hidden');
        dropdown.classList.add('show');
    }
}

// Close regular dropdowns when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        const isClickInsideDropdown = event.target.closest('.hr-dropdown-menu') || 
                                      event.target.closest('.group');
        
        if (!isClickInsideDropdown) {
            document.querySelectorAll('.hr-dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
});

// Make functions available globally
window.toggleDropdown = toggleDropdown;
window.toggleProfileDropdown = toggleProfileDropdown;

// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('hr-sidebar');
    const toggleButton = document.getElementById('sidebar-toggle');
    const body = document.body;
    
    if (!sidebar || !toggleButton) return;
    
    // Get initial state from localStorage
    const isCollapsed = localStorage.getItem('hr-sidebar-collapsed') === 'true';
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        body.classList.add('sidebar-collapsed');
    }
    
    // Toggle sidebar
    toggleButton.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        
        // Save state to localStorage
        const collapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('hr-sidebar-collapsed', collapsed ? 'true' : 'false');
    });
    
    // Handle sidebar link clicks to set active state (for immediate feedback)
    const sidebarLinks = sidebar.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            sidebarLinks.forEach(l => l.classList.remove('sidebar-link--active'));
            // Add active class to clicked link
            this.classList.add('sidebar-link--active');
        });
    });
    
    // Scroll to active sidebar link - apply immediately to prevent scroll jump
    const activeLink = sidebar.querySelector('.sidebar-link--active');
    const sidebarNav = sidebar.querySelector('.hr-sidebar-nav');
    
    if (activeLink && sidebarNav) {
        // Function to calculate and apply scroll position
        function scrollToActiveLink() {
            const navHeight = sidebarNav.offsetHeight;
            const linkTop = activeLink.offsetTop;
            const linkHeight = activeLink.offsetHeight;
            const navScrollTop = sidebarNav.scrollTop;
            
            // Check if active link is visible
            const linkBottom = linkTop + linkHeight;
            const visibleTop = navScrollTop;
            const visibleBottom = navScrollTop + navHeight;
            
            // If link is not fully visible, scroll to show it
            if (linkTop < visibleTop || linkBottom > visibleBottom) {
                // Center the active link in the visible area
                const scrollPosition = linkTop - (navHeight / 2) + (linkHeight / 2);
                
                // Apply scroll immediately without animation to prevent jump
                sidebarNav.scrollTop = Math.max(0, scrollPosition);
            }
        }
        
        // Try to apply immediately
        scrollToActiveLink();
        
        // Fallback: If layout not ready, wait for next frame
        if (sidebarNav.offsetHeight === 0 || activeLink.offsetTop === 0) {
            requestAnimationFrame(function() {
                scrollToActiveLink();
            });
        }
    }
});
