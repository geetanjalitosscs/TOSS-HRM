@extends('layouts.app')

@section('title', 'Time - Timesheets')

@section('body')
    <x-main-layout title="Time / Timesheets">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b overflow-x-auto overflow-y-visible" style="border-color: var(--border-default);">
                            @php
                                $timesheetsItems = [
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
                                ];
                                $timesheetsHasActive = collect($timesheetsItems)->contains('active', true);
                                
                                $attendanceItems = [
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
                                ];
                                $attendanceHasActive = collect($attendanceItems)->contains('active', true);
                                
                                $reportsItems = [
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
                                ];
                                $reportsHasActive = collect($reportsItems)->contains('active', true);
                                
                                $projectInfoItems = [
                                    [
                                        'url' => route('time.project-info.customers'),
                                        'label' => 'Customers',
                                        'active' => request()->routeIs('time.project-info.customers')
                                    ],
                                    [
                                        'url' => route('time.project-info.projects'),
                                        'label' => 'Projects',
                                        'active' => request()->routeIs('time.project-info.projects')
                                    ],
                                ];
                                $projectInfoHasActive = collect($projectInfoItems)->contains('active', true);
                            @endphp
                            <x-dropdown-menu 
                                :items="$timesheetsItems"
                                position="left"
                                width="w-48">
                                <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                                    <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $timesheetsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Timesheets</span>
                                    <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                                </div>
                            </x-dropdown-menu>
                            <x-dropdown-menu 
                                :items="$attendanceItems"
                                position="left"
                                width="w-56">
                                <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                                    <span class="text-sm {{ $attendanceHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $attendanceHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Attendance</span>
                                    <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                                </div>
                            </x-dropdown-menu>
                            <x-dropdown-menu 
                                :items="$reportsItems"
                                position="left"
                                width="w-56">
                                <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                                    <span class="text-sm {{ $reportsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $reportsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Reports</span>
                                    <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                                </div>
                            </x-dropdown-menu>
                            <x-dropdown-menu 
                                :items="$projectInfoItems"
                                position="left"
                                width="w-56">
                                <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $projectInfoHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                                    <span class="text-sm {{ $projectInfoHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $projectInfoHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Project Info</span>
                                    <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                                </div>
                            </x-dropdown-menu>
                        </div>
                    </div>

                    <!-- Select Employee Section -->
                    <section class="hr-card p-6 mb-6 border-t-0 rounded-t-none">
                        <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                            <i class="fas fa-user-check" style="color: var(--color-hr-primary);"></i> <span class="mt-0.5">Select Employee</span>
                        </h2>
                        <div class="rounded-lg p-4 border" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name <span class="text-red-500">*</span></label>
                                    <input type="text" class="hr-input w-full px-3 py-2.5 text-sm rounded-lg" placeholder="Type for hints...">
                                    <div class="text-xs text-gray-500 mt-1">* Required</div>
                                </div>
                                <div class="flex items-start pt-6">
                                    <button class="hr-btn-primary">
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Timesheets Pending Action Section -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                            <i class="fas fa-clock" style="color: var(--color-hr-primary);"></i> <span class="mt-0.5">Timesheets Pending Action</span>
                        </h2>
                        
                        <!-- Records Count -->
                        <x-records-found :count="count($timesheets)" />

                        <!-- Table Header -->
                        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee Name</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Timesheet Period</div>
                            </div>
                            <div class="flex-shrink-0" style="width: 70px;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                            </div>
                        </div>

                        <!-- Timesheet Cards List -->
                        <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                            @foreach($timesheets as $timesheet)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $timesheet['employee_name'] }}</div>
                                </div>
                                
                                <!-- Timesheet Period -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $timesheet['timesheet_period'] }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="flex items-center justify-center">
                                        <button class="hr-btn-primary">
                                            View
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
    </x-main-layout>
@endsection

