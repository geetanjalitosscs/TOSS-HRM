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
                        <input type="text" value="2026-01-01 - 2026-31-12" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
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
            
            <!-- Table will go here -->
            @else
            <!-- Sample Data for Display -->
            <x-records-found :count="11" />
            
            <!-- Table Wrapper -->
            <div class="hr-table-wrapper">
                <!-- Table Header -->
                <div class="rounded-t-lg px-2 py-1.5 flex items-start gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-shrink-0" style="width: 150px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words whitespace-normal" style="color: var(--text-primary);">Leave Type</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 140px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words whitespace-normal" style="color: var(--text-primary);">Leave Entitlements (Days)</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 140px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words whitespace-normal" style="color: var(--text-primary);">Leave Pending Approval (Days)</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 140px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words whitespace-normal" style="color: var(--text-primary);">Leave Scheduled (Days)</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 130px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words whitespace-normal" style="color: var(--text-primary);">Leave Taken (Days)</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 140px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words whitespace-normal" style="color: var(--text-primary);">Leave Balance (Days)</div>
                    </div>
                </div>
                
                <!-- Table Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @php
                        $leaveTypes = [
                            'CAN - Bereavement', 'CAN - FMLA', 'CAN - Maternity', 'CAN - Personal', 'CAN - Vacation',
                            'Sick Leave (Deleted)', 'US - Bereavement', 'US - FMLA', 'US - Maternity', 'US - Personal', 'US - Vacation'
                        ];
                    @endphp
                    @foreach($leaveTypes as $type)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex-shrink-0" style="width: 150px;">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $type }}</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 140px;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">0.00</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 140px;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">0.00</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 140px;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">0.00</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 130px;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">0.00</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 140px;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">0.00</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </section>
    </x-main-layout>
@endsection

