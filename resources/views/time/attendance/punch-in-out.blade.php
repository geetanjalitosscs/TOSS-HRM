@extends('layouts.app')

@section('title', 'Time - Attendance - Punch In/Out')

@section('body')
    <x-main-layout title="Time / Attendance / Punch In/Out">
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

        <!-- Punch In/Out Form -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-6" style="color: var(--text-primary);">
                <i class="fas fa-clock" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Punch In</span>
            </h2>
            
            <form id="punchInForm" class="space-y-5">
                <!-- Date and Time Fields in Same Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date Field -->
                    <div>
                        <label for="punchDate" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Date<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="date" 
                                id="punchDate" 
                                name="date" 
                                value="{{ $currentDate }}"
                                required
                                class="hr-input w-full px-3 py-2.5 text-sm rounded-lg pr-10"
                            >
                            <button 
                                type="button" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center text-purple-400 hover:text-purple-600 transition-colors"
                                onclick="document.getElementById('punchDate').showPicker()"
                            >
                                <i class="fas fa-calendar text-sm"></i>
                            </button>
                        </div>
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
                            >
                            <button 
                                type="button" 
                                id="timePickerBtn"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center text-purple-400 hover:text-purple-600 transition-colors"
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
                
                const form = document.getElementById('punchInForm');
                const dateInput = document.getElementById('punchDate');
                const timeInput = document.getElementById('punchTime');
                const timePickerBtn = document.getElementById('timePickerBtn');
                
                // Create a hidden time input for native time picker
                const hiddenTimeInput = document.createElement('input');
                hiddenTimeInput.type = 'time';
                hiddenTimeInput.style.display = 'none';
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
                timePickerBtn.addEventListener('click', function() {
                    hiddenTimeInput.showPicker();
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
                        // Try to fix common issues
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
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // TODO: Implement form submission logic
                    console.log('Punch In submitted:', {
                        date: dateInput.value,
                        time: timeInput.value,
                        note: document.getElementById('punchNote').value
                    });
                });
            });
        </script>
    </x-main-layout>
@endsection

