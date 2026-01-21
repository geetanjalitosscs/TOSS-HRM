import './bootstrap';

// Theme Toggle Functionality
(function() {
    'use strict';

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
                icon.textContent = currentTheme === 'dark' ? '☀️' : '🌙';
            }
        });
    }

    // Theme toggle button handler
    document.addEventListener('DOMContentLoaded', function() {
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

// Dropdown Toggle Functionality
function toggleDropdown(event) {
    event.stopPropagation();
    
    const clickedElement = event.currentTarget || event.target.closest('.group');
    if (!clickedElement) return;
    
    // If clicking on a link, allow navigation
    if (event.target.tagName === 'A' || event.target.closest('a')) {
        return;
    }
    
    const dropdown = clickedElement.querySelector('.hr-dropdown-menu');
    if (!dropdown) return;
    
    // Close all other dropdowns
    document.querySelectorAll('.hr-dropdown-menu.show').forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.remove('show');
            menu.style.display = 'none';
        }
    });
    
    // Toggle current dropdown
    const isOpen = dropdown.classList.contains('show');
    if (isOpen) {
        dropdown.classList.remove('show');
        dropdown.style.display = 'none';
    } else {
        dropdown.classList.add('show');
        dropdown.style.display = 'block';
    }
}

// Close dropdowns when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        const isClickInsideDropdown = event.target.closest('.hr-dropdown-menu') || 
                                      event.target.closest('.group');
        
        if (!isClickInsideDropdown) {
            document.querySelectorAll('.hr-dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
                menu.style.display = 'none';
            });
        }
    });
});

// Make toggleDropdown available globally
window.toggleDropdown = toggleDropdown;
