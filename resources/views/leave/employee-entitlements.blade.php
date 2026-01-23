@extends('layouts.app')

@section('title', 'Leave - Employee Entitlements')

@section('body')
    <x-main-layout title="Leave / Entitlements">
        <x-leave.tabs activeTab="employee-entitlements" />
        
        <!-- Employee Leave Entitlements Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Employee Leave Entitlements</span>
            </h2>
            
            <x-admin.search-panel title="" :collapsed="false">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="Type for hints...">
                    </div>
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
                    <x-admin.action-buttons />
                </div>
            </x-admin.search-panel>
        </section>
        
        <!-- Add Button -->
        <div class="mb-6">
            <x-admin.add-button label="+ Add" />
        </div>
        
        <!-- Entitlements Table Section -->
        <section class="hr-card p-6">
            <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                No Records Found
            </div>
        </section>
    </x-main-layout>
@endsection
