@extends('layouts.app')

@section('title', 'Admin - Module Configuration')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-modules" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <h2 class="text-lg font-bold mb-6" style="color: var(--text-primary);">Module Configuration</h2>

            <form class="space-y-4">
                @foreach($modules as $module)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                    <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">
                        {{ $module['name'] }}
                    </label>
                    <div class="relative">
                        <input type="checkbox" class="sr-only module-toggle" id="module-{{ $module['id'] }}" {{ $module['enabled'] ? 'checked' : '' }}>
                        <label for="module-{{ $module['id'] }}" class="w-11 h-6 bg-[var(--color-hr-primary)] rounded-full transition-colors duration-200 cursor-pointer block">
                            <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-5" style="margin-top: 2px;"></div>
                        </label>
                    </div>
                </div>
                @endforeach

                <!-- Action Button -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white transition-colors" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'" onmouseout="this.style.background='var(--color-hr-primary)'">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </x-main-layout>

    <script>
        // Module toggles
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.module-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const label = this.nextElementSibling;
                    const circle = label.querySelector('div');
                    if (this.checked) {
                        label.style.background = 'var(--color-hr-primary)';
                        circle.classList.add('translate-x-5');
                        circle.classList.remove('translate-x-0.5');
                    } else {
                        label.style.background = 'var(--bg-hover)';
                        circle.classList.remove('translate-x-5');
                        circle.classList.add('translate-x-0.5');
                    }
                });
            });
        });
    </script>
@endsection

