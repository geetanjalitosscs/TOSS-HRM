@extends('layouts.app')

@section('title', 'Claim - Configuration - Add Event')

@section('body')
    <x-main-layout title="Claim">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-y-visible" style="border-color: var(--border-default);">
                <div class="relative group" onclick="toggleDropdown(event)" style="overflow: visible;">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center justify-between gap-2" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <span class="text-sm font-medium" style="color: var(--text-primary);">Configuration</span>
                        <span class="flex-shrink-0" style="color: #a78bfa;">▼</span>
                    </div>
                    <div class="hr-dropdown-menu absolute top-full left-0 mt-0 w-48" style="z-index: 9999; display: none; background-color: var(--bg-card); border: 1px solid var(--border-default); border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding: 0.5rem 0;">
                        <a href="{{ route('claim.configuration.events') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                            Events
                        </a>
                        <a href="{{ route('claim.configuration.expenses-types') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                            Expenses Types
                        </a>
                    </div>
                </div>
                <a href="{{ route('claim.submit') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Submit Claim</span>
                </a>
                <a href="{{ route('claim.my-claims') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">My Claims</span>
                </a>
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- Add Event Section -->
        <div>
            <div class="rounded-b-lg shadow-sm border border-t-0 p-6" style="background-color: var(--bg-card); border-color: var(--border-default);">
                <h2 class="text-sm font-bold mb-5" style="color: var(--text-primary);">Add Event</h2>

                <form id="addEventForm" class="space-y-6" novalidate>
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
                            placeholder=""
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
                        ></textarea>
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center gap-3">
                        <label for="eventActive" class="block text-xs font-medium" style="color: var(--text-primary);">Active</label>
                        <div class="relative cursor-pointer" onclick="document.getElementById('eventActive').click()">
                            <input type="checkbox" class="sr-only" id="eventActive" checked onchange="toggleActive(this, 'eventActiveBg', 'eventActiveCircle')">
                            <div class="w-11 h-6 rounded-full transition-colors duration-200 flex items-center" id="eventActiveBg" style="background-color: var(--color-hr-primary);">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200" id="eventActiveCircle" style="margin-left: 24px;"></div>
                            </div>
                        </div>
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
                            id="eventSaveBtn"
                            class="hr-btn-primary px-6 py-2 text-xs font-medium rounded-lg transition-all whitespace-nowrap"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            (function () {
                const eventNameEl = document.getElementById('eventName');
                const eventNameErr = document.getElementById('eventNameError');
                const saveBtn = document.getElementById('eventSaveBtn');

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

                saveBtn.addEventListener('click', validate);
                eventNameEl.addEventListener('blur', validate);
            })();

            function toggleActive(checkbox, bgId, circleId) {
                const bg = document.getElementById(bgId);
                const circle = document.getElementById(circleId);
                
                if (checkbox.checked) {
                    bg.style.backgroundColor = 'var(--color-hr-primary)';
                    circle.style.marginLeft = '24px';
                } else {
                    bg.style.backgroundColor = 'var(--bg-hover)';
                    circle.style.marginLeft = '2px';
                }
            }
        </script>
    </x-main-layout>
@endsection
