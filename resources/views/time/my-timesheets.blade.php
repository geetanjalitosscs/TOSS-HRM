@extends('layouts.app')

@section('title', 'Time - My Timesheets')

@section('body')
    <x-main-layout title="Time">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible" style="border-color: var(--border-default);">
                @php
                    $timesheetsItems = [
                        [
                            'url' => route('time.my-timesheets'),
                            'label' => 'My Worksheets',
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
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold' : 'font-medium' }}" style="color: {{ $timesheetsHasActive ? 'var(--color-hr-primary-dark)' : 'var(--text-primary)' }};">Worksheets</span>
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

        <!-- My Timesheet Card -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            @if(session('status'))
                <div class="mb-4 p-3 rounded-lg" style="background-color: #dcfce7; color: #166534; border: 1px solid #86efac;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif
            
            <!-- Header Row -->
            <div class="flex items-center justify-between gap-6 mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-clock" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">My Worksheet</span>
            </div>

            <!-- Timesheet Grid -->
            <div class="overflow-x-auto">
                <div class="min-w-max rounded-xl border border-[var(--border-default)] bg-[var(--bg-card)]">
                    <!-- Header -->
                    <div class="grid grid-cols-3 text-center">
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Date
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-left">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Work Description
                            </div>
                        </div>
                        <div class="px-4 py-3 border-b border-[var(--border-default)] text-center">
                            <div class="text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
                                Actions
                            </div>
                        </div>
                    </div>

                    <!-- Entries Rows -->
                    @if(count($groupedEntries) > 0)
                        @foreach($groupedEntries as $entry)
                            <div class="grid grid-cols-3 border-t border-[var(--border-default)]">
                                <!-- Date -->
                                <div class="px-4 py-3">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ \Carbon\Carbon::parse($entry['work_date'])->format('d M Y') }}
                                    </div>
                                </div>
                                <!-- Work Description -->
                                <div class="px-4 py-3">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $entry['notes'] ?: '-' }}
                                    </div>
                                </div>
                                <!-- Actions -->
                                <div class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button 
                                            type="button" 
                                            class="hr-action-edit flex-shrink-0" 
                                            title="Edit"
                                            onclick="openEditEntryModal({{ $entry['id'] }}, '{{ \Carbon\Carbon::parse($entry['work_date'])->format('Y-m-d') }}', {{ json_encode($entry['notes']) }})"
                                        >
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty State Row -->
                        <div class="border-t border-[var(--border-default)]">
                            <div class="px-4 py-6 text-xs text-[var(--text-muted)] text-center">
                                No Records Found
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Edit Entry Modal -->
        <x-admin.modal
            id="edit-entry-modal"
            title="Edit Work Entry"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeEditEntryModal()"
        >
            <form id="edit-entry-form" method="POST">
                @csrf
                <input type="hidden" name="work_date" id="edit-work-date">
                <input type="hidden" name="hours" value="0">
                <input type="hidden" name="project_id" value="">
                <input type="hidden" name="activity_name" value="">
                
                <div class="space-y-4">
                    <!-- Date (Read-only) -->
                    <div>
                        <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="edit-date-display"
                            class="hr-input w-full"
                            readonly
                            style="background-color: var(--bg-hover); cursor: not-allowed;"
                        >
                    </div>

                    <!-- Work Description -->
                    <div>
                        <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                            Work Description <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="notes" 
                            id="edit-notes"
                            rows="4"
                            class="hr-input w-full"
                            placeholder="Describe what work you did..."
                            style="background-color: var(--bg-input); color: var(--text-primary); border: 1px solid var(--border-default);"
                            required
                        ></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditEntryModal()" class="hr-btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <script>
            // Edit Entry Modal Functions
            window.openEditEntryModal = function(entryId, workDate, notes) {
                const modal = document.getElementById('edit-entry-modal');
                const form = document.getElementById('edit-entry-form');
                const dateDisplay = document.getElementById('edit-date-display');
                const dateInput = document.getElementById('edit-work-date');
                const notesInput = document.getElementById('edit-notes');
                
                if (!modal || !form || !dateDisplay || !dateInput || !notesInput) {
                    console.error('Modal elements not found');
                    return;
                }
                
                // Set form action
                form.action = '{{ route("time.timesheets.entries.update", ":id") }}'.replace(':id', entryId);
                
                // Set date (format for display)
                const date = new Date(workDate);
                dateDisplay.value = date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                dateInput.value = workDate;
                
                // Set notes - handle JSON encoded string
                notesInput.value = (typeof notes === 'string' ? notes : (notes || ''));
                
                // Show modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Focus on textarea after a short delay to ensure modal is visible
                setTimeout(() => {
                    notesInput.focus();
                    notesInput.select();
                }, 100);
            };
            
            window.closeEditEntryModal = function() {
                const modal = document.getElementById('edit-entry-modal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            };
            
            // Handle form submission
            document.getElementById('edit-entry-form')?.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data) {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'An error occurred');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the entry');
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
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

