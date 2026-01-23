@extends('layouts.app')

@section('title', 'Leave - My Leave')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="my-leave" />
        
        <!-- My Leave List Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-calendar-check text-purple-500"></i> <span class="mt-0.5">My Leave List</span>
            </h2>
            <x-admin.search-panel title="" :collapsed="false">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">From Date</label>
                        <div class="relative">
                            <input type="date" value="2026-01-01" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all pr-10" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <i class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">To Date</label>
                        <div class="relative">
                            <input type="date" value="2026-12-31" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all pr-10" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <i class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Show Leave with Status <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>-- Select --</option>
                            <option>Pending Approval</option>
                            <option>Approved</option>
                            <option>Rejected</option>
                            <option>Cancelled</option>
                            <option>Scheduled</option>
                            <option>Taken</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Leave Type</label>
                    <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                        <option>-- Select --</option>
                        <option>Annual Leave</option>
                        <option>Sick Leave</option>
                        <option>Casual Leave</option>
                    </select>
                </div>
                <x-admin.action-buttons />
            </x-admin.search-panel>
            
            <!-- No Records Found -->
            <div class="text-center py-12 rounded-lg border" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="text-sm font-medium" style="color: var(--text-muted);">No Records Found</div>
            </div>
        </section>
    </x-main-layout>
@endsection

