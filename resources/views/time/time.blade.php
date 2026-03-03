@extends('layouts.app')

@section('title', 'Time - Employee Worksheets')

@section('body')
    <x-main-layout title="Time">
        <!-- Top Navigation Tabs (same as My Worksheet page) -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible" style="border-color: var(--border-default);">
                @php
                    $timesheetsItems = [
                        [
                            'url' => route('time.my-timesheets'),
                            'label' => 'My Worksheets',
                            'active' => request()->routeIs('time.my-timesheets') || request()->routeIs('time.my-timesheets.edit')
                        ],
                        [
                            'url' => route('time'),
                            'label' => 'Employee Worksheets',
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
                            'active' => request()->routeIs('time.attendance.configuration'),
                            'hidden' => true
                        ],
                    ];
                    $attendanceHasActive = collect($attendanceItems)->contains('active', true);
                @endphp
                <x-dropdown-menu 
                    :items="$timesheetsItems"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $timesheetsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Worksheets</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $attendanceHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Employee Worksheets Card (read-only, similar to My Worksheet) -->
        <section class="hr-card p-6 border-t-0 rounded-t-none mt-0">
            <!-- Header Row -->
            <div class="flex items-center justify-between gap-6 mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Employee Worksheets</span>
                </h2>
            </div>

            <!-- Worksheet Grid -->
            <div class="overflow-x-auto">
                <div class="min-w-max rounded-xl border border-[var(--border-default)] bg-[var(--bg-card)]">
                    <!-- Header -->
                    <div class="grid grid-cols-3 md:grid-cols-4 text-center">
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Date
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Employee
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left md:col-span-2">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Work Description
                            </div>
                        </div>
                    </div>

                    <!-- Entries Rows -->
                    @if(count($groupedEntries) > 0)
                        @foreach($groupedEntries as $entry)
                            <div class="grid grid-cols-3 md:grid-cols-4 border-t border-[var(--border-default)]">
                                <!-- Date -->
                                <div class="px-4 py-3">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ \Carbon\Carbon::parse($entry['work_date'])->format('d M Y') }}
                                    </div>
                                </div>
                                <!-- Employee -->
                                <div class="px-4 py-3">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $entry['employee_name'] ?? 'Unknown' }}
                                    </div>
                                </div>
                                <!-- Work Description -->
                                <div class="px-4 py-3 md:col-span-2">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $entry['notes'] ?: '-' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty State Row -->
                        <div class="border-t border-[var(--border-default)]">
                            <div class="px-4 py-6 text-xs text-[var(--text-muted)] text-center">
                                No Employee Worksheets Found
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </x-main-layout>
@endsection


