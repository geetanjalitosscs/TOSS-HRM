@extends('layouts.app')

@section('title', 'Admin - Module Configuration')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-modules" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-cubes text-purple-500"></i> <span class="mt-0.5">Module Configuration</span>
            </h2>

            <form class="space-y-4">
                @foreach($modules as $module)
                <div class="flex items-center justify-between py-3 border-b" style="border-color: var(--border-default);">
                    <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">{{ $module['name'] }}</label>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only module-toggle" data-id="{{ $module['id'] }}" {{ $module['enabled'] ? 'checked' : '' }}>
                        <div class="w-11 h-6 {{ $module['enabled'] ? 'bg-[var(--color-hr-primary)]' : 'bg-gray-200' }} rounded-full transition-colors duration-200 flex items-center module-toggle-bg">
                            <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 {{ $module['enabled'] ? 'translate-x-5' : 'translate-x-0.5' }} module-toggle-circle"></div>
                        </div>
                    </label>
                </div>
                @endforeach
            </form>

            <!-- Action Button -->
            <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium">
                    Save
                </button>
            </div>
        </section>
    </x-main-layout>

    <script>
        // Module toggles
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.module-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const bg = this.parentElement.querySelector('.module-toggle-bg');
                    const circle = this.parentElement.querySelector('.module-toggle-circle');
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
            });
        });
    </script>
@endsection

