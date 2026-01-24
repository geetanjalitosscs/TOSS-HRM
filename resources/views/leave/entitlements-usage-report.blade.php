@extends('layouts.app')

@section('title', 'Leave - Entitlements and Usage Report')

@section('body')
    <x-main-layout title="Leave / Reports">
        <x-leave.tabs activeTab="leave-entitlements-report" />
        
        <!-- Leave Entitlements and Usage Report Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-chart-bar" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Leave Entitlements and Usage Report</span>
            </h2>
            
            <form>
                <!-- Generate For Section -->
                <div class="mb-5">
                    <label class="block text-xs font-medium mb-3" style="color: var(--text-primary);">Generate For</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="generate_for" value="leave_type" checked class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-xs" style="color: var(--text-primary);">Leave Type</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="generate_for" value="employee" class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-xs" style="color: var(--text-primary);">Employee</span>
                        </label>
                    </div>
                </div>
                
                <!-- Two Column Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Leave Type -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Leave Type</label>
                            <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                                <option>CAN - Bereavement</option>
                                <option>CAN - FMLA</option>
                                <option>CAN - Maternity</option>
                            </select>
                        </div>
                        
                        <!-- Job Title -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Job Title</label>
                            <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                                <option>-- Select --</option>
                                <option>HR Manager</option>
                                <option>Software Engineer</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Leave Period -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Leave Period <span style="color: var(--color-danger);">*</span>
                            </label>
                            <input type="text" value="2026-01-01 - 2026-31-12" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                        </div>
                        
                        <!-- Location -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Location</label>
                            <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                                <option>-- Select --</option>
                                <option>Canada</option>
                                <option>United States</option>
                            </select>
                        </div>
                        
                        <!-- Sub Unit -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Sub Unit</label>
                            <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                                <option>-- Select --</option>
                                <option>Engineering</option>
                                <option>HR</option>
                            </select>
                        </div>
                        
                        <!-- Include Past Employees -->
                        <div class="flex items-center gap-3">
                            <x-admin.toggle-switch id="include-past-employees" />
                            <label for="include-past-employees" class="text-xs font-medium cursor-pointer" style="color: var(--text-primary);">Include Past Employees</label>
                        </div>
                    </div>
                </div>
                
                <!-- Required Text and Generate Button -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-xs" style="color: var(--text-muted);">
                        <span style="color: var(--color-danger);">*</span> Required
                    </div>
                    <div>
                        <button type="submit" class="hr-btn-primary px-4 py-2 text-sm rounded-lg transition-all">
                            Generate
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </x-main-layout>
@endsection

