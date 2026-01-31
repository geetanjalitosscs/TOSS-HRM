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
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$projectInfoItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $projectInfoHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $projectInfoHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Project Info</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Projects Filter + List Card -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <!-- Header -->
            <div class="flex items-center mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-project-diagram" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Projects</span>
                </h2>
            </div>

            <div id="projectsBody">
            <!-- Filter Form (Initially Visible) -->
            <div id="filterSection" class="mb-4">
                <!-- Form Fields -->
                <div class="flex gap-4 mb-4">
                    <!-- Customer Name -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Customer Name</label>
                        <input 
                            type="text" 
                            name="customer_name" 
                            class="hr-input"
                            placeholder="Type for hints..."
                        >
                    </div>

                    <!-- Project -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Project</label>
                        <input 
                            type="text" 
                            name="project" 
                            class="hr-input"
                            placeholder="Type for hints..."
                        >
                    </div>

                    <!-- Project Admin -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Project Admin</label>
                        <input 
                            type="text" 
                            name="project_admin" 
                            class="hr-input"
                            placeholder="Type for hints..."
                        >
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t mb-4" style="border-color: var(--border-default);"></div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3">
                    <button 
                        type="button" 
                        class="hr-btn-secondary"
                        onclick="resetFilters()"
                    >
                        Reset
                    </button>
                    <button 
                        type="button" 
                        class="hr-btn-primary"
                    >
                        Search
                    </button>
                </div>
            </div>

            <!-- Projects List Section -->
            <div class="mt-2">
                <div class="flex items-center justify-between mb-3">
                    <x-admin.add-button />
                </div>

                <x-admin.data-table
                    title=""
                    :records="$projects"
                    :columns="[
                        ['label' => 'Customer Name', 'sortable' => true],
                        ['label' => 'Project', 'sortable' => true],
                        ['label' => 'Project Admins', 'sortable' => false],
                    ]"
                    :addButton="false">
                    @foreach($projects as $project)
                        <x-admin.table-row>
                            <x-admin.table-cell>
                                <div class="text-xs font-medium break-words" style="color: var(--text-primary);">
                                    {{ $project->customer_name }}
                                </div>
                            </x-admin.table-cell>
                            <x-admin.table-cell>
                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                    {{ $project->project_name }}
                                </div>
                            </x-admin.table-cell>
                            <x-admin.table-cell>
                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                    {{ $project->admins ?: '-' }}
                                </div>
                            </x-admin.table-cell>
                        </x-admin.table-row>
                    @endforeach
                </x-admin.data-table>
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
