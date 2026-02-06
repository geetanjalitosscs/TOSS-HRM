@props([
    'name' => '',
    'label' => '',
    'value' => '#8B5CF6',
    'required' => false
])

@php
    $uniqueId = 'cp-' . uniqid();
    $swatchId = 'swatch-' . $uniqueId;
    $pickerId = 'picker-' . $uniqueId;
    $hexId = 'hex-' . $uniqueId;
@endphp

<div class="color-picker-field relative">
    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <div class="flex items-center gap-3">
        <!-- Color Swatch (Clickable) -->
        <div 
            class="w-12 h-12 rounded-full border-2 cursor-pointer transition-transform hover:scale-105 relative" 
            style="border-color: var(--border-strong); background-color: {{ $value }}; box-shadow: 0 0 15px rgba(228, 87, 69, 0.2), 0 0 30px rgba(228, 87, 69, 0.1);" 
            id="{{ $swatchId }}"
            onclick="openColorPicker('{{ $uniqueId }}', '{{ $value }}', event)">
        </div>
        
        <!-- HEX Input -->
        <input 
            type="text" 
            name="{{ $name }}_hex" 
            value="{{ strtoupper($value) }}" 
            class="w-24 px-2 py-1 border rounded text-sm focus:outline-none focus:ring-2" 
            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input); focus-ring-color: var(--color-hr-primary);" 
            id="{{ $hexId }}"
            placeholder="#FFFFFF"
            oninput="updateColorFromHex('{{ $uniqueId }}', this.value)">
        
        <!-- Hidden color input for form submission -->
        <input type="hidden" name="{{ $name }}" value="{{ $value }}" id="hidden-{{ $uniqueId }}">
    </div>
    
    <!-- Floating Color Picker (Hidden by default) -->
    <div 
        id="{{ $pickerId }}" 
        class="color-picker-overlay fixed hidden rounded-lg p-4"
        style="background: var(--bg-card); border: 1px solid var(--border-strong); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); z-index: 99999; min-width: 220px;">
        <!-- 2D Color Gradient Square -->
        <div class="mb-3 relative">
            <canvas 
                id="canvas-{{ $uniqueId }}" 
                width="200" 
                height="150" 
                class="border rounded cursor-crosshair block"
                style="border-color: var(--border-default);"
                onmousedown="startColorDrag('{{ $uniqueId }}', event)"
                onmousemove="updateColorDrag('{{ $uniqueId }}', event)"
                onmouseup="stopColorDrag('{{ $uniqueId }}')"
                onmouseleave="stopColorDrag('{{ $uniqueId }}')">
            </canvas>
            <!-- Color indicator circle -->
            <div 
                id="indicator-{{ $uniqueId }}" 
                class="absolute w-4 h-4 border-2 rounded-full pointer-events-none"
                style="border-color: var(--text-primary); transform: translate(-50%, -50%);">
            </div>
        </div>
        
        <!-- Hue Slider -->
        <div class="mb-3 relative">
            <canvas 
                id="hue-{{ $uniqueId }}" 
                width="200" 
                height="20" 
                class="border rounded cursor-pointer block"
                style="border-color: var(--border-default);"
                onclick="setHue('{{ $uniqueId }}', event)"
                onmousedown="startHueDrag('{{ $uniqueId }}', event)"
                onmousemove="updateHueDrag('{{ $uniqueId }}', event)"
                onmouseup="stopHueDrag('{{ $uniqueId }}')"
                onmouseleave="stopHueDrag('{{ $uniqueId }}')">
            </canvas>
            <!-- Hue indicator -->
            <div 
                id="hue-indicator-{{ $uniqueId }}" 
                class="absolute w-2 h-full border rounded pointer-events-none top-0"
                style="border-color: var(--text-primary); transform: translateX(-50%);">
            </div>
        </div>
        
        <!-- HEX Input in Picker -->
        <div class="mb-2">
            <input 
                type="text" 
                id="picker-hex-{{ $uniqueId }}" 
                value="{{ strtoupper($value) }}" 
                class="w-full px-2 py-1 border rounded text-sm focus:outline-none focus:ring-2" 
                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input); focus-ring-color: var(--color-hr-primary);"
                placeholder="#FFFFFF"
                oninput="updateColorFromHex('{{ $uniqueId }}', this.value)">
        </div>
        
        <!-- Live Preview -->
        <div class="flex items-center gap-2">
            <div 
                id="preview-{{ $uniqueId }}" 
                class="w-8 h-8 rounded border-2"
                style="border-color: var(--border-strong); background-color: {{ $value }};">
            </div>
            <span class="text-xs" style="color: var(--text-muted);">Preview</span>
        </div>
    </div>
</div>
