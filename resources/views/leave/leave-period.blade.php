@extends('layouts.app')

@section('title', 'Leave - Leave Period')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="leave-period" />
        
        <!-- Leave Period Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-calendar-alt" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Leave Period</span>
            </h2>
            
            <form>
                <!-- Start Month -->
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Start Month <span style="color: var(--color-danger);">*</span>
                    </label>
                    <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Start Date <span style="color: var(--color-danger);">*</span>
                    </label>
                    <input type="text" value="01" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                </div>
                
                <!-- End Date -->
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">End Date</label>
                    <input type="text" value="December 31" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                </div>
                
                <!-- Current Leave Period -->
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Current Leave Period</label>
                    <input type="text" value="2026-01-01 to 2026-31-12" readonly class="w-full px-3 py-2 text-sm rounded-lg" style="border: 1px solid var(--border-default); background-color: var(--bg-hover); color: var(--text-primary);">
                </div>
                
                <!-- Required Text and Buttons -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-xs" style="color: var(--text-muted);">
                        <span style="color: var(--color-danger);">*</span> Required
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="hr-btn-secondary px-4 py-2 text-sm rounded-lg transition-all">
                            Reset
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
