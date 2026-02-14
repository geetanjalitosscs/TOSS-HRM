@extends('layouts.app')

@section('title', 'Time - Reports - Attendance Summary')

@section('body')
    <x-main-layout title="Time / Reports / Attendance Summary">
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
                            'active' => request()->routeIs('time.attendance.configuration'),
                            'hidden' => true
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
                @endphp
                <x-dropdown-menu 
                    :items="$timesheetsItems"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $timesheetsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Timesheets</span>
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
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $reportsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Attendance Total Summary Report Form Section -->
        <section class="hr-card p-6 mb-3 border-t-0 rounded-t-none">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-check" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Attendance Total Summary Report</span>
                </h2>
                <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <span class="text-xs text-gray-600">▲</span>
                </button>
            </div>

            <!-- Form Fields -->
            <div class="space-y-4">
                <!-- Row 1: Employee Name, Job Title, Sub Unit -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Employee Name Input -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                        <input 
                            type="text" 
                            name="employee_name" 
                            class="hr-input w-full px-3 py-2.5 text-sm rounded-lg" 
                            placeholder="Type for hints..."
                        >
                    </div>

                    <!-- Job Title Dropdown -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Job Title</label>
                        <div class="relative">
                            <select 
                                name="job_title" 
                                class="hr-select appearance-none w-full px-3 py-2.5 text-sm rounded-lg pr-10"
                                style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;"
                            >
                                <option value="">-- Select --</option>
                            </select>
                            <div class="pointer-events-none absolute top-1/2 -translate-y-1/2 right-3">
                                <i class="fas fa-chevron-down text-xs" style="color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sub Unit Dropdown -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Sub Unit</label>
                        <div class="relative">
                            <select 
                                name="sub_unit" 
                                class="hr-select appearance-none w-full px-3 py-2.5 text-sm rounded-lg pr-10"
                                style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;"
                            >
                                <option value="">-- Select --</option>
                            </select>
                            <div class="pointer-events-none absolute top-1/2 -translate-y-1/2 right-3">
                                <i class="fas fa-chevron-down text-xs" style="color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Employment Status, Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Employment Status Dropdown -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employment Status</label>
                        <div class="relative">
                            <select 
                                name="employment_status" 
                                class="hr-select appearance-none w-full px-3 py-2.5 text-sm rounded-lg pr-10"
                                style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;"
                            >
                                <option value="">-- Select --</option>
                            </select>
                            <div class="pointer-events-none absolute top-1/2 -translate-y-1/2 right-3">
                                <i class="fas fa-chevron-down text-xs" style="color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Date Range</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <x-date-picker 
                                    name="date_from" 
                                    label="From"
                                />
                            </div>
                            <div class="flex-1">
                                <x-date-picker 
                                    name="date_to" 
                                    label="To"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: View Button -->
            <div class="flex items-center justify-end mt-6">
                <button type="button" class="hr-btn-primary">
                    View
                </button>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
                            this.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-[var(--color-primary-light)]');
                            this.classList.remove('hover:bg-[var(--color-primary-light)]');
                            const span = this.querySelector('span:first-of-type');
                            if (span) {
                                span.classList.remove('font-medium');
                                span.classList.add('font-semibold');
                                span.style.color = 'var(--color-hr-primary-dark)';
                            }
                        }
                    });
                    
                    // Remove border on mouse leave only if not active and not open
                    trigger.addEventListener('mouseleave', function() {
                        if (!this.dataset.hasActive) {
                            const isOpen = dropdown?.classList.contains('show');
                            if (!isOpen) {
                                this.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-[var(--color-primary-light)]');
                                this.classList.add('hover:bg-[var(--color-primary-light)]');
                                const span = this.querySelector('span:first-of-type');
                                if (span) {
                                    span.classList.remove('font-semibold');
                                    span.classList.add('font-medium');
                                    span.style.color = 'var(--text-primary)';
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
                                        trigger.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-[var(--color-primary-light)]');
                                        trigger.classList.remove('hover:bg-[var(--color-primary-light)]');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                        span.classList.remove('font-medium');
                                        span.classList.add('font-semibold');
                                        span.style.color = 'var(--color-hr-primary-dark)';
                                    }
                                } else if (!trigger.dataset.hasActive) {
                                    // Dropdown closed - remove border only if not active
                                    trigger.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-[var(--color-primary-light)]');
                                    trigger.classList.add('hover:bg-[var(--color-primary-light)]');
                                    const span = trigger.querySelector('span:first-of-type');
                                    if (span) {
                                        span.classList.remove('font-semibold');
                                        span.classList.add('font-medium');
                                        span.style.color = 'var(--text-primary)';
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
