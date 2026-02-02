@extends('layouts.app')

@section('title', 'Time - Project Info - Customers')

@section('body')
    <x-main-layout title="Time / Project Info / Customers">
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
                {{-- <x-dropdown-menu 
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
                </x-dropdown-menu> --}}
                <a href="{{ route('time.project-info.customers') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.customers') ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.customers') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Customers</span>
                </a>
                <a href="{{ route('time.project-info.projects') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.projects') ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.projects') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Projects</span>
                </a>
            </div>
        </div>

        <!-- Customers List Section -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <!-- Header with Title and Add Button -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Customers</span>
                </h2>
                <x-admin.add-button />
            </div>

            <x-admin.data-table
                title=""
                :records="$customers"
                :columns="[
                    ['label' => 'Name', 'sortable' => true],
                    ['label' => 'Description', 'sortable' => false],
                ]"
                :addButton="false">
                @foreach($customers as $customer)
                    <x-admin.table-row>
                        <x-admin.table-cell>
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">
                                {{ $customer->name }}
                            </div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs break-words" style="color: var(--text-primary);">
                                {{ $customer->description ?: '-' }}
                            </div>
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
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
        </script>
    </x-main-layout>
@endsection
