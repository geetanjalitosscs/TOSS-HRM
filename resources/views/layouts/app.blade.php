<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TOAI HR Suite - @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Styles / Scripts (centralised for whole project) -->
        @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            {{-- Fallback for environments without Vite manifest (runs without npm) --}}
            <link rel="stylesheet" href="{{ asset('build/assets/app-BhCtbhSz.css') }}">
            <script type="module" src="{{ asset('build/assets/app-Ckg-XmNZ.js') }}"></script>
        @endif
        
        <!-- Initialize theme immediately to prevent flash -->
        <script>
            (function() {
                // Check if we're on login page
                const isLoginPage = window.location.pathname === '/' || window.location.pathname === '/login';
                
                if (isLoginPage) {
                    // Force light mode on login page
                    document.documentElement.setAttribute('data-theme', 'light');
                } else {
                    // For other pages, use stored theme or system preference
                    const storedTheme = localStorage.getItem('hr-theme');
                    const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    const theme = storedTheme || (systemPrefersDark ? 'dark' : 'light');
                    document.documentElement.setAttribute('data-theme', theme);
                }
            })();
        </script>
        
        <!-- Prevent sidebar flicker: Apply collapsed state before first paint -->
        <script>
            (function() {
                'use strict';
                // Read localStorage synchronously
                const isCollapsed = localStorage.getItem('hr-sidebar-collapsed') === 'true';
                
                if (isCollapsed) {
                    // Function to apply collapsed state
                    function applyCollapsedState() {
                        const sidebar = document.getElementById('hr-sidebar');
                        const body = document.body;
                        if (sidebar) {
                            sidebar.classList.add('collapsed');
                            return true;
                        }
                        if (body) {
                            body.classList.add('sidebar-collapsed');
                        }
                        return false;
                    }
                    
                    // Apply immediately if possible
                    if (document.body && document.getElementById('hr-sidebar')) {
                        applyCollapsedState();
                    } else {
                        // Use requestAnimationFrame to catch before paint
                        requestAnimationFrame(function() {
                            if (applyCollapsedState()) return;
                            
                            // Also use MutationObserver for immediate detection
                            const observer = new MutationObserver(function() {
                                if (applyCollapsedState()) {
                                    observer.disconnect();
                                }
                            });
                            
                            // Observe documentElement for faster detection
                            if (document.documentElement) {
                                observer.observe(document.documentElement, {
                                    childList: true,
                                    subtree: true
                                });
                            }
                            
                            // Also observe body when it exists
                            if (document.body) {
                                observer.observe(document.body, {
                                    childList: true,
                                    subtree: true
                                });
                            }
                            
                            // Fallback: DOMContentLoaded
                            document.addEventListener('DOMContentLoaded', function() {
                                applyCollapsedState();
                                observer.disconnect();
                            }, { once: true });
                            
                            // Additional fallback: immediate check after a microtask
                            Promise.resolve().then(function() {
                                if (applyCollapsedState()) {
                                    observer.disconnect();
                                }
                            });
                        });
                    }
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased bg-hr-body text-hr-text min-h-screen">
        @yield('body')
        
        <!-- Global Dropdown Portal Container -->
        <div id="hr-dropdown-portal"></div>
    </body>
</html>


