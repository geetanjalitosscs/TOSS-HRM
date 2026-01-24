@extends('layouts.app')

@section('title', 'Time - Attendance - Employee Records')

@section('body')
    <x-main-layout title="Time / Attendance / Employee Records">
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
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Reports</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Project Info</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
            </div>
        </div>

        <!-- Employee Attendance Records Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6 mb-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800">Employee Attendance Records</h2>
                <button class="w-6 h-6 rounded bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <span class="text-xs text-gray-600">▲</span>
                </button>
            </div>

            <!-- Filter Form -->
            <div class="flex items-end gap-4">
                <!-- Employee Name Input -->
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                    <input 
                        type="text" 
                        name="employee_name" 
                        class="w-full px-3 py-2.5 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                        placeholder="Type for hints..."
                    >
                </div>

                <!-- Date Input with Calendar Icon -->
                <div class="w-64">
                    <label class="block text-xs font-medium text-slate-700 mb-1">Date<span class="text-red-500">*</span></label>
                    <div class="flex items-stretch">
                        <input 
                            type="text" 
                            name="date" 
                            value="{{ $selectedDate }}" 
                            class="flex-1 px-3 py-2.5 text-sm border border-purple-200 rounded-l-lg rounded-r-none focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                            readonly
                        >
                        <button 
                            type="button" 
                            class="px-3 py-2.5 flex items-center justify-center text-gray-400 bg-gray-50 border border-l-0 border-purple-200 rounded-r-lg hover:bg-gray-100 hover:text-gray-600 transition-colors"
                            onclick="document.getElementById('datePicker').showPicker()"
                        >
                            <i class="fas fa-calendar text-sm"></i>
                        </button>
                        <input 
                            type="date" 
                            id="datePicker" 
                            class="hidden"
                            onchange="updateDateDisplay(this.value)"
                        >
                    </div>
                </div>

                <!-- View Button -->
                <div class="flex-shrink-0">
                    <button 
                        type="button" 
                        class="px-6 py-2.5 text-sm font-medium text-white bg-[var(--color-hr-primary)] rounded-lg hover:bg-[var(--color-hr-primary-dark)] transition-all shadow-sm"
                    >
                        View
                    </button>
                </div>
            </div>

            <!-- Required Text -->
            <div class="text-xs text-gray-500 mt-2">* Required</div>
        </div>

        <!-- Records Found Section -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100">
            <!-- Header -->
            <div class="px-6 pt-6 pb-4">
                <h2 class="text-sm font-medium text-slate-700">({{ count($records) }}) Records Found</h2>
            </div>

            <!-- Table -->
            <div class="px-6 pb-6">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Employee Name</th>
                            <th class="px-4 py-2.5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wide">Total Duration (Hours)</th>
                            <th class="px-4 py-2.5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        @foreach($records as $index => $record)
                        <tr class="border-b border-gray-200 {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-2.5 text-sm text-slate-700">{{ $record['employee_name'] }}</td>
                            <td class="px-4 py-2.5 text-sm text-slate-700 text-center">{{ number_format($record['total_duration'], 2) }}</td>
                            <td class="px-4 py-2.5 text-center">
                                <button 
                                    type="button" 
                                    class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-all"
                                >
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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

                // Date picker functionality
                function updateDateDisplay(dateValue) {
                    if (!dateValue) return;
                    // Convert YYYY-MM-DD to YYYY-DD-MM format as shown in image
                    const [year, month, day] = dateValue.split('-');
                    const formattedDate = `${year}-${day}-${month}`;
                    document.querySelector('input[name="date"]').value = formattedDate;
                }

                // Initialize date picker with current value
                const dateInput = document.querySelector('input[name="date"]');
                const datePicker = document.getElementById('datePicker');
                if (dateInput && dateInput.value) {
                    // Convert YYYY-DD-MM to YYYY-MM-DD for date input
                    const [year, day, month] = dateInput.value.split('-');
                    if (year && month && day) {
                        datePicker.value = `${year}-${month}-${day}`;
                    }
                }
            });
        </script>
    </x-main-layout>
@endsection
