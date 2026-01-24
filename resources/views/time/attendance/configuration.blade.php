@extends('layouts.app')

@section('title', 'Time - Attendance - Configuration')

@section('body')
    <x-main-layout title="Time / Attendance / Configuration">
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

        <!-- Attendance Configuration -->
        <div class="flex justify-center mt-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 w-full max-w-2xl">
                <!-- Header -->
                <h2 class="text-lg font-bold text-slate-800 mb-4">Attendance Configuration</h2>
                <div class="border-b border-gray-200 mb-6"></div>

                <!-- Configuration Options -->
                <div class="space-y-6 mb-6">
                    <!-- Option 1 -->
                    <div class="flex items-center justify-between">
                        <label class="text-sm text-slate-600 flex-1">Employee can change current time when punching in/out</label>
                        <div class="relative flex-shrink-0">
                            <input type="checkbox" class="sr-only" id="toggle-1" checked onchange="toggleSwitch(this, 'toggle-bg-1', 'toggle-circle-1')">
                            <label for="toggle-1" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center" id="toggle-bg-1" style="background-color: var(--color-hr-primary);">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="toggle-circle-1"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Option 2 -->
                    <div class="flex items-center justify-between">
                        <label class="text-sm text-slate-600 flex-1">Employee can edit/delete own attendance records</label>
                        <div class="relative flex-shrink-0">
                            <input type="checkbox" class="sr-only" id="toggle-2" checked onchange="toggleSwitch(this, 'toggle-bg-2', 'toggle-circle-2')">
                            <label for="toggle-2" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center" id="toggle-bg-2" style="background-color: var(--color-hr-primary);">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="toggle-circle-2"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Option 3 -->
                    <div class="flex items-center justify-between">
                        <label class="text-sm text-slate-600 flex-1">Supervisor can add/edit/delete attendance records of subordinates</label>
                        <div class="relative flex-shrink-0">
                            <input type="checkbox" class="sr-only" id="toggle-3" checked onchange="toggleSwitch(this, 'toggle-bg-3', 'toggle-circle-3')">
                            <label for="toggle-3" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer flex items-center" id="toggle-bg-3" style="background-color: var(--color-hr-primary);">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-5" id="toggle-circle-3"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button type="button" class="px-6 py-2.5 text-sm font-medium text-white rounded-lg transition-colors hover:opacity-90" style="background-color: var(--color-hr-primary);">
                        Save
                    </button>
                </div>
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
            });

            function toggleSwitch(checkbox, bgId, circleId) {
                const bg = document.getElementById(bgId);
                const circle = document.getElementById(circleId);
                
                if (checkbox.checked) {
                    bg.style.backgroundColor = 'var(--color-hr-primary)';
                    circle.classList.add('translate-x-5');
                    circle.classList.remove('translate-x-0.5');
                } else {
                    bg.style.backgroundColor = '#E5E7EB';
                    circle.classList.remove('translate-x-5');
                    circle.classList.add('translate-x-0.5');
                }
            }
        </script>
    </x-main-layout>
@endsection

