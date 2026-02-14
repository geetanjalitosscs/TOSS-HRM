@extends('layouts.app')

@section('title', 'Time - Reports - Employee Reports')

@section('body')
    <x-main-layout title="Project Management">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible">
                @php
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
                <a href="{{ route('time.project-info.customers') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.customers') ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.customers') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Customers</span>
                </a>
                <a href="{{ route('time.project-info.projects') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.projects') ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.projects') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Projects</span>
                </a>
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Employee Report Form Section -->
        <section class="hr-card p-6 mb-3 border-t-0 rounded-t-none">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-user-clock" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Employee Report</span>
                </h2>
            </div>

            <form method="GET" action="{{ route('time.reports.employee-reports') }}" id="employee-reports-search-form">
                <!-- Form Fields -->
                <div class="space-y-4">
                    <!-- Employee Name and Project Name Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Employee Name Input -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name<span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="employee_name" 
                                value="{{ request('employee_name', '') }}"
                                class="hr-input w-full px-3 py-2.5 text-sm rounded-lg" 
                                placeholder="Type for hints..."
                            >
                        </div>

                        <!-- Project Name Input -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Project Name</label>
                            <input 
                                type="text" 
                                name="project" 
                                value="{{ request('project', '') }}"
                                class="hr-input w-full px-3 py-2.5 text-sm rounded-lg" 
                                placeholder="Type for hints..."
                            >
                        </div>
                    </div>

                    <!-- Project Date Range -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Project Date Range</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <x-date-picker 
                                    name="from_date" 
                                    value="{{ request('from_date') }}"
                                    label="From"
                                />
                            </div>
                            <div class="flex-1">
                                <x-date-picker 
                                    name="to_date" 
                                    value="{{ request('to_date') }}"
                                    label="To"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer: Required Text and Search/Reset Buttons -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-xs" style="color: var(--text-primary);">* Required</div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="resetEmployeeReportsFilters()" class="hr-btn-secondary">
                            Reset
                        </button>
                        <button type="submit" class="hr-btn-primary">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <script>
            // Reset button handler
            function resetEmployeeReportsFilters() {
                var searchForm = document.getElementById('employee-reports-search-form');
                if (searchForm) {
                    // Clear all input fields
                    var inputs = searchForm.querySelectorAll('input[type="text"]');
                    inputs.forEach(function(input) {
                        input.value = '';
                    });
                    
                    // Clear select fields
                    var selects = searchForm.querySelectorAll('select');
                    selects.forEach(function(select) {
                        select.selectedIndex = 0;
                    });
                    
                    // Clear date picker values
                    var dateInputs = searchForm.querySelectorAll('input[type="hidden"][name="from_date"], input[type="hidden"][name="to_date"]');
                    dateInputs.forEach(function(input) {
                        input.value = '';
                    });
                    
                    // Clear visible date picker inputs
                    var datePickerInputs = searchForm.querySelectorAll('input[data-date-input]');
                    datePickerInputs.forEach(function(input) {
                        input.value = '';
                    });
                    
                    // Submit form to reload page with cleared filters
                    window.location.href = '{{ route("time.reports.employee-reports") }}';
                }
            }
            
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
