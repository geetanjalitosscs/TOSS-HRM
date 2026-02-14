@extends('layouts.app')

@section('title', 'Time - Attendance - Punch In/Out')

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

        @if($hasOpenPunchIn || $hasCompletedEntryToday)
            <!-- Punch Out Form -->
            <section class="hr-card p-6 border-t-0 rounded-t-none">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-6" style="color: var(--text-primary);">
                    <i class="fas fa-clock" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Punch Out</span>
                </h2>
                
                @if($hasCompletedEntryToday)
                    <!-- Completed Entry Message -->
                    <div class="mb-4 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                        <div class="text-xs flex items-center" style="color: var(--text-primary);">
                            <i class="fas fa-info-circle mr-2" style="color: var(--color-hr-primary);"></i>
                            <span>You have already completed your attendance for today. You can punch in again tomorrow.</span>
                        </div>
                    </div>
                    
                    @php
                        $punchInTime = \Carbon\Carbon::parse($completedEntry->punch_in ?? $completedEntry->punch_in_at)->format('h:i A');
                        $punchInDate = \Carbon\Carbon::parse($completedEntry->punch_in ?? $completedEntry->punch_in_at)->format('M d, Y');
                        $punchOutTime = \Carbon\Carbon::parse($completedEntry->punch_out ?? $completedEntry->punch_out_at)->format('h:i A');
                        $punchOutDate = \Carbon\Carbon::parse($completedEntry->punch_out ?? $completedEntry->punch_out_at)->format('M d, Y');
                    @endphp
                    
                    <div class="mb-3 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                        <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">Punch In Details:</div>
                        <div class="text-xs" style="color: var(--text-primary);">
                            <strong>Date:</strong> {{ $punchInDate }} | <strong>Time:</strong> {{ $punchInTime }}
                        </div>
                    </div>
                    
                    <div class="mb-3 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                        <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">Punch Out Details:</div>
                        <div class="text-xs" style="color: var(--text-primary);">
                            <strong>Date:</strong> {{ $punchOutDate }} | <strong>Time:</strong> {{ $punchOutTime }}
                        </div>
                    </div>
                    
                    <div class="mb-4 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                        <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">Current Time:</div>
                        <div class="text-xs" style="color: var(--text-primary);">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($currentDate)->format('M d, Y') }} | <strong>Time:</strong> {{ $currentTime }}
                        </div>
                    </div>
                    
                    <!-- Disabled Form -->
                    <form id="punchOutForm" method="POST" action="{{ route('time.attendance.punch-out') }}" class="space-y-5" style="opacity: 0.6; pointer-events: none;">
                        @csrf
                        
                        <!-- Note Field -->
                        <div>
                            <label for="punchOutNote" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Note
                            </label>
                            <textarea 
                                id="punchOutNote" 
                                name="note" 
                                rows="4"
                                placeholder="Type here"
                                class="hr-input w-full px-3 py-2.5 text-sm rounded-lg resize-y"
                                disabled
                            ></textarea>
                        </div>

                        <!-- Footer with Submit button -->
                        <div class="flex items-center justify-end pt-2">
                            <button type="button" class="hr-btn-secondary" disabled>
                                Out (Already Completed)
                            </button>
                        </div>
                    </form>
                @else
                    @php
                        $punchInTime = \Carbon\Carbon::parse($openPunchIn->punch_in ?? $openPunchIn->punch_in_at)->format('h:i A');
                        $punchInDate = \Carbon\Carbon::parse($openPunchIn->punch_in ?? $openPunchIn->punch_in_at)->format('M d, Y');
                    @endphp
                    
                    <div class="mb-3 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                        <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">Punch In Details:</div>
                        <div class="text-xs" style="color: var(--text-primary);">
                            <strong>Date:</strong> {{ $punchInDate }} | <strong>Time:</strong> {{ $punchInTime }}
                        </div>
                    </div>
                    
                    <div class="mb-4 p-3 rounded-lg" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                        <div class="text-xs font-medium mb-1" style="color: var(--text-primary);">Current Time:</div>
                        <div class="text-xs" style="color: var(--text-primary);">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($currentDate)->format('M d, Y') }} | <strong>Time:</strong> {{ $currentTime }}
                        </div>
                    </div>
                    
                    <form id="punchOutForm" method="POST" action="{{ route('time.attendance.punch-out') }}" class="space-y-5">
                        @csrf
                        
                        <!-- Note Field -->
                        <div>
                            <label for="punchOutNote" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Note
                            </label>
                            <textarea 
                                id="punchOutNote" 
                                name="note" 
                                rows="4"
                                placeholder="Type here"
                                class="hr-input w-full px-3 py-2.5 text-sm rounded-lg resize-y"
                            ></textarea>
                        </div>

                        <!-- Footer with Submit button -->
                        <div class="flex items-center justify-end pt-2">
                            <button type="submit" class="hr-btn-primary">
                                Out
                            </button>
                        </div>
                    </form>
                @endif
            </section>
        @else
            <!-- Punch In Form -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-6" style="color: var(--text-primary);">
                <i class="fas fa-clock" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Punch In</span>
            </h2>
            
                <form id="punchInForm" method="POST" action="{{ route('time.attendance.punch-in') }}" class="space-y-5">
                    @csrf
                    
                <!-- Date and Time Fields in Same Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date Field -->
                    <div>
                        <x-date-picker 
                            id="punchDate"
                            name="date" 
                            value="{{ $currentDate }}"
                            label="Date"
                            required="true"
                        />
                    </div>

                    <!-- Time Field -->
                    <div>
                        <label for="punchTime" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Time<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="punchTime" 
                                name="time" 
                                value="{{ $currentTime }}"
                                required
                                pattern="^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$"
                                placeholder="HH:MM AM/PM"
                                class="hr-input w-full px-3 py-2.5 text-sm rounded-lg pr-10"
                                style="border-color: var(--border-strong); background-color: var(--bg-input); color: var(--text-primary);"
                            >
                            <button 
                                type="button" 
                                id="timePickerBtn"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center transition-colors"
                                style="color: var(--color-hr-primary-soft);"
                                onmouseover="this.style.color='var(--color-hr-primary)';"
                                onmouseout="this.style.color='var(--color-hr-primary-soft)';"
                            >
                                <i class="fas fa-clock text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Note Field -->
                <div>
                    <label for="punchNote" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Note
                    </label>
                    <textarea 
                        id="punchNote" 
                        name="note" 
                        rows="4"
                        placeholder="Type here"
                        class="hr-input w-full px-3 py-2.5 text-sm rounded-lg resize-y"
                    ></textarea>
                </div>

                <!-- Footer with Required indicator and Submit button -->
                <div class="flex items-center justify-between pt-2">
                    <div class="text-xs" style="color: var(--text-muted);">* Required</div>
                    <button type="submit" class="hr-btn-primary">
                        In
                    </button>
                </div>
            </form>
        </section>
        @endif

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
                
                // Time picker functionality for Punch In form
                const punchInForm = document.getElementById('punchInForm');
                if (punchInForm) {
                const dateInput = document.getElementById('punchDate');
                const timeInput = document.getElementById('punchTime');
                const timePickerBtn = document.getElementById('timePickerBtn');
                
                    if (timeInput && timePickerBtn) {
                // Create a hidden time input for native time picker
                const hiddenTimeInput = document.createElement('input');
                hiddenTimeInput.type = 'time';
                hiddenTimeInput.style.position = 'fixed';
                hiddenTimeInput.style.opacity = '0';
                hiddenTimeInput.style.pointerEvents = 'none';
                hiddenTimeInput.style.border = 'none';
                hiddenTimeInput.style.padding = '0';
                hiddenTimeInput.style.margin = '0';
                hiddenTimeInput.style.zIndex = '-1';
                const currentTheme = document.documentElement.getAttribute('data-theme');
                hiddenTimeInput.style.colorScheme = currentTheme === 'dark' ? 'dark' : 'light';
                const themeObserver = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                            const newTheme = document.documentElement.getAttribute('data-theme');
                            hiddenTimeInput.style.colorScheme = newTheme === 'dark' ? 'dark' : 'light';
                        }
                    });
                });
                themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
                document.body.appendChild(hiddenTimeInput);
                
                // Convert 12-hour to 24-hour format
                function convert12to24(time12h) {
                    if (!time12h) return '';
                    const [time, period] = time12h.split(' ');
                    if (!time || !period) return '';
                    const [hours, minutes] = time.split(':');
                    let hours24 = parseInt(hours);
                    if (period === 'PM' && hours24 !== 12) {
                        hours24 += 12;
                    } else if (period === 'AM' && hours24 === 12) {
                        hours24 = 0;
                    }
                    return String(hours24).padStart(2, '0') + ':' + minutes;
                }
                
                // Convert 24-hour to 12-hour format
                function convert24to12(time24h) {
                    if (!time24h) return '';
                    const [hours, minutes] = time24h.split(':');
                    let hours12 = parseInt(hours);
                    const period = hours12 >= 12 ? 'PM' : 'AM';
                    if (hours12 === 0) {
                        hours12 = 12;
                    } else if (hours12 > 12) {
                        hours12 -= 12;
                    }
                    return String(hours12).padStart(2, '0') + ':' + minutes + ' ' + period;
                }
                
                // Initialize hidden time input with current time
                const currentTime12h = '{{ $currentTime }}';
                if (currentTime12h) {
                    hiddenTimeInput.value = convert12to24(currentTime12h);
                }
                
                        // Time picker button click handler
                timePickerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const timeInputRect = timeInput.getBoundingClientRect();
                    hiddenTimeInput.style.position = 'fixed';
                    hiddenTimeInput.style.left = timeInputRect.left + 'px';
                    hiddenTimeInput.style.top = timeInputRect.top + 'px';
                    hiddenTimeInput.style.width = timeInputRect.width + 'px';
                    hiddenTimeInput.style.height = timeInputRect.height + 'px';
                    hiddenTimeInput.style.zIndex = '9999';
                    hiddenTimeInput.style.opacity = '0';
                    hiddenTimeInput.style.pointerEvents = 'auto';
                    
                    requestAnimationFrame(function() {
                        hiddenTimeInput.focus();
                        hiddenTimeInput.showPicker();
                        
                        setTimeout(function() {
                            hiddenTimeInput.style.pointerEvents = 'none';
                        }, 100);
                    });
                });
                
                // Update visible input when hidden time input changes
                hiddenTimeInput.addEventListener('change', function() {
                    timeInput.value = convert24to12(hiddenTimeInput.value);
                });
                
                // Validate time input format
                timeInput.addEventListener('blur', function() {
                    const timeValue = timeInput.value.trim();
                    const timePattern = /^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i;
                    if (timeValue && !timePattern.test(timeValue)) {
                        const fixed = timeValue.replace(/(\d{1,2}):(\d{2})\s*(am|pm)/i, function(match, h, m, p) {
                            const hour = parseInt(h);
                            const min = parseInt(m);
                            if (hour >= 1 && hour <= 12 && min >= 0 && min <= 59) {
                                return String(hour).padStart(2, '0') + ':' + String(min).padStart(2, '0') + ' ' + p.toUpperCase();
                            }
                            return match;
                        });
                        if (timePattern.test(fixed)) {
                            timeInput.value = fixed;
                        }
                    }
                });
                
                        // Form validation
                        punchInForm.addEventListener('submit', function(e) {
                            const timeValue = timeInput.value.trim();
                            const timePattern = /^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i;
                            
                            if (!timePattern.test(timeValue)) {
                                e.preventDefault();
                                alert('Please enter a valid time in HH:MM AM/PM format (e.g., 07:32 AM)');
                                timeInput.focus();
                                return false;
                            }
                            
                            if (!dateInput.value) {
                    e.preventDefault();
                                alert('Please select a date');
                                dateInput.focus();
                                return false;
                            }
                    });
                    }
                }
            });
        </script>
    </x-main-layout>
@endsection
