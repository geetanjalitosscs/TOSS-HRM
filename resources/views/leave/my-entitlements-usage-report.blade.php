@extends('layouts.app')

@section('title', 'Leave - My Entitlements and Usage Report')

@section('body')
    <x-main-layout title="Leave / Reports">
        <x-leave.tabs activeTab="my-leave-entitlements-report" />
        
        <!-- My Leave Entitlements and Usage Report Section -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-file-alt" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">My Leave Entitlements and Usage Report</span>
            </h2>
            
            <x-admin.search-panel title="" :collapsed="false">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Leave Period <span style="color: var(--color-danger);">*</span>
                        </label>
                        <input type="text" value="" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="Select date range">
                    </div>
                    <div>
                        <button type="button" class="hr-btn-primary px-4 py-2 text-sm rounded-lg transition-all">
                            Generate
                        </button>
                    </div>
                </div>
                <div class="text-xs mt-2" style="color: var(--text-muted);">
                    <span style="color: var(--color-danger);">*</span> Required
                </div>
            </x-admin.search-panel>
        </section>
        
        <!-- Report Table Section -->
        <section class="hr-card p-6">
            @if(isset($reportData) && count($reportData) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($reportData)" />
            
            <!-- Table Wrapper -->
            <div class="hr-table-wrapper">
                <!-- Table Header -->
                <div class="rounded-t-lg px-2 py-1.5 flex items-start gap-3 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-[1.2] basis-0 min-w-0">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight whitespace-nowrap" style="color: var(--text-primary);">Leave Type</div>
                    </div>
                    <div class="flex-1 basis-0 min-w-0">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight whitespace-nowrap" style="color: var(--text-primary);">Leave Entitlements (Days)</div>
                    </div>
                    <div class="flex-1 basis-0 min-w-0">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight whitespace-nowrap" style="color: var(--text-primary);">Leave Taken (Days)</div>
                    </div>
                    <div class="flex-1 basis-0 min-w-0">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight whitespace-nowrap" style="color: var(--text-primary);">Leave Balance (Days)</div>
                    </div>
                </div>
                
                <!-- Table Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @foreach($reportData as $row)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-3" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex-[1.2] basis-0 min-w-0">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $row->leave_type }}</div>
                        </div>
                        <div class="flex-1 basis-0 min-w-0">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ number_format((float)$row->days_entitled, 0, '.', '') }}</div>
                        </div>
                        <div class="flex-1 basis-0 min-w-0">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ number_format((float)$row->days_taken, 0, '.', '') }}</div>
                        </div>
                        <div class="flex-1 basis-0 min-w-0">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ number_format((float)$row->balance, 0, '.', '') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <!-- No Data -->
            <x-records-found :count="0" />
            <div class="text-center py-8 text-sm text-slate-500">No leave entitlements data available.</div>
            @endif
        </section>
    </x-main-layout>
@endsection

