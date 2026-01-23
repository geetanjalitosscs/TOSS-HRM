@extends('layouts.app')

@section('title', 'Admin - Corporate Branding')

@section('body')
    <x-main-layout title="Admin / Corporate Branding">
        <x-admin.tabs activeTab="corporate-branding" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-palette text-purple-500"></i> <span class="mt-0.5">Corporate Branding</span>
            </h2>

            <form class="space-y-6">
                <!-- Color Pickers Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Primary Color -->
                        <x-admin.color-picker 
                            name="primary_color" 
                            label="Primary Color" 
                            value="#8B5CF6"
                            :required="true" />
                        
                        <!-- Primary Font Color -->
                        <x-admin.color-picker 
                            name="primary_font_color" 
                            label="Primary Font Color" 
                            value="#FFFFFF"
                            :required="true" />
                        
                        <!-- Primary Gradient Color 1 -->
                        <x-admin.color-picker 
                            name="gradient_color_1" 
                            label="Primary Gradient Color 1" 
                            value="#8B5CF6"
                            :required="true" />
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Secondary Color -->
                        <x-admin.color-picker 
                            name="secondary_color" 
                            label="Secondary Color" 
                            value="#A78BFA"
                            :required="true" />
                        
                        <!-- Secondary Font Color -->
                        <x-admin.color-picker 
                            name="secondary_font_color" 
                            label="Secondary Font Color" 
                            value="#FFFFFF"
                            :required="true" />
                        
                        <!-- Primary Gradient Color 2 -->
                        <x-admin.color-picker 
                            name="gradient_color_2" 
                            label="Primary Gradient Color 2" 
                            value="#6D28D9"
                            :required="true" />
                    </div>
                </div>

                <!-- Image Uploads Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <!-- Client Logo -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Client Logo
                        </label>
                        <div class="flex items-center gap-3 px-3 py-2 rounded-md border" style="border-color: var(--border-default); background: var(--bg-input);">
                            <input type="file" name="client_logo" accept=".jpg,.jpeg,.png,.gif,.svg" class="hidden" id="client-logo-input" onchange="handleFileSelect(this, 'client-logo-name')">
                            <button type="button" onclick="document.getElementById('client-logo-input').click()" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                                Browse
                            </button>
                            <span class="text-sm" style="color: var(--text-muted);" id="client-logo-name">No file selected</span>
                        </div>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Accepts jpg, .png, .gif, .svg up to 1MB. Recommended dimensions: 50px X 50px</p>
                    </div>

                    <!-- Client Banner -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Client Banner
                        </label>
                        <div class="flex items-center gap-3 px-3 py-2 rounded-md border" style="border-color: var(--border-default); background: var(--bg-input);">
                            <input type="file" name="client_banner" accept=".jpg,.jpeg,.png,.gif,.svg" class="hidden" id="client-banner-input" onchange="handleFileSelect(this, 'client-banner-name')">
                            <button type="button" onclick="document.getElementById('client-banner-input').click()" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                                Browse
                            </button>
                            <span class="text-sm" style="color: var(--text-muted);" id="client-banner-name">No file selected</span>
                        </div>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Accepts jpg, .png, .gif, .svg up to 1MB. Recommended dimensions: 182px X 50px</p>
                    </div>

                    <!-- Login Banner -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Login Banner
                        </label>
                        <div class="flex items-center gap-3 px-3 py-2 rounded-md border" style="border-color: var(--border-default); background: var(--bg-input);">
                            <input type="file" name="login_banner" accept=".jpg,.jpeg,.png,.gif,.svg" class="hidden" id="login-banner-input" onchange="handleFileSelect(this, 'login-banner-name')">
                            <button type="button" onclick="document.getElementById('login-banner-input').click()" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                                Browse
                            </button>
                            <span class="text-sm" style="color: var(--text-muted);" id="login-banner-name">No file selected</span>
                        </div>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Accepts jpg, .png, .gif, .svg up to 1MB. Recommended dimensions: 340px X 65px</p>
                    </div>
                </div>

                <!-- Social Media Images Toggle -->
                <div class="mt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <span class="text-sm font-medium" style="color: var(--text-secondary);">Social Media Images</span>
                        <div class="relative">
                            <input type="checkbox" class="sr-only" id="social-media-toggle" checked>
                            <div class="w-11 h-6 bg-[var(--color-hr-primary)] rounded-full transition-colors duration-200 flex items-center" id="social-media-toggle-bg">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="social-media-toggle-circle"></div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Required Field Note -->
                <div class="mt-4">
                    <p class="text-xs" style="color: var(--text-muted);">* Required</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="button" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                        Reset to Default
                    </button>
                    <button type="button" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                        Preview
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium">
                        Publish
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>

    <!-- Color Picker JavaScript -->
    <script>
        // Global state for color pickers
        const colorPickers = {};
        let activePickerId = null;
        let isDragging = false;
        let isHueDragging = false;

        // Initialize color picker
        function initColorPicker(uniqueId, initialValue) {
            const canvas = document.getElementById('canvas-' + uniqueId);
            const hueCanvas = document.getElementById('hue-' + uniqueId);
            
            if (!canvas || !hueCanvas) return;
            
            // Draw hue slider
            drawHueSlider(hueCanvas, uniqueId);
            
            // Set initial hue from color
            const hue = hexToHsv(initialValue).h;
            colorPickers[uniqueId] = {
                hue: hue,
                saturation: hexToHsv(initialValue).s,
                value: hexToHsv(initialValue).v
            };
            
            // Draw color canvas
            drawColorCanvas(canvas, uniqueId);
            
            // Set initial indicator positions
            updateIndicators(uniqueId);
        }

        // Convert HEX to HSV
        function hexToHsv(hex) {
            const r = parseInt(hex.slice(1, 3), 16) / 255;
            const g = parseInt(hex.slice(3, 5), 16) / 255;
            const b = parseInt(hex.slice(5, 7), 16) / 255;
            
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            const diff = max - min;
            
            let h = 0;
            if (diff !== 0) {
                if (max === r) {
                    h = ((g - b) / diff + (g < b ? 6 : 0)) / 6;
                } else if (max === g) {
                    h = ((b - r) / diff + 2) / 6;
                } else {
                    h = ((r - g) / diff + 4) / 6;
                }
            }
            
            const s = max === 0 ? 0 : diff / max;
            const v = max;
            
            return { h: h * 360, s: s, v: v };
        }

        // Convert HSV to HEX
        function hsvToHex(h, s, v) {
            h = h % 360;
            const c = v * s;
            const x = c * (1 - Math.abs((h / 60) % 2 - 1));
            const m = v - c;
            
            let r = 0, g = 0, b = 0;
            
            if (h < 60) {
                r = c; g = x; b = 0;
            } else if (h < 120) {
                r = x; g = c; b = 0;
            } else if (h < 180) {
                r = 0; g = c; b = x;
            } else if (h < 240) {
                r = 0; g = x; b = c;
            } else if (h < 300) {
                r = x; g = 0; b = c;
            } else {
                r = c; g = 0; b = x;
            }
            
            r = Math.round((r + m) * 255);
            g = Math.round((g + m) * 255);
            b = Math.round((b + m) * 255);
            
            return '#' + [r, g, b].map(x => {
                const hex = x.toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('').toUpperCase();
        }

        // Draw hue slider
        function drawHueSlider(canvas, uniqueId) {
            const ctx = canvas.getContext('2d');
            const width = canvas.width;
            const height = canvas.height;
            
            const gradient = ctx.createLinearGradient(0, 0, width, 0);
            for (let i = 0; i <= 360; i += 60) {
                const hue = i / 360;
                gradient.addColorStop(hue, hsvToHex(i, 1, 1));
            }
            
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, width, height);
        }

        // Draw color canvas (saturation/value)
        function drawColorCanvas(canvas, uniqueId) {
            const ctx = canvas.getContext('2d');
            const width = canvas.width;
            const height = canvas.height;
            
            const hue = colorPickers[uniqueId].hue;
            
            // Draw saturation/value gradient
            for (let y = 0; y < height; y++) {
                const value = 1 - (y / height);
                const gradient = ctx.createLinearGradient(0, y, width, y);
                gradient.addColorStop(0, hsvToHex(hue, 0, value));
                gradient.addColorStop(1, hsvToHex(hue, 1, value));
                ctx.fillStyle = gradient;
                ctx.fillRect(0, y, width, height - y);
            }
        }

        // Open color picker
        function openColorPicker(uniqueId, currentValue, event) {
            if (event) {
                event.stopPropagation();
            }
            
            // Close any other open picker
            if (activePickerId && activePickerId !== uniqueId) {
                closeColorPicker(activePickerId);
            }
            
            const picker = document.getElementById('picker-' + uniqueId);
            const swatch = document.getElementById('swatch-' + uniqueId);
            
            if (!picker || !swatch) return;
            
            // Toggle if already open
            if (activePickerId === uniqueId && picker.style.display === 'block') {
                closeColorPicker(uniqueId);
                return;
            }
            
            // Get swatch position
            const rect = swatch.getBoundingClientRect();
            
            // Position picker below swatch (fixed positioning relative to viewport)
            picker.style.position = 'fixed';
            picker.style.top = (rect.bottom + 8) + 'px';
            picker.style.left = rect.left + 'px';
            picker.style.display = 'block';
            picker.style.zIndex = '99999';
            
            // Initialize if not already done
            if (!colorPickers[uniqueId]) {
                initColorPicker(uniqueId, currentValue);
            }
            
            // Update from current value
            const hsv = hexToHsv(currentValue);
            colorPickers[uniqueId] = {
                hue: hsv.h,
                saturation: hsv.s,
                value: hsv.v
            };
            
            const canvas = document.getElementById('canvas-' + uniqueId);
            if (canvas) {
                drawColorCanvas(canvas, uniqueId);
            }
            updateIndicators(uniqueId);
            updateColor(uniqueId);
            
            activePickerId = uniqueId;
        }

        // Close color picker
        function closeColorPicker(uniqueId) {
            const picker = document.getElementById('picker-' + uniqueId);
            if (picker) {
                picker.style.display = 'none';
            }
            if (activePickerId === uniqueId) {
                activePickerId = null;
            }
        }

        // Update color from canvas click
        function updateColorFromCanvas(uniqueId, x, y) {
            const canvas = document.getElementById('canvas-' + uniqueId);
            if (!canvas) return;
            
            const rect = canvas.getBoundingClientRect();
            const canvasX = x - rect.left;
            const canvasY = y - rect.top;
            
            colorPickers[uniqueId].saturation = Math.max(0, Math.min(1, canvasX / canvas.width));
            colorPickers[uniqueId].value = Math.max(0, Math.min(1, 1 - (canvasY / canvas.height)));
            
            updateIndicators(uniqueId);
            updateColor(uniqueId);
        }

        // Update hue from slider
        function updateHueFromSlider(uniqueId, x) {
            const canvas = document.getElementById('hue-' + uniqueId);
            if (!canvas) return;
            
            const rect = canvas.getBoundingClientRect();
            const canvasX = x - rect.left;
            
            colorPickers[uniqueId].hue = Math.max(0, Math.min(360, (canvasX / canvas.width) * 360));
            
            drawColorCanvas(document.getElementById('canvas-' + uniqueId), uniqueId);
            updateIndicators(uniqueId);
            updateColor(uniqueId);
        }

        // Update indicators position
        function updateIndicators(uniqueId) {
            const canvas = document.getElementById('canvas-' + uniqueId);
            const hueCanvas = document.getElementById('hue-' + uniqueId);
            const indicator = document.getElementById('indicator-' + uniqueId);
            const hueIndicator = document.getElementById('hue-indicator-' + uniqueId);
            
            if (!canvas || !hueCanvas || !indicator || !hueIndicator || !colorPickers[uniqueId]) return;
            
            const cp = colorPickers[uniqueId];
            
            // Position color indicator relative to canvas
            const canvasContainer = canvas.parentElement;
            if (canvasContainer) {
                indicator.style.left = (cp.saturation * canvas.width) + 'px';
                indicator.style.top = ((1 - cp.value) * canvas.height) + 'px';
            }
            
            // Position hue indicator relative to hue canvas
            const hueContainer = hueCanvas.parentElement;
            if (hueContainer) {
                hueIndicator.style.left = ((cp.hue / 360) * hueCanvas.width) + 'px';
            }
        }

        // Update color value
        function updateColor(uniqueId) {
            const cp = colorPickers[uniqueId];
            const hex = hsvToHex(cp.hue, cp.saturation, cp.value);
            
            // Update swatch
            const swatch = document.getElementById('swatch-' + uniqueId);
            if (swatch) {
                swatch.style.backgroundColor = hex;
            }
            
            // Update HEX inputs
            const hexInput = document.getElementById('hex-' + uniqueId);
            const pickerHexInput = document.getElementById('picker-hex-' + uniqueId);
            const hiddenInput = document.getElementById('hidden-' + uniqueId);
            
            if (hexInput) hexInput.value = hex;
            if (pickerHexInput) pickerHexInput.value = hex;
            if (hiddenInput) hiddenInput.value = hex;
            
            // Update preview
            const preview = document.getElementById('preview-' + uniqueId);
            if (preview) {
                preview.style.backgroundColor = hex;
            }
        }

        // Update color from HEX input
        function updateColorFromHex(uniqueId, hexValue) {
            if (!/^#[0-9A-F]{6}$/i.test(hexValue)) return;
            
            const hsv = hexToHsv(hexValue);
            colorPickers[uniqueId] = {
                hue: hsv.h,
                saturation: hsv.s,
                value: hsv.v
            };
            
            drawColorCanvas(document.getElementById('canvas-' + uniqueId), uniqueId);
            updateIndicators(uniqueId);
            updateColor(uniqueId);
        }

        // Drag handlers for color canvas
        function startColorDrag(uniqueId, event) {
            isDragging = true;
            updateColorFromCanvas(uniqueId, event.clientX, event.clientY);
        }

        function updateColorDrag(uniqueId, event) {
            if (isDragging) {
                updateColorFromCanvas(uniqueId, event.clientX, event.clientY);
            }
        }

        function stopColorDrag(uniqueId) {
            isDragging = false;
        }

        // Drag handlers for hue slider
        function startHueDrag(uniqueId, event) {
            isHueDragging = true;
            updateHueFromSlider(uniqueId, event.clientX);
        }

        function updateHueDrag(uniqueId, event) {
            if (isHueDragging) {
                updateHueFromSlider(uniqueId, event.clientX);
            }
        }

        function stopHueDrag(uniqueId) {
            isHueDragging = false;
        }

        function setHue(uniqueId, event) {
            updateHueFromSlider(uniqueId, event.clientX);
        }

        // Close picker on outside click
        document.addEventListener('click', function(event) {
            if (activePickerId) {
                const picker = document.getElementById('picker-' + activePickerId);
                const swatch = document.getElementById('swatch-' + activePickerId);
                
                if (picker && swatch) {
                    const clickedInsidePicker = picker.contains(event.target);
                    const clickedOnSwatch = swatch.contains(event.target) || swatch === event.target;
                    
                    if (!clickedInsidePicker && !clickedOnSwatch) {
                        closeColorPicker(activePickerId);
                    }
                }
            }
        });
        
        // Initialize all color pickers on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Find all color picker swatches and initialize them
            const swatches = document.querySelectorAll('[id^="swatch-cp-"]');
            swatches.forEach(swatch => {
                const uniqueId = swatch.id.replace('swatch-', '');
                const currentValue = swatch.style.backgroundColor || 
                    window.getComputedStyle(swatch).backgroundColor ||
                    '#8B5CF6';
                
                // Convert rgb to hex if needed
                let hexValue = currentValue;
                if (currentValue.startsWith('rgb')) {
                    const rgb = currentValue.match(/\d+/g);
                    if (rgb && rgb.length >= 3) {
                        hexValue = '#' + rgb.map(x => {
                            const hex = parseInt(x).toString(16);
                            return hex.length === 1 ? '0' + hex : hex;
                        }).join('').toUpperCase();
                    }
                }
                
                if (!colorPickers[uniqueId]) {
                    initColorPicker(uniqueId, hexValue);
                }
            });
        });

        // File selection handler
        function handleFileSelect(input, nameSpanId) {
            const nameSpan = document.getElementById(nameSpanId);
            if (input.files && input.files[0]) {
                nameSpan.textContent = input.files[0].name;
            } else {
                nameSpan.textContent = 'No file selected';
            }
        }

        // Social Media toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('social-media-toggle');
            if (toggle) {
                toggle.addEventListener('change', function() {
                    const bg = document.getElementById('social-media-toggle-bg');
                    const circle = document.getElementById('social-media-toggle-circle');
                    if (this.checked) {
                        bg.classList.add('bg-[var(--color-hr-primary)]');
                        bg.classList.remove('bg-gray-200');
                        circle.classList.add('translate-x-5');
                        circle.classList.remove('translate-x-0.5');
                    } else {
                        bg.classList.remove('bg-[var(--color-hr-primary)]');
                        bg.classList.add('bg-gray-200');
                        circle.classList.remove('translate-x-5');
                        circle.classList.add('translate-x-0.5');
                    }
                });
            }
        });
    </script>

    <style>
        .color-picker-field {
            position: relative;
        }

        .color-picker-overlay {
            border-radius: 8px;
            padding: 0;
            min-width: 220px;
        }

        .color-picker-overlay canvas {
            display: block;
        }

        .color-picker-overlay > div {
            position: relative;
        }

        #indicator-{{ $uniqueId ?? 'default' }},
        #hue-indicator-{{ $uniqueId ?? 'default' }} {
            pointer-events: none;
            z-index: 10;
        }
    </style>
@endsection
