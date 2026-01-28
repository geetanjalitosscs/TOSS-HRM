@extends('layouts.app')

@section('title', 'Claim - Configuration - Edit Event')

@section('body')
    <x-main-layout title="Claim">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible flex-nowrap" style="border-color: var(--border-default);">
                <div class="relative group" onclick="toggleDropdown(event)" style="overflow: visible;">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center justify-between gap-2" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <span class="text-sm font-medium" style="color: var(--text-primary);">Configuration</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
                    </div>
                    <div class="hr-dropdown-menu absolute top-full left-0 mt-0 w-48" style="z-index: 9999; display: none; background-color: var(--bg-card); border: 1px solid var(--border-default); border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding: 0.5rem 0;">
                        <a href="{{ route('claim.configuration.events') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary); background-color: var(--bg-hover);">
                            Events
                        </a>
                        <a href="{{ route('claim.configuration.expenses-types') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                            Expenses Types
                        </a>
                    </div>
                </div>
                <a href="{{ route('claim.submit') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Submit Claim</span>
                </a>
                <a href="{{ route('claim.my-claims') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">My Claims</span>
                </a>
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- Edit Event Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-alt" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Edit Event</span>
                </h2>

                <form id="editEventForm" class="space-y-6" novalidate>
                    <!-- Event Name -->
                    <div>
                        <label for="eventName" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Event Name<span style="color: #dc3545;">*</span>
                        </label>
                        <input
                            type="text"
                            id="eventName"
                            class="hr-input w-1/2 px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                            style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                            value="{{ $event->name ?? '' }}"
                        >
                        <p id="eventNameError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="eventDescription" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Description</label>
                        <textarea
                            id="eventDescription"
                            rows="5"
                            class="hr-input w-1/2 px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] resize-y"
                            style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                        >{{ $event->description ?? '' }}</textarea>
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center gap-3">
                        <x-admin.toggle-switch
                            id="eventActive"
                            :checked="($event->status ?? 'Active') === 'Active'"
                        />
                        <label for="eventActive" class="text-xs font-medium cursor-pointer" style="color: var(--text-primary);">Active</label>
                    </div>

                    <div class="text-xs font-medium" style="color: var(--text-muted);">* Required</div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a
                            href="{{ route('claim.configuration.events') }}"
                            class="hr-btn-secondary px-6 py-2 text-xs font-medium rounded-lg transition-all whitespace-nowrap"
                        >
                            Cancel
                        </a>
                        <button
                            type="button"
                            id="eventUpdateBtn"
                            class="hr-btn-primary px-6 py-2 text-xs font-medium rounded-lg transition-all whitespace-nowrap"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <script>
            (function () {
                const eventNameEl = document.getElementById('eventName');
                const eventNameErr = document.getElementById('eventNameError');
                const updateBtn = document.getElementById('eventUpdateBtn');

                function setInvalid(inputEl, errEl, invalid) {
                    if (invalid) {
                        inputEl.style.borderColor = '#dc3545';
                        errEl.classList.remove('hidden');
                        return;
                    }
                    inputEl.style.borderColor = 'var(--border-strong)';
                    errEl.classList.add('hidden');
                }

                function validate() {
                    const eventNameInvalid = !eventNameEl.value.trim();
                    setInvalid(eventNameEl, eventNameErr, eventNameInvalid);
                    return !eventNameInvalid;
                }

                updateBtn.addEventListener('click', validate);
                eventNameEl.addEventListener('blur', validate);
            })();
        </script>
    </x-main-layout>
@endsection


