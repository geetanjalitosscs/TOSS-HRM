@extends('layouts.app')

@section('title', 'Performance - KPIs')

@section('body')
    <x-main-layout title="Performance / Configure">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible flex-nowrap">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs', 'active' => true],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50 cursor-pointer flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Configure</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
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
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Manage Reviews</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">My Trackers</span>
                </a>
                <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                </a>
            </div>
        </div>

        <!-- Key Performance Indicators for Job Title Section -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-bullseye text-purple-500"></i> <span class="mt-0.5">Key Performance Indicators for Job Title</span>
            </h2>

            <!-- Search Panel -->
            <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                            <option>-- Select --</option>
                            <option>Payroll Administrator</option>
                            <option>QA Lead</option>
                            <option>HR Manager</option>
                        </select>
                    </div>
                    <x-admin.action-buttons />
                </div>
            </div>
        </section>

        <!-- Add Button -->
        <div class="mb-6">
            <x-admin.add-button label="+ Add" />
        </div>

        <!-- KPIs Table Section -->
        <section class="hr-card p-6">
            @if(count($kpis) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($kpis)" />

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Key Performance Indicator</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Job Title</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Min Rate</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Max Rate</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Is Default</span>
                </div>
                <div class="flex-shrink-0" style="width: 90px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($kpis as $kpi)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $kpi['kpi'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $kpi['job_title'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $kpi['min_rate'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $kpi['max_rate'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $kpi['is_default'] }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="flex items-center justify-center gap-2">
                            <button class="hr-action-edit flex-shrink-0" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="hr-action-delete flex-shrink-0" title="Delete">
                                <i class="fas fa-trash-alt text-sm"></i>
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

