@extends('layouts.app')

@section('title', 'Admin - Email Subscriptions')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-email-subscriptions" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-bell text-purple-500"></i> <span class="mt-0.5">Email Subscriptions</span>
            </h2>
            
            <x-records-found :count="count($subscriptions)" />

            <!-- Table -->
            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                <!-- Table Header -->
                <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-1">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Notification Type</div>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Subscribers</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 120px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                    </div>
                </div>

                <!-- Data Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @foreach($subscriptions as $subscription)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex-1">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $subscription->notification_type }}</div>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs break-words" style="color: var(--text-muted);">{{ $subscription->subscribers ?: '-' }}</div>
                        </div>
                        <div class="flex-shrink-0 flex items-center justify-center" style="width: 120px; gap: 0;">
                            <button class="hr-action-view flex-shrink-0" title="Add Subscriber" style="margin-right: 0;">
                                <i class="fas fa-user-plus text-xs"></i>
                            </button>
                            <div class="flex-shrink-0" style="margin-left: 0;">
                                <x-admin.toggle-switch id="toggle-{{ $subscription->id }}" :checked="false" />
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </x-main-layout>

@endsection
