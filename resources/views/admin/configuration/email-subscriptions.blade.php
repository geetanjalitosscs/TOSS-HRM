@extends('layouts.app')

@section('title', 'Admin - Email Subscriptions')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-email-subscriptions" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <h2 class="text-lg font-bold mb-3" style="color: var(--text-primary);">Email Subscriptions</h2>
            
            <div class="border-b border-gray-200 mb-3"></div>
            
            <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                ({{ count($subscriptions) }}) Records Found
            </div>

            <!-- Table -->
            <div class="hr-table-wrapper">
                <!-- Table Header -->
                <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Notification Type</div>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Subscribers</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 120px;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide text-center">Actions</div>
                    </div>
                </div>

                <!-- Data Rows -->
                <div class="border border-gray-200 border-t-0 rounded-b-lg">
                    @foreach($subscriptions as $subscription)
                    <div class="px-2 py-2 border-b border-gray-100 flex items-center gap-1 hover:bg-gray-50 last:border-b-0">
                        <div class="flex-1">
                            <div class="text-xs text-gray-700">{{ $subscription['notification_type'] }}</div>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500">{{ $subscription['subscribers'] ?: '-' }}</div>
                        </div>
                        <div class="flex-shrink-0 flex items-center justify-center gap-2" style="width: 120px;">
                            <button class="w-6 h-6 rounded-full flex items-center justify-center hover:bg-purple-50 transition-colors" title="Add Subscriber">
                                <i class="fas fa-user-plus text-xs" style="color: var(--color-hr-primary);"></i>
                            </button>
                            <div class="relative">
                                <input type="checkbox" class="sr-only toggle-switch" id="toggle-{{ $subscription['id'] }}">
                                <label for="toggle-{{ $subscription['id'] }}" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer block">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" style="margin-top: 2px;"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-main-layout>

    <script>
        // Toggle switches
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle-switch');
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
