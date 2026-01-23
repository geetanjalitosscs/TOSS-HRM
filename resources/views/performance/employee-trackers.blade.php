@extends('layouts.app')

@section('title', 'Performance - Employee Trackers')

@section('body')
    <x-main-layout title="Performance / Employee Trackers">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-y-visible">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs'],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                        <span class="text-sm font-medium text-slate-700">Configure</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance'), 'label' => 'Manage Reviews'],
                        ['url' => route('performance.my-reviews'), 'label' => 'My Reviews'],
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                        <span class="text-sm font-medium text-slate-700">Manage Reviews</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">My Trackers</span>
                </a>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Employee Trackers</span>
                </div>
            </div>
        </div>

        <!-- Employee Performance Trackers Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-users text-purple-500"></i> <span class="mt-0.5">Employee Performance Trackers</span>
            </h2>

            <!-- Filter Form -->
            <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                        <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Include</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                            <option>Current Employees Only</option>
                            <option>Past Employees Only</option>
                            <option>All Employees</option>
                        </select>
                    </div>
                </div>
                <x-admin.action-buttons />
            </div>

            @if(count($trackers) > 0)
            <!-- Records Count -->
            <div class="mb-4 text-xs font-medium" style="color: var(--text-muted);">
                ({{ count($trackers) }}) Records Found
            </div>

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee Name</span>
                        <i class="fas fa-sort" style="color: var(--text-muted);"></i>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Trackers</span>
                        <i class="fas fa-sort" style="color: var(--text-muted);"></i>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Added Date</span>
                        <i class="fas fa-sort" style="color: var(--text-muted);"></i>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Modified Date</span>
                        <i class="fas fa-sort" style="color: var(--text-muted);"></i>
                    </div>
                </div>
                <div class="flex-shrink-0" style="width: 70px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($trackers as $tracker)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker['employee_name'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker['tracker'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker['added_date'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker['modified_date'] ?: '' }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 70px;">
                        <div class="flex items-center justify-center">
                            <button class="hr-btn-primary px-2 py-1 text-xs font-medium">
                                View
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- No Records Found -->
            <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                No Records Found
            </div>
            @endif
        </section>
    </x-main-layout>
@endsection

