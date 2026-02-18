@extends('layouts.app')

@section('title', 'Time - Attendance - My Records')

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

        <!-- My Attendance Records Section -->
        <section class="hr-card p-6 mb-3 border-t-0 rounded-t-none">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-alt" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">My Attendance Records</span>
                </h2>
            </div>

            <!-- Date Filter Section -->
            <form method="GET" action="{{ route('time.attendance.my-records') }}" class="rounded-lg p-4 border mb-4" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="w-full">
                        <x-date-picker 
                            name="from_date" 
                            value="{{ $fromDate }}"
                            label="From Date"
                            required="true"
                        />
                    </div>
                    <div class="w-full">
                        <x-date-picker 
                            name="to_date" 
                            value="{{ $toDate }}"
                            label="To Date"
                            required="true"
                        />
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="hr-btn-primary">
                            Search
                        </button>
                        <button type="button" onclick="resetFilters()" class="hr-btn-secondary">
                            Reset
                        </button>
                    </div>
                </div>
            </form>

            <!-- Attendance Records Table + Summary -->
            <section class="hr-card mt-6">
                <!-- Records Count + Total Duration -->
                <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b" style="border-color: var(--border-default);">
                    <x-records-found :count="count($groupedRecords)" />
                    <div class="text-sm font-medium" style="color: var(--text-primary);">
                        Total Duration (Hours): 
                        <span style="color: var(--text-primary);">{{ number_format($totalDuration, 2) }}</span>
                    </div>
                </div>

                <!-- Daily Records -->
                @if(count($groupedRecords) > 0)
                    @foreach($groupedRecords as $dateGroup)
                        <!-- Date Header -->
                        <div class="px-4 py-2 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-semibold" style="color: var(--text-primary);">
                                    {{ \Carbon\Carbon::parse($dateGroup['date'])->format('d M Y') }} 
                                    <span class="text-xs font-normal" style="color: var(--text-muted);">
                                        ({{ \Carbon\Carbon::parse($dateGroup['date'])->format('l') }})
                                    </span>
                                </div>
                                <div class="text-xs font-medium" style="color: var(--text-primary);">
                                    Total: {{ number_format($dateGroup['total_duration'], 2) }} hrs
                                </div>
                            </div>
                        </div>

                        <!-- Table Header -->
                        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Punch In</div>
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

                        <!-- Table Rows for this date -->
                        <div class="border border-t-0 rounded-b-lg mb-4" style="border-color: var(--border-default);">
                            @foreach($dateGroup['records'] as $index => $record)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <!-- Punch In -->
                        <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record->punch_in ?? '—' }}</div>
                        </div>

                        <!-- Punch In Note -->
                        <div class="flex-1" style="min-width: 0;">
                            @if($record->punch_in_note)
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record->punch_in_note }}</div>
                            @else
                                <div class="text-xs break-words" style="color: var(--text-muted);">—</div>
                            @endif
                        </div>

                        <!-- Punch Out -->
                        <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record->punch_out ?? '—' }}</div>
                        </div>

                        <!-- Punch Out Note -->
                        <div class="flex-1" style="min-width: 0;">
                            @if($record->punch_out_note)
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $record->punch_out_note }}</div>
                            @else
                                <div class="text-xs break-words" style="color: var(--text-muted);">—</div>
                            @endif
                        </div>

                        <!-- Duration -->
                        <div class="flex-shrink-0" style="width: 100px;">
                            <div class="text-xs text-center break-words" style="color: var(--text-primary);">{{ number_format($record->duration, 2) }}</div>
                        </div>

                        <!-- Actions -->
                        <div class="flex-shrink-0" style="width: 90px;">
                            <div class="flex items-center justify-center gap-2">
                                        <button 
                                            type="button" 
                                            class="hr-action-delete flex-shrink-0" 
                                            title="Delete"
                                            onclick="openAttendanceDeleteModal({{ $record->id }})"
                                        >
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="px-4 py-6 text-center">
                        <div class="text-xs text-[var(--text-muted)]">
                            No Records Found
                        </div>
                    </div>
                @endif
            </section>
        </section>

        <!-- Delete Attendance Record Confirm Modal -->
        <x-admin.modal 
            id="attendance-delete-modal" 
            title="Delete Attendance Record" 
            maxWidth="xs"
            backdropOnClick="closeAttendanceDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this attendance record?
                </p>
                <div class="flex justify-end gap-2">
                    <button 
                        type="button" 
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeAttendanceDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmAttendanceDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden form for delete -->
        <form id="attendance-delete-form" method="POST" action="#">
            @csrf
            @method('POST')
        </form>

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
                
                // Delete modal functions
                var currentDeleteRecordId = null;
                var attendanceDeleteUrlTemplate = '{{ route("time.attendance.records.delete", ":id") }}';

                window.openAttendanceDeleteModal = function(recordId) {
                    currentDeleteRecordId = recordId;
                    var modal = document.getElementById('attendance-delete-modal');
                    if (modal) {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                };

                window.closeAttendanceDeleteModal = function() {
                    var modal = document.getElementById('attendance-delete-modal');
                    if (modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                    currentDeleteRecordId = null;
                };

                window.confirmAttendanceDelete = function() {
                    if (!currentDeleteRecordId) {
                        closeAttendanceDeleteModal();
                        return;
                    }
                    var form = document.getElementById('attendance-delete-form');
                    if (!form) {
                        closeAttendanceDeleteModal();
                        return;
                    }
                    form.action = attendanceDeleteUrlTemplate.replace(':id', currentDeleteRecordId);
                    closeAttendanceDeleteModal();
                    form.submit();
                };

                // Reset filters
                window.resetFilters = function() {
                    var today = new Date();
                    var thirtyDaysAgo = new Date();
                    thirtyDaysAgo.setDate(today.getDate() - 30);
                    
                    var formatDate = function(date) {
                        var year = date.getFullYear();
                        var month = String(date.getMonth() + 1).padStart(2, '0');
                        var day = String(date.getDate()).padStart(2, '0');
                        return year + '-' + month + '-' + day;
                    };
                    
                    var fromDateInput = document.querySelector('input[name="from_date"]');
                    var toDateInput = document.querySelector('input[name="to_date"]');
                    
                    if (fromDateInput) {
                        fromDateInput.value = formatDate(thirtyDaysAgo);
                    }
                    if (toDateInput) {
                        toDateInput.value = formatDate(today);
                    }
                    
                    // Submit form to reload with reset dates
                    document.querySelector('form[action="{{ route("time.attendance.my-records") }}"]').submit();
                };
            });
        </script>
    </x-main-layout>
@endsection

