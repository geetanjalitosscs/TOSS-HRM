@extends('layouts.app')

@section('title', 'Leave - Add Entitlement')

@section('body')
    <x-main-layout title="Leave / Entitlements">
        <x-leave.tabs activeTab="add-entitlement" />
        
        <!-- Add Leave Entitlement Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-plus-circle" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Add Leave Entitlement</span>
            </h2>
            
            <form>
                <!-- Add to Section -->
                <div class="mb-5">
                    <label class="block text-xs font-medium mb-3" style="color: var(--text-primary);">Add to</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="add_to" value="individual" checked class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-xs" style="color: var(--text-primary);">Individual Employee</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="add_to" value="multiple" class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-xs" style="color: var(--text-primary);">Multiple Employees</span>
                        </label>
                    </div>
                </div>
                
                <!-- Employee Name -->
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee Name <span style="color: var(--color-danger);">*</span>
                    </label>
                    <input type="text" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="Type for hints...">
                </div>
                
                <!-- Three Column Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Leave Type -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Leave Type <span style="color: var(--color-danger);">*</span>
                        </label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>-- Select --</option>
                            <option>Annual Leave</option>
                            <option>Sick Leave</option>
                            <option>Casual Leave</option>
                        </select>
                    </div>
                    
                    <!-- Leave Period -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Leave Period <span style="color: var(--color-danger);">*</span>
                        </label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>2026-01-01 - 2026-31-12</option>
                        </select>
                    </div>
                    
                    <!-- Entitlement -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Entitlement <span style="color: var(--color-danger);">*</span>
                        </label>
                        <input type="text" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                    </div>
                </div>
                
                <!-- Required Text and Buttons -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-xs" style="color: var(--text-muted);">
                        <span style="color: var(--color-danger);">*</span> Required
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="hr-btn-secondary px-4 py-2 text-sm rounded-lg transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="hr-btn-primary px-4 py-2 text-sm rounded-lg transition-all">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </x-main-layout>
@endsection

