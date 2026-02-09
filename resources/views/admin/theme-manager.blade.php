@extends('layouts.app')

@section('title', 'Admin - Theme Manager')

@section('body')
    <x-main-layout title="Admin">
        <x-admin.tabs activeTab="theme-manager" />

        <!-- Theme Manager Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-palette text-[var(--color-primary)]"></i> Theme Manager
                </h2>
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="resetThemeColors()"
                    >
                        <i class="fas fa-undo mr-2"></i>Reset to Default
                    </button>
                </div>
            </div>

            @if(session('status'))
                <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10B981;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.theme-manager.update') }}" id="theme-manager-form" onsubmit="handleThemeFormSubmit(event)">
                @csrf
                
                <!-- Theme Tabs -->
                <div class="flex gap-2 mb-6 border-b" style="border-color: var(--border-default);">
                    <button
                        type="button"
                        id="light-theme-tab"
                        class="px-4 py-2 text-xs font-medium transition-all"
                        style="border-bottom: 2px solid var(--color-primary); color: var(--color-primary); background-color: var(--bg-hover);"
                        onclick="switchThemeTab('light')"
                    >
                        Light Theme
                    </button>
                    <button
                        type="button"
                        id="dark-theme-tab"
                        class="px-4 py-2 text-xs font-medium transition-all"
                        style="border-bottom: 2px solid transparent; color: var(--text-secondary);"
                        onclick="switchThemeTab('dark')"
                    >
                        Dark Theme
                    </button>
                </div>

                <!-- Light Theme Colors -->
                <div id="light-theme-colors" class="theme-colors-section">
                    @foreach(['primary', 'background', 'text', 'border', 'scrollbar'] as $category)
                        @if(isset($lightThemeColors[$category]) && count($lightThemeColors[$category]) > 0)
                            <div class="mb-6">
                                <h3 class="text-xs font-bold uppercase tracking-wide mb-3" style="color: var(--text-primary);">
                                    {{ ucfirst($category) }} Colors
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($lightThemeColors[$category] as $color)
                                        <div class="flex items-center gap-3 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                                            <div class="flex-shrink-0">
                                                @if(strpos($color->color_value, 'rgba') === 0 || strpos($color->color_value, 'rgb') === 0)
                                                    <input
                                                        type="text"
                                                        name="colors[{{ $color->id }}]"
                                                        value="{{ $color->color_value }}"
                                                        class="theme-color-picker-text hr-input text-xs w-24"
                                                        placeholder="rgba(...)"
                                                        onchange="updateColorPreview(this, '{{ $color->variable_name }}', 'light')"
                                                        data-variable="{{ $color->variable_name }}"
                                                        data-theme="light"
                                                    >
                                                @else
                                                    <input
                                                        type="color"
                                                        name="colors[{{ $color->id }}]"
                                                        value="{{ $color->color_value }}"
                                                        class="theme-color-picker w-12 h-8 rounded cursor-pointer border"
                                                        style="border-color: var(--border-default);"
                                                        onchange="updateColorPreview(this, '{{ $color->variable_name }}', 'light')"
                                                        data-variable="{{ $color->variable_name }}"
                                                        data-theme="light"
                                                    >
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">
                                                    {{ $color->display_name }}
                                                </div>
                                                <div class="text-[10px] truncate" style="color: var(--text-muted);">
                                                    {{ $color->variable_name }}
                                                </div>
                                                @if($color->description)
                                                    <div class="text-[10px] mt-1" style="color: var(--text-muted);">
                                                        {{ $color->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Dark Theme Colors -->
                <div id="dark-theme-colors" class="theme-colors-section hidden">
                    @foreach(['primary', 'background', 'text', 'border', 'scrollbar'] as $category)
                        @if(isset($darkThemeColors[$category]) && count($darkThemeColors[$category]) > 0)
                            <div class="mb-6">
                                <h3 class="text-xs font-bold uppercase tracking-wide mb-3" style="color: var(--text-primary);">
                                    {{ ucfirst($category) }} Colors
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($darkThemeColors[$category] as $color)
                                        <div class="flex items-center gap-3 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                                            <div class="flex-shrink-0">
                                                @if(strpos($color->color_value, 'rgba') === 0 || strpos($color->color_value, 'rgb') === 0)
                                                    <input
                                                        type="text"
                                                        name="colors[{{ $color->id }}]"
                                                        value="{{ $color->color_value }}"
                                                        class="theme-color-picker-text hr-input text-xs w-24"
                                                        placeholder="rgba(...)"
                                                        onchange="updateColorPreview(this, '{{ $color->variable_name }}', 'dark')"
                                                        data-variable="{{ $color->variable_name }}"
                                                        data-theme="dark"
                                                    >
                                                @else
                                                    <input
                                                        type="color"
                                                        name="colors[{{ $color->id }}]"
                                                        value="{{ $color->color_value }}"
                                                        class="theme-color-picker w-12 h-8 rounded cursor-pointer border"
                                                        style="border-color: var(--border-default);"
                                                        onchange="updateColorPreview(this, '{{ $color->variable_name }}', 'dark')"
                                                        data-variable="{{ $color->variable_name }}"
                                                        data-theme="dark"
                                                    >
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">
                                                    {{ $color->display_name }}
                                                </div>
                                                <div class="text-[10px] truncate" style="color: var(--text-muted);">
                                                    {{ $color->variable_name }}
                                                </div>
                                                @if($color->description)
                                                    <div class="text-[10px] mt-1" style="color: var(--text-muted);">
                                                        {{ $color->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3 mt-6 pt-6 border-t" style="border-color: var(--border-default);">
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>

    <script>
        let currentThemeTab = 'light';
        let originalColors = {};

        // Store original colors on page load
        document.addEventListener('DOMContentLoaded', function() {
            const colorPickers = document.querySelectorAll('.theme-color-picker');
            colorPickers.forEach(picker => {
                const variable = picker.dataset.variable;
                const theme = picker.dataset.theme;
                if (!originalColors[theme]) {
                    originalColors[theme] = {};
                }
                originalColors[theme][variable] = picker.value;
            });
        });

        function switchThemeTab(theme) {
            currentThemeTab = theme;
            
            // Update tab styles
            const lightTab = document.getElementById('light-theme-tab');
            const darkTab = document.getElementById('dark-theme-tab');
            const lightSection = document.getElementById('light-theme-colors');
            const darkSection = document.getElementById('dark-theme-colors');

            if (theme === 'light') {
                lightTab.style.borderBottomColor = 'var(--color-primary)';
                lightTab.style.color = 'var(--color-primary)';
                lightTab.style.backgroundColor = 'var(--bg-hover)';
                darkTab.style.borderBottomColor = 'transparent';
                darkTab.style.color = 'var(--text-secondary)';
                darkTab.style.backgroundColor = 'transparent';
                lightSection.classList.remove('hidden');
                darkSection.classList.add('hidden');
            } else {
                darkTab.style.borderBottomColor = 'var(--color-primary)';
                darkTab.style.color = 'var(--color-primary)';
                darkTab.style.backgroundColor = 'var(--bg-hover)';
                lightTab.style.borderBottomColor = 'transparent';
                lightTab.style.color = 'var(--text-secondary)';
                lightTab.style.backgroundColor = 'transparent';
                darkSection.classList.remove('hidden');
                lightSection.classList.add('hidden');
            }
        }

        function updateColorPreview(input, variableName, theme) {
            const colorValue = input.value;
            const currentTheme = document.documentElement.getAttribute('data-theme');
            
            // Always update CSS for preview (works for both light and dark)
            document.documentElement.style.setProperty(variableName, colorValue);
        }


        function resetThemeColors() {
            if (confirm('Are you sure you want to reset all theme colors to default? This action cannot be undone.')) {
                // Reset via fetch, then reload colors immediately
                fetch('{{ route('admin.theme-manager.reset') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (response.ok || response.redirected || response.status === 200) {
                        // Reload colors immediately on current page
                        if (typeof window.loadThemeColors === 'function') {
                            window.loadThemeColors();
                        } else {
                            loadAndApplyThemeColors();
                        }
                        
                        // Wait a bit for colors to apply, then reload page to show success message
                        setTimeout(function() {
                            window.location.reload();
                        }, 200);
                    } else {
                        alert('Error resetting theme colors. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error resetting theme colors. Please try again.');
                });
            }
        }

        // Function to load and apply theme colors from database
        function loadAndApplyThemeColors() {
            fetch('{{ route('admin.theme-manager.get-colors') }}')
                .then(response => response.json())
                .then(data => {
                    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                    const themeColors = data[currentTheme] || data['light'] || {};
                    
                    // Apply each color variable
                    Object.keys(themeColors).forEach(variable => {
                        document.documentElement.style.setProperty(variable, themeColors[variable]);
                    });
                    
                    // Also apply to light theme if current theme is dark (for preview)
                    if (currentTheme === 'dark' && data['light']) {
                        // Store light theme colors but don't apply them
                        // They will be applied when user switches to light theme
                    }
                })
                .catch(error => {
                    console.error('Error loading theme colors:', error);
                });
        }

        // Load theme colors on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadAndApplyThemeColors();
            
            // If there's a success message (after save/reset), reload colors
            @if(session('status'))
                loadAndApplyThemeColors();
            @endif
        });

        // Handle form submit with AJAX to reload colors immediately
        function handleThemeFormSubmit(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                redirect: 'follow'
            })
            .then(response => {
                if (response.ok || response.redirected || response.status === 200) {
                    // Reload colors immediately on current page
                    if (typeof window.loadThemeColors === 'function') {
                        window.loadThemeColors();
                    } else {
                        loadAndApplyThemeColors();
                    }
                    
                    // Wait a bit for colors to apply, then reload page to show success message
                    setTimeout(function() {
                        window.location.href = '{{ route('admin.theme-manager') }}';
                    }, 200);
                } else {
                    return response.text().then(text => {
                        throw new Error('Server error: ' + response.status);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                alert('Error saving theme colors. Please try again.');
            });
        }
    </script>
@endsection

