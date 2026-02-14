@extends('layouts.app')

@section('title', 'Time - Attendance - Employee Records')

@section('body')
    <x-main-layout title="Time">
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
            </div>
        </div>

        <!-- Employee Attendance Records Filter Section -->
        <section class="hr-card p-6 mb-3 border-t-0 rounded-t-none">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Employee Attendance Records</span>
                </h2>
                <button class="w-6 h-6 rounded bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <span class="text-xs text-gray-600">▲</span>
                </button>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('time.attendance.employee-records') }}" id="employee-attendance-search-form" class="rounded-lg p-4 border mb-4" style="background-color: var(--bg-hover); border-color: var(--border-default);">
            <div class="flex gap-4">
                <!-- Employee Name Input -->
                <div class="flex-1">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                    <input 
                        type="text" 
                        name="employee_name" 
                            value="{{ $employeeName ?? '' }}"
                        class="hr-input w-full px-3 py-2.5 text-sm rounded-lg" 
                        placeholder="Type for hints..."
                    >
                </div>

                <!-- Date Input with Calendar Icon -->
                <div class="w-64">
                    <x-date-picker 
                        name="date" 
                        value="{{ $selectedDate }}" 
                        label="Date"
                        required="true"
                    />
                </div>

                    <!-- Buttons -->
                    <div class="flex-shrink-0 flex items-start pt-6 gap-2">
                        <button type="button" class="hr-btn-secondary" onclick="resetEmployeeAttendanceFilters()">
                            Reset
                        </button>
                        <button type="submit" class="hr-btn-primary">
                        View
                    </button>
                </div>
            </div>

            <!-- Required Text -->
            <div class="text-xs text-gray-500 mt-2">* Required</div>
            </form>
        </section>

        <!-- Records Found Section -->
        <section class="hr-card">
            <!-- Header -->
            <div class="px-6 pt-6 pb-4">
                <x-records-found :count="count($records)" />
            </div>

            <!-- Table -->
            <div class="px-6 pb-6">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee Name</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 180px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Total Duration (Hours)</div>
                        </div>
                        <div class="flex-shrink-0" style="width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                        </div>
                    </div>
                    <!-- Table Rows -->
                    <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                        @forelse($records as $record)
                        <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $record->employee_name }}</div>
                            </div>
                            <div class="flex-shrink-0" style="width: 180px;">
                                <div class="text-xs text-center break-words" style="color: var(--text-primary);">{{ number_format($record->total_duration, 2) }}</div>
                            </div>
                            <div class="flex-shrink-0" style="width: 100px;">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('time.attendance.employee-records.view', ['employeeId' => $record->employee_id, 'date' => $selectedDate]) }}" class="hr-btn-primary px-3 py-1 text-xs">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                            No Records Found
                        </div>
                        @endforelse
                    </div>
                </div>
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

                // Reset button handler
                function resetEmployeeAttendanceFilters() {
                    var searchForm = document.getElementById('employee-attendance-search-form');
                    if (searchForm) {
                        // Clear all input values including date picker
                        var employeeNameInput = searchForm.querySelector('input[name="employee_name"]');
                        if (employeeNameInput) {
                            employeeNameInput.value = '';
                        }
                        
                        // Clear date picker - find the actual date input inside the date-picker component
                        var dateInput = searchForm.querySelector('input[name="date"]');
                        if (dateInput) {
                            dateInput.value = '';
                        }
                        
                        // Navigate to base route (no query) so URL is clean
                        window.location.href = "{{ route('time.attendance.employee-records') }}";
                    }
                }
                window.resetEmployeeAttendanceFilters = resetEmployeeAttendanceFilters;

            });
        </script>
    </x-main-layout>
@endsection
