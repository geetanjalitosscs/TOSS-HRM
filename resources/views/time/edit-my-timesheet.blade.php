@extends('layouts.app')

@section('title', 'Time - Edit Timesheet')

@section('body')
    <x-main-layout title="Time / Edit Timesheet">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible">
                <x-dropdown-menu 
                    :items="[
                        [
                            'url' => route('time.my-timesheets'),
                            'label' => 'My Timesheets',
                            'active' => request()->routeIs('time.my-timesheets') || request()->routeIs('time.my-timesheets.edit')
                        ],
                        [
                            'url' => route('time'),
                            'label' => 'Employee Timesheets',
                            'active' => request()->routeIs('time')
                        ]
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50 cursor-pointer transition-all flex items-center">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Timesheets</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
                        [
                            'url' => route('time.attendance.my-records'),
                            'label' => 'My Records',
                            'active' => request()->routeIs('time.attendance.my-records')
                        ],
                        [
                            'url' => route('time.attendance.punch-in-out'),
                            'label' => 'Punch In/Out',
                            'active' => request()->routeIs('time.attendance.punch-in-out')
                        ],
                        [
                            'url' => route('time.attendance.employee-records'),
                            'label' => 'Employee Records',
                            'active' => request()->routeIs('time.attendance.employee-records')
                        ],
                        [
                            'url' => route('time.attendance.configuration'),
                            'label' => 'Configuration',
                            'active' => request()->routeIs('time.attendance.configuration')
                        ],
                    ]"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center">
                        <span class="text-sm font-medium text-slate-700">Attendance</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
                        [
                            'url' => route('time.reports.project-reports'),
                            'label' => 'Project Reports',
                            'active' => request()->routeIs('time.reports.project-reports')
                        ],
                        [
                            'url' => route('time.reports.employee-reports'),
                            'label' => 'Employee Reports',
                            'active' => request()->routeIs('time.reports.employee-reports')
                        ],
                        [
                            'url' => route('time.reports.attendance-summary'),
                            'label' => 'Attendance Summary',
                            'active' => request()->routeIs('time.reports.attendance-summary')
                        ],
                    ]"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center tab-trigger">
                        <span class="text-sm font-medium text-slate-700">Reports</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Project Info</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
            </div>
        </div>

        <!-- Edit Timesheet Card -->
        <section class="hr-card mt-4 p-6">
            <!-- Header Row -->
            <div class="flex items-center justify-between gap-6 mb-4">
                <h2 class="text-sm font-bold text-[var(--text-primary)]">
                    Edit Timesheet
                </h2>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-[var(--text-muted)]">
                        Timesheet Period
                    </span>
                    <span class="text-xs font-semibold text-[var(--text-primary)] whitespace-nowrap">
                        {{ $timesheetPeriod['start'] }} - {{ $timesheetPeriod['end'] }}
                    </span>
                </div>
            </div>

            <!-- Timesheet Editable Grid -->
            <div class="overflow-x-auto">
                <div class="min-w-max rounded-xl border border-[var(--border-default)] bg-[var(--bg-card)]">
                    <!-- Header -->
                    <div class="grid grid-cols-[minmax(160px,1.5fr)_minmax(160px,1.5fr)_repeat(7,minmax(72px,1fr))_minmax(64px,0.75fr)] text-center">
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Project
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Activity
                            </div>
                        </div>
                        @foreach($days as $day)
                            <div class="px-3 py-3 border-b border-[var(--border-default)] flex flex-col items-center justify-center gap-1">
                                <span class="text-xs font-semibold text-[var(--text-primary)]">
                                    {{ $day['day_of_month'] }}
                                </span>
                                <span class="text-[10px] font-medium text-[var(--text-muted)] uppercase tracking-wide">
                                    {{ $day['day_name_short'] }}
                                </span>
                            </div>
                        @endforeach
                        <div class="px-3 py-3 border-b border-[var(--border-default)] flex items-center justify-center">
                            <span class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                &nbsp;
                            </span>
                        </div>
                    </div>

                    <!-- Single Editable Row (static for now) -->
                    @foreach($rows as $row)
                        <div class="grid grid-cols-[minmax(160px,1.5fr)_minmax(160px,1.5fr)_repeat(7,minmax(72px,1fr))_minmax(64px,0.75fr)] items-center border-t border-[var(--border-default)]">
                            <!-- Project -->
                            <div class="px-4 py-3">
                                <input 
                                    type="text" 
                                    class="hr-input" 
                                    placeholder="Type for hints..."
                                    value="{{ $row['project'] }}"
                                >
                            </div>

                            <!-- Activity -->
                            <div class="px-4 py-3">
                                <div class="relative">
                                    <select class="hr-select pr-8">
                                        <option>-- Select --</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Hours per day -->
                            @foreach($days as $index => $day)
                                <div class="px-3 py-3">
                                    <input 
                                        type="text" 
                                        class="hr-input text-center" 
                                        value="{{ $row['hours'][$index] }}"
                                    >
                                </div>
                            @endforeach

                            <!-- Delete row icon -->
                            <div class="px-3 py-3 flex items-center justify-center">
                                <button type="button" class="rounded-full border border-[var(--border-default)] bg-[var(--bg-card)] w-8 h-8 flex items-center justify-center text-[var(--text-muted)] hover:bg-[var(--bg-hover)] transition-all">
                                    🗑
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <!-- Add Row -->
                    <div class="border-t border-[var(--border-default)] px-4 py-4 flex items-center gap-2">
                        <button type="button" class="rounded-full border border-[var(--border-default)] bg-[var(--bg-card)] w-8 h-8 flex items-center justify-center text-[var(--text-muted)] hover:bg-[var(--bg-hover)] transition-all">
                            +
                        </button>
                        <span class="text-xs font-medium text-[var(--text-primary)]">
                            Add Row
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="mt-4 flex items-center justify-end gap-3">
                <a href="{{ route('time.my-timesheets') }}" class="hr-btn-secondary inline-flex items-center justify-center">
                    Cancel
                </a>
                <button type="button" class="hr-btn-secondary">
                    Reset
                </button>
                <button type="button" class="hr-btn-primary">
                    Save
                </button>
            </div>
        </section>
    </x-main-layout>
@endsection

