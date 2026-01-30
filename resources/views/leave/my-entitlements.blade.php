@extends('layouts.app')

@section('title', 'Leave - My Entitlements')

@section('body')
    <x-main-layout title="Leave / Entitlements">
        <x-leave.tabs activeTab="my-entitlements" />
        
        <!-- My Leave Entitlements Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-calendar-check" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">My Leave Entitlements</span>
            </h2>
            
            <x-admin.search-panel title="" :collapsed="false">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Leave Type</label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>-- Select --</option>
                            <option>Annual Leave</option>
                            <option>Sick Leave</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Leave Period</label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>2026-01-01 - 2026-31-12</option>
                        </select>
                    </div>
                    <div>
                        <button type="button" class="hr-btn-primary px-4 py-2 text-sm rounded-lg transition-all">
                            Search
                        </button>
                    </div>
                </div>
            </x-admin.search-panel>
        </section>
        
        <!-- Add Button -->
        <div class="mb-6">
            <x-admin.add-button label="+ Add" />
        </div>
        
        <!-- Entitlements Table Section -->
        <section class="hr-card p-6">
            @if(isset($entitlements) && count($entitlements) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($entitlements)" />

            <!-- Summary -->
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs font-medium" style="color: var(--text-muted);">
                    Showing entitlements for current employee
                </div>
                <div class="text-xs font-medium" style="color: var(--text-muted);">
                    Total {{ number_format($entitlements->sum('balance'), 0, '.', '') }} Day(s)
                </div>
            </div>

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Leave Type</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Entitled (Days)</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Used (Days)</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Balance (Days)</span>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($entitlements as $row)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">
                            {{ $row->leave_type }}
                        </div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">
                            {{ number_format((float)$row->days_entitled, 0, '.', '') }}
                        </div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">
                            {{ number_format((float)$row->days_used, 0, '.', '') }}
                        </div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">
                            {{ number_format((float)$row->balance, 0, '.', '') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @else
            <!-- No Records Found - Centered Message -->
            <div class="flex flex-col items-center justify-center min-h-[220px]">
                <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                    No Records Found
                </div>
            </div>
            @endif
        </section>
    </x-main-layout>
@endsection
