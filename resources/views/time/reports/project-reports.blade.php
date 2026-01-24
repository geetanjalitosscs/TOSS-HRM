@extends('layouts.app')

@section('title', 'Time - Reports - Project Reports')

@section('body')
    <x-main-layout title="Time / Reports / Project Reports">
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

        <!-- Project Report Form Section -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6 mb-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800">Project Report</h2>
                <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <span class="text-xs text-gray-600">▲</span>
                </button>
            </div>

            <!-- Form Fields -->
            <div class="space-y-4">
                <!-- Project Name Input -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Project Name<span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="project_name" 
                        class="w-full px-3 py-2.5 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                        placeholder="Type for hints..."
                    >
                </div>

                <!-- Project Date Range -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Project Date Range</label>
                    <div class="flex items-center gap-4">
                        <!-- From Date Input -->
                        <div class="flex-1">
                            <div class="flex items-stretch">
                                <input 
                                    type="text" 
                                    name="date_from" 
                                    placeholder="From"
                                    class="flex-1 px-3 py-2.5 text-sm border border-purple-200 rounded-l-lg rounded-r-none focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    readonly
                                >
                                <button 
                                    type="button" 
                                    class="px-3 py-2.5 flex items-center justify-center text-gray-400 bg-gray-50 border border-l-0 border-purple-200 rounded-r-lg hover:bg-gray-100 hover:text-gray-600 transition-colors"
                                    onclick="document.getElementById('dateFromPicker').showPicker()"
                                >
                                    <i class="fas fa-calendar text-sm"></i>
                                </button>
                                <input 
                                    type="date" 
                                    id="dateFromPicker" 
                                    class="hidden"
                                    onchange="updateDateDisplay(this.value, 'date_from')"
                                >
                            </div>
                        </div>

                        <!-- To Date Input -->
                        <div class="flex-1">
                            <div class="flex items-stretch">
                                <input 
                                    type="text" 
                                    name="date_to" 
                                    placeholder="To"
                                    class="flex-1 px-3 py-2.5 text-sm border border-purple-200 rounded-l-lg rounded-r-none focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    readonly
                                >
                                <button 
                                    type="button" 
                                    class="px-3 py-2.5 flex items-center justify-center text-gray-400 bg-gray-50 border border-l-0 border-purple-200 rounded-r-lg hover:bg-gray-100 hover:text-gray-600 transition-colors"
                                    onclick="document.getElementById('dateToPicker').showPicker()"
                                >
                                    <i class="fas fa-calendar text-sm"></i>
                                </button>
                                <input 
                                    type="date" 
                                    id="dateToPicker" 
                                    class="hidden"
                                    onchange="updateDateDisplay(this.value, 'date_to')"
                                >
                            </div>
                        </div>

                        <!-- Only Include Approved Timesheets Toggle -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-700 whitespace-nowrap">Only Include Approved Timesheets</span>
                            <div class="relative flex-shrink-0">
                                <input type="checkbox" class="sr-only" id="toggle-approved">
                                <label for="toggle-approved" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center" id="toggle-bg-approved" style="background-color: #E5E7EB;">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="toggle-circle-approved"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Required Text and View Button -->
            <div class="flex items-center justify-between mt-6">
                <div class="text-xs text-gray-500">* Required</div>
                <button 
                    type="button" 
                    class="px-6 py-2.5 text-sm font-medium text-white bg-[var(--color-hr-primary)] rounded-lg hover:bg-[var(--color-hr-primary-dark)] transition-all shadow-sm"
                >
                    View
                </button>
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
                function updateDateDisplay(dateValue, inputName) {
                    if (!dateValue) return;
                    // Convert YYYY-MM-DD to readable format
                    const [year, month, day] = dateValue.split('-');
                    const formattedDate = `${year}-${day}-${month}`;
                    document.querySelector(`input[name="${inputName}"]`).value = formattedDate;
                }

                // Toggle switch functionality
                const toggleCheckbox = document.getElementById('toggle-approved');
                const toggleBg = document.getElementById('toggle-bg-approved');
                const toggleCircle = document.getElementById('toggle-circle-approved');
                
                if (toggleCheckbox && toggleBg && toggleCircle) {
                    toggleCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            toggleBg.style.backgroundColor = 'var(--color-hr-primary)';
                            toggleCircle.classList.add('translate-x-5');
                            toggleCircle.classList.remove('translate-x-0.5');
                        } else {
                            toggleBg.style.backgroundColor = '#E5E7EB';
                            toggleCircle.classList.remove('translate-x-5');
                            toggleCircle.classList.add('translate-x-0.5');
                        }
                    });
                }
            });
        </script>
    </x-main-layout>
@endsection
