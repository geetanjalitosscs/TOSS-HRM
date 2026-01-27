@extends('layouts.app')

@section('title', 'Leave - Leave List')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="leave-list" />
        
        <!-- Leave List Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-list-alt text-purple-500"></i> <span class="mt-0.5">Leave List</span>
            </h2>
            <x-admin.search-panel title="" :collapsed="false">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                        <x-date-picker 
                            name="from_date"
                            value="2026-01-01"
                            label="From Date"
                        />
                    </div>
                    <div>
                        <x-date-picker 
                            name="to_date"
                            value="2026-12-31"
                            label="To Date"
                        />
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
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Leave Type</label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>-- Select --</option>
                            <option>Annual Leave</option>
                            <option>Sick Leave</option>
                            <option>Casual Leave</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="Type for hints...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Sub Unit</label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>-- Select --</option>
                            <option>Engineering</option>
                            <option>Human Resources</option>
                            <option>Quality Assurance</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex items-center gap-3">
                        <x-admin.toggle-switch id="include-past-employees" />
                        <label for="include-past-employees" class="text-xs font-medium cursor-pointer" style="color: var(--text-primary);">Include Past Employees</label>
                    </div>
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

