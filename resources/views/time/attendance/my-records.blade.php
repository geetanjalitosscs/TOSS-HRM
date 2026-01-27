@extends('layouts.app')

@section('title', 'Time - Attendance - My Records')

@section('body')
    <x-main-layout title="Time / Attendance / My Records">
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
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $timesheetsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Timesheets</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $attendanceHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $reportsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Project Info</span>
                    <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                </div>
            </div>
        </div>

        <!-- My Attendance Records Section -->
        <section class="hr-card p-6 mb-3 border-t-0 rounded-t-none">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-alt" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">My Attendance Records</span>
                </h2>
                <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <span class="text-xs text-gray-600">▲</span>
                </button>
            </div>

            <!-- Date Filter Section -->
            <div class="rounded-lg p-4 border mb-4" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex gap-4">
                    <div class="w-full max-w-xs">
                        <x-date-picker 
                            name="date" 
                            value="{{ $selectedDate }}"
                            label="Date"
                            required="true"
                        />
                        <div class="text-xs text-gray-500 mt-1">* Required</div>
                    </div>
                    <div class="flex items-start pt-6">
                        <button type="button" class="hr-btn-primary">
                            View
                        </button>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Table + Summary -->
            <section class="hr-card mt-6">
                <!-- Records Count + Total Duration -->
                <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b" style="border-color: var(--border-default);">
                    <x-records-found :count="count($records)" />
                    <div class="text-sm font-medium" style="color: var(--text-primary);">
                        Total Duration (Hours): 
                        <span style="color: var(--text-primary);">{{ number_format($totalDuration, 2) }}</span>
                    </div>
                </div>

                <!-- Table Header -->
                <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-shrink-0" style="width: 40px;">
                        <div class="flex items-center justify-center">
                            <input 
                                type="checkbox" 
                                id="select-all-punch-in" 
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 cursor-pointer"
                            >
                        </div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <label for="select-all-punch-in" class="text-xs font-semibold uppercase tracking-wide leading-tight break-words cursor-pointer" style="color: var(--text-primary);">
                            Punch In
                        </label>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Punch In Note</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Punch Out</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Punch Out Note</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 100px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Duration (Hours)</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                    </div>
                </div>

                <!-- Table Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @foreach($records as $index => $record)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <!-- Checkbox -->
                        <div class="flex-shrink-0" style="width: 40px;">
                            <div class="flex items-center justify-center">
                                <input 
                                    type="checkbox" 
                                    class="punch-in-checkbox w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                >
                            </div>
                        </div>
                        
                        <!-- Punch In -->
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record['punch_in'] }}</div>
                        </div>

                        <!-- Punch In Note -->
                        <div class="flex-1" style="min-width: 0;">
                            @if($record['punch_in_note'])
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record['punch_in_note'] }}</div>
                            @else
                                <div class="text-xs break-words" style="color: var(--text-muted);">—</div>
                            @endif
                        </div>

                        <!-- Punch Out -->
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record['punch_out'] }}</div>
                        </div>

                        <!-- Punch Out Note -->
                        <div class="flex-1" style="min-width: 0;">
                            @if($record['punch_out_note'])
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record['punch_out_note'] }}</div>
                            @else
                                <div class="text-xs break-words" style="color: var(--text-muted);">—</div>
                            @endif
                        </div>

                        <!-- Duration -->
                        <div class="flex-shrink-0" style="width: 100px;">
                            <div class="text-xs text-center break-words" style="color: var(--text-primary);">{{ number_format($record['duration'], 2) }}</div>
                        </div>

                        <!-- Actions -->
                        <div class="flex-shrink-0" style="width: 90px;">
                            <div class="flex items-center justify-center gap-2">
                                <button class="hr-action-delete flex-shrink-0" title="Delete">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                                <button class="hr-action-edit flex-shrink-0" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
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
                                this.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                this.classList.add('hover:bg-purple-50/30');
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
                                        trigger.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.remove('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                        span.classList.remove('font-medium');
                                        span.classList.add('font-semibold');
                                        span.style.color = 'var(--color-hr-primary-dark)';
                                    }
                                } else if (!trigger.dataset.hasActive) {
                                    // Dropdown closed - remove border only if not active
                                    trigger.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                    trigger.classList.add('hover:bg-purple-50/30');
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
                
                const selectAll = document.getElementById('select-all-punch-in');
                if (!selectAll) return;

                selectAll.addEventListener('change', function () {
                    const rowCheckboxes = document.querySelectorAll('.punch-in-checkbox');
                    rowCheckboxes.forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                });
            });
        </script>
    </x-main-layout>
@endsection

