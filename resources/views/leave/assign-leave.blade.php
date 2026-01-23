@extends('layouts.app')

@section('title', 'Leave - Assign Leave')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="assign-leave" />
        
        <!-- Assign Leave Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-user-check text-purple-500"></i> <span class="mt-0.5">Assign Leave</span>
            </h2>
            
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Employee Name -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Employee Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="Type for hints...">
                    </div>
                    
                    <!-- Leave Type -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium" style="color: var(--text-primary);">
                                Leave Type <span class="text-red-500">*</span>
                            </label>
                            <span class="text-xs" style="color: var(--text-muted);">Leave Balance: 0.00 Day(s)</span>
                        </div>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option>-- Select --</option>
                            <option>Annual Leave</option>
                            <option>Sick Leave</option>
                            <option>Casual Leave</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- From Date -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            From Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all pr-10" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="yyyy-dd-mm">
                            <i class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                    
                    <!-- To Date -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            To Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all pr-10" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="yyyy-dd-mm">
                            <i class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Comments -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Comments</label>
                    <textarea rows="4" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all resize-none" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"></textarea>
                </div>
                
                <!-- Footer -->
                <div class="flex items-center justify-between pt-4 border-t" style="border-color: var(--border-default);">
                    <p class="text-xs" style="color: var(--text-muted);">
                        <span class="text-red-500">*</span> Required
                    </p>
                    <button type="submit" class="hr-btn-primary px-6 py-2 text-sm font-semibold">
                        Assign
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>
@endsection

