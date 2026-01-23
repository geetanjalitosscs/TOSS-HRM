@extends('layouts.app')

@section('title', 'Admin - Email Subscriptions')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-email-subscriptions" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-bell text-purple-500"></i> <span class="mt-0.5">Email Subscriptions</span>
            </h2>
            
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
                        <div class="flex-shrink-0 flex items-center justify-center gap-1.5" style="width: 120px;">
                            <button class="hr-action-view flex-shrink-0" title="Add Subscriber">
                                <i class="fas fa-user-plus text-xs"></i>
                            </button>
                            <x-admin.toggle-switch id="toggle-{{ $subscription['id'] }}" :checked="false" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </x-main-layout>

@endsection
