@extends('layouts.app')

@section('title', 'Performance - Employee Trackers')

@section('body')
    <x-main-layout title="Performance">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible flex-nowrap">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs'],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Configure</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
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
                    <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Manage Reviews</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">My Trackers</span>
                </a>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)] flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Employee Trackers</span>
                </div>
            </div>
        </div>

        <!-- Employee Performance Trackers Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-users text-[var(--color-primary)]"></i> <span class="mt-0.5">Employee Performance Trackers</span>
            </h2>

            <!-- Filter Form -->
            <div class="bg-[var(--color-primary-light)] rounded-lg p-3 mb-3 border border-[var(--border-default)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                        <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Include</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
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
            <x-records-found :count="count($trackers)" />

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee Name</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Trackers</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Added Date</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Modified Date</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
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
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker->employee_name }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->tracker }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->added_date }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->modified_date ?: '' }}</div>
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

