@extends('layouts.app')

@section('title', 'Claim - Assign Claim')

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
                        <a href="{{ route('claim.configuration.events') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
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
                <div class="px-6 py-3 border-b-2 flex items-center flex-shrink-0 whitespace-nowrap" style="border-bottom-color: var(--color-hr-primary); background-color: var(--color-hr-primary-light);">
                    <span class="text-sm font-semibold" style="color: var(--color-hr-primary-dark);">Assign Claim</span>
                </div>
            </div>
        </div>

        <!-- Assign Claim Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-user-check" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Assign Claim</span>
                </h2>

                <form id="assignClaimForm" method="POST" action="{{ route('claim.assign.store') }}" class="space-y-6" novalidate>
                    @csrf
                    <!-- Employee Name -->
                    <div>
                        <label for="assignEmployeeName" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Employee Name<span style="color: #dc3545;">*</span>
                        </label>
                        <div class="relative">
                            <select
                                id="assignEmployeeName"
                                name="employee_id"
                                class="hr-select w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                                style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                required
                            >
                                <option value="">-- Select --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p id="assignEmployeeNameError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event -->
                        <div>
                            <label for="assignEvent" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Event<span style="color: #dc3545;">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="assignEvent"
                                    name="event"
                                    class="hr-select w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                                    style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                    required
                                >
                                    <option value="">-- Select --</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}">{{ $event }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p id="assignEventError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="assignCurrency" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Currency<span style="color: #dc3545;">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="assignCurrency"
                                    name="currency"
                                    class="hr-select w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                                    style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                    required
                                >
                                    <option value="">-- Select --</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency }}">{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p id="assignCurrencyError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                        </div>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="assignPrice" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Price<span style="color: #dc3545;">*</span>
                        </label>
                        <input
                            type="number"
                            id="assignPrice"
                            name="price"
                            step="1"
                            min="0"
                            class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                            style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                            placeholder="0"
                            required
                            onkeydown="return event.key !== '.' && event.key !== ',' && (event.key === 'Backspace' || event.key === 'Delete' || event.key === 'Tab' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || /[0-9]/.test(event.key));"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        >
                        <p id="assignPriceError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="assignRemarks" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Remarks</label>
                        <textarea
                            id="assignRemarks"
                            name="remarks"
                            rows="5"
                            class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] resize-y"
                            style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                        ></textarea>
                    </div>

                    <div class="text-xs font-medium" style="color: var(--text-muted);">* Required</div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a
                            href="{{ route('claim') }}"
                            class="hr-btn-secondary px-6 py-2 text-xs font-medium rounded-lg transition-all whitespace-nowrap"
                        >
                            Cancel
                        </a>
                        <button
                            type="submit"
                            id="assignCreateBtn"
                            class="hr-btn-primary px-6 py-2 text-xs font-medium rounded-lg transition-all whitespace-nowrap"
                        >
                            Create
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <script>
            (function () {
                const employeeNameEl = document.getElementById('assignEmployeeName');
                const eventEl = document.getElementById('assignEvent');
                const currencyEl = document.getElementById('assignCurrency');
                const priceEl = document.getElementById('assignPrice');
                const employeeNameErr = document.getElementById('assignEmployeeNameError');
                const eventErr = document.getElementById('assignEventError');
                const currencyErr = document.getElementById('assignCurrencyError');
                const priceErr = document.getElementById('assignPriceError');
                const createBtn = document.getElementById('assignCreateBtn');

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
                    const employeeNameInvalid = !employeeNameEl.value;
                    const eventInvalid = !eventEl.value;
                    const currencyInvalid = !currencyEl.value;
                    const priceInvalid = !priceEl.value || parseFloat(priceEl.value) < 0;
                    setInvalid(employeeNameEl, employeeNameErr, employeeNameInvalid);
                    setInvalid(eventEl, eventErr, eventInvalid);
                    setInvalid(currencyEl, currencyErr, currencyInvalid);
                    setInvalid(priceEl, priceErr, priceInvalid);
                    return !(employeeNameInvalid || eventInvalid || currencyInvalid || priceInvalid);
                }

                createBtn.addEventListener('click', function(e) {
                    if (!validate()) {
                        e.preventDefault();
                    }
                });
                employeeNameEl.addEventListener('change', validate);
                eventEl.addEventListener('change', validate);
                currencyEl.addEventListener('change', validate);
                priceEl.addEventListener('blur', validate);
            })();
        </script>

        <style>
            /* Hide native select dropdown arrows (Windows/Edge legacy) for this page only */
            #assignEvent::-ms-expand,
            #assignCurrency::-ms-expand {
                display: none;
            }
        </style>
    </x-main-layout>
@endsection
