@extends('layouts.app')

@section('title', 'Time - Project Info - Projects')

@section('body')
    <x-main-layout title="Time / Project Info / Projects">
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
                <x-dropdown-menu 
                    :items="$projectInfoItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $projectInfoHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $projectInfoHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Project Info</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Projects Filter Section -->
        <div class="mt-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 w-full">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-800">Projects</h2>
                    <button 
                        id="toggleProjectsFilter" 
                        class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                        onclick="toggleFilterSection()"
                    >
                        <span class="text-xs text-gray-600" id="toggleIcon">▲</span>
                    </button>
                </div>

                <!-- Filter Form (Initially Visible) -->
                <div id="filterSection">
                    <!-- Form Fields -->
                    <div class="flex gap-4 mb-4">
                        <!-- Customer Name -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Customer Name</label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                placeholder="Type for hints..."
                            >
                        </div>

                        <!-- Project -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Project</label>
                            <input 
                                type="text" 
                                name="project" 
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                placeholder="Type for hints..."
                            >
                        </div>

                        <!-- Project Admin -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Project Admin</label>
                            <input 
                                type="text" 
                                name="project_admin" 
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                placeholder="Type for hints..."
                            >
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 mb-4"></div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3">
                        <button 
                            type="button" 
                            class="px-6 py-2.5 text-sm font-medium text-green-600 bg-white border border-green-500 rounded-lg hover:bg-green-50 transition-colors"
                            onclick="resetFilters()"
                        >
                            Reset
                        </button>
                        <button 
                            type="button" 
                            class="px-6 py-2.5 text-sm font-medium text-white rounded-lg transition-colors hover:opacity-90"
                            style="background-color: var(--color-hr-primary);"
                        >
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects List Section -->
        <div class="mt-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Header with Add Button -->
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <button 
                            type="button" 
                            class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors hover:opacity-90 flex items-center gap-1"
                            style="background-color: var(--color-hr-primary);"
                        >
                            <span>+</span>
                            <span>Add</span>
                        </button>
                    </div>
                    <h2 class="text-sm font-medium text-slate-700">(11) Records Found</h2>
                </div>

                <!-- Table -->
                <div class="px-6 pb-6">
                    <table class="w-full">
                        <!-- Table Header -->
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-2.5 text-left">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">
                                    <div class="flex items-center gap-1">
                                        <span>Customer Name</span>
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-[10px] text-gray-400 leading-none">▲</span>
                                            <span class="text-[10px] text-gray-400 leading-none">▼</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">
                                    <div class="flex items-center gap-1">
                                        <span>Project</span>
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-[10px] text-gray-400 leading-none">▲</span>
                                            <span class="text-[10px] text-gray-400 leading-none">▼</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Project Admins</th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">ACME Ltd</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">ACME Ltd</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Apache Software Foundation</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">ASF - Phase 1</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">The Coca-Cola Company</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Coke - Phase 1</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

            // Toggle filter section
            function toggleFilterSection() {
                const filterSection = document.getElementById('filterSection');
                const toggleIcon = document.getElementById('toggleIcon');
                
                if (filterSection.style.display === 'none') {
                    filterSection.style.display = 'block';
                    toggleIcon.textContent = '▲';
                } else {
                    filterSection.style.display = 'none';
                    toggleIcon.textContent = '▼';
                }
            }

            // Reset filters
            function resetFilters() {
                document.querySelector('input[name="customer_name"]').value = '';
                document.querySelector('input[name="project"]').value = '';
                document.querySelector('input[name="project_admin"]').value = '';
            }
        </script>
    </x-main-layout>
@endsection
