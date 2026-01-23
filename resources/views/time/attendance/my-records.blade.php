@extends('layouts.app')

@section('title', 'Time - Attendance - My Records')

@section('body')
    <x-main-layout title="Time / Attendance / My Records">
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
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Reports</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Project Info</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
            </div>
        </div>

        <!-- My Attendance Records Section -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6 mb-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800">My Attendance Records</h2>
                <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <span class="text-xs text-gray-600">▲</span>
                </button>
            </div>

            <!-- Date Filter Section -->
            <div class="bg-purple-50/30 rounded-lg p-4 border border-purple-100 mb-4">
                <div class="flex items-end gap-4">
                    <div class="w-full max-w-xs">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="date" name="date" value="{{ $selectedDate }}" class="w-full px-3 py-2.5 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white pr-10">
                            <button type="button" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center text-purple-400 hover:text-purple-600 transition-colors" onclick="document.querySelector('input[name=date]').showPicker()">
                                📅
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">* Required</div>
                    </div>
                    <div>
                        <button type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition-all shadow-sm">
                            View
                        </button>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Table + Summary -->
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 mt-6">
                <!-- Records Count + Total Duration -->
                <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-purple-100">
                    <div class="text-sm text-slate-600 font-medium">
                        ({{ count($records) }}) Records Found
                    </div>
                    <div class="text-sm font-medium text-slate-700">
                        Total Duration (Hours): 
                        <span class="text-slate-900">{{ number_format($totalDuration, 2) }}</span>
                    </div>
                </div>

                <!-- Table Header -->
                <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
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
                        <label for="select-all-punch-in" class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words cursor-pointer">
                            Punch In
                        </label>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Punch In Note</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Punch Out</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Punch Out Note</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 100px;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Duration (Hours)</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 100px;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                    </div>
                </div>

                <!-- Table Rows -->
                <div class="border border-gray-200 border-t-0 rounded-b-lg">
                    @foreach($records as $index => $record)
                    <div class="bg-white border-b border-gray-200 last:border-b-0 px-3 py-2 hover:bg-gray-50 transition-colors flex items-center gap-2">
                        <!-- Checkbox -->
                        <div class="flex-shrink-0" style="width: 40px;">
                            <div class="flex items-center justify-center">
                                <input 
                                    type="checkbox" 
                                    class="punch-in-checkbox w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                >
                            </div>
                        </div>
                        
                        <!-- Row content pill -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 bg-slate-50 rounded-full px-4 py-2">
                                <!-- Punch In -->
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs text-gray-700 break-words">{{ $record['punch_in'] }}</div>
                                </div>

                                <!-- Punch In Note -->
                                <div class="flex-1 min-w-0">
                                    @if($record['punch_in_note'])
                                        <div class="text-xs text-gray-700 break-words">{{ $record['punch_in_note'] }}</div>
                                    @else
                                        <div class="text-xs text-gray-700 break-words">&nbsp;</div>
                                    @endif
                                </div>

                                <!-- Punch Out -->
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs text-gray-700 break-words">{{ $record['punch_out'] }}</div>
                                </div>

                                <!-- Punch Out Note -->
                                <div class="flex-1 min-w-0">
                                    @if($record['punch_out_note'])
                                        <div class="text-xs text-gray-700 break-words">{{ $record['punch_out_note'] }}</div>
                                    @else
                                        <div class="text-xs text-gray-700 break-words">&nbsp;</div>
                                    @endif
                                </div>

                                <!-- Duration -->
                                <div class="flex-shrink-0" style="width: 100px;">
                                    <div class="text-xs text-gray-700 text-center break-words">{{ number_format($record['duration'], 2) }}</div>
                                </div>

                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 100px;">
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button" class="w-8 h-8 rounded-full border border-red-200 bg-red-50 flex items-center justify-center text-red-500 hover:bg-red-100 hover:border-red-300 transition-all text-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button type="button" class="w-8 h-8 rounded-full border border-blue-200 bg-blue-50 flex items-center justify-center text-blue-500 hover:bg-blue-100 hover:border-blue-300 transition-all text-sm">
                                            ✏️
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
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

