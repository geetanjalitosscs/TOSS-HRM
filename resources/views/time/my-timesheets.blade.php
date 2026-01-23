@extends('layouts.app')

@section('title', 'Time - My Timesheets')

@section('body')
    <x-main-layout title="Time / My Timesheets">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible">
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
                @endphp
                <x-dropdown-menu 
                    :items="$timesheetsItems"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Timesheets</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Attendance</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Reports</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Project Info</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
            </div>
        </div>

        <!-- My Timesheet Card -->
        <section class="hr-card mt-4 p-6">
            <!-- Header Row -->
            <div class="flex items-center justify-between gap-6 mb-4">
                <h2 class="text-sm font-bold text-[var(--text-primary)]">
                    My Timesheet
                </h2>

                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium text-[var(--text-muted)]">
                        Timesheet Period
                    </span>
                    <div class="flex items-center gap-2">
                        <button type="button" class="hr-btn-secondary !px-2 !py-1 rounded-full flex items-center justify-center text-xs">
                            ‹
                        </button>
                        <div class="flex items-center gap-2 px-4 py-1.5 rounded-full border border-[var(--border-default)] bg-[var(--bg-card)] shadow-sm">
                            <span class="text-xs font-medium text-[var(--text-primary)] whitespace-nowrap">
                                {{ $timesheetPeriod['start'] }} to {{ $timesheetPeriod['end'] }}
                            </span>
                            <button type="button" class="hr-btn-secondary !px-2 !py-1 rounded-full flex items-center justify-center text-xs">
                                🗓
                            </button>
                        </div>
                        <button type="button" class="hr-btn-secondary !px-2 !py-1 rounded-full flex items-center justify-center text-xs">
                            ›
                        </button>
                    </div>
                </div>
            </div>

            <!-- Timesheet Grid -->
            <div class="overflow-x-auto">
                <div class="min-w-max rounded-xl border border-[var(--border-default)] bg-[var(--bg-card)]">
                    <!-- Header -->
                    <div class="grid grid-cols-12 text-center">
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left col-span-2">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Project
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left col-span-2">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Activity
                            </div>
                        </div>
                        @foreach($days as $day)
                            <div class="px-3 py-3 border-b border-[var(--border-default)] flex flex-col items-center justify-center gap-1 col-span-1">
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
                                Total
                            </span>
                        </div>
                    </div>

                    <!-- Empty State Row -->
                    <div class="border-t border-[var(--border-default)]">
                        <div class="px-4 py-6 text-xs text-[var(--text-muted)] text-center">
                            No Records Found
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Status + Actions -->
            <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="text-xs font-medium text-[var(--text-muted)]">
                    Status:
                    <span class="text-[var(--text-primary)]">
                        {{ $status }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('time.my-timesheets.edit') }}" class="hr-btn-secondary inline-flex items-center justify-center">
                        Edit
                    </a>
                    <button type="button" class="hr-btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle tab hover and open states
                const tabTriggers = document.querySelectorAll('.tab-trigger');
                
                tabTriggers.forEach(trigger => {
                    const group = trigger.closest('.group');
                    const dropdown = group?.querySelector('.hr-dropdown-menu');
                    const isActive = trigger.classList.contains('border-b-2');
                    
                    if (isActive) {
                        trigger.dataset.hasActive = 'true';
                    }
                    
                    // Hover effect - add border on hover
                    trigger.addEventListener('mouseenter', function() {
                        if (!this.dataset.hasActive) {
                            this.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                            this.classList.remove('hover:bg-purple-50/30');
                            const span = this.querySelector('span:first-of-type');
                            if (span) {
                                span.classList.remove('font-medium', 'text-slate-700');
                                span.classList.add('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                            }
                        }
                    });
                    
                    // Remove border on mouse leave only if not active and not open
                    trigger.addEventListener('mouseleave', function() {
                        if (!this.dataset.hasActive) {
                            const isOpen = dropdown?.classList.contains('show');
                            if (!isOpen) {
                                this.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                this.classList.add('hover:bg-purple-50/30');
                                const span = this.querySelector('span:first-of-type');
                                if (span) {
                                    span.classList.remove('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                    span.classList.add('font-medium', 'text-slate-700');
                                }
                            }
                        }
                    });
                });
                
                // Keep border when dropdown is open
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            const dropdown = mutation.target;
                            if (dropdown.classList.contains('hr-dropdown-menu')) {
                                const trigger = dropdown.closest('.group')?.querySelector('.tab-trigger');
                                if (trigger) {
                                    if (dropdown.classList.contains('show')) {
                                        // Dropdown opened - add border
                                        trigger.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.remove('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                            span.classList.remove('font-medium', 'text-slate-700');
                                            span.classList.add('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                        }
                                    } else if (!trigger.dataset.hasActive) {
                                        // Dropdown closed - remove border only if not active
                                        trigger.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.add('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                            span.classList.remove('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                            span.classList.add('font-medium', 'text-slate-700');
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
                
                document.querySelectorAll('.hr-dropdown-menu').forEach(menu => {
                    observer.observe(menu, { attributes: true, attributeFilter: ['class'] });
                });
            });
        </script>
    </x-main-layout>
@endsection

