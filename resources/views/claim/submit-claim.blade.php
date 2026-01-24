@extends('layouts.app')

@section('title', 'Claim - Submit Claim')

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
                <div class="px-6 py-3 border-b-2 flex items-center flex-shrink-0 whitespace-nowrap" style="border-bottom-color: var(--color-hr-primary); background-color: var(--color-hr-primary-light);">
                    <span class="text-sm font-semibold" style="color: var(--color-hr-primary-dark);">Submit Claim</span>
                </div>
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

        <!-- Submit Claim Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-plus-circle" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Create Claim Request</span>
                </h2>

                <form id="claimSubmitForm" class="space-y-6" novalidate>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event -->
                        <div>
                            <label for="claimEvent" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Event<span style="color: #dc3545;">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="claimEvent"
                                    class="hr-select appearance-none w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] pr-12"
                                    style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                >
                                    <option value="">-- Select --</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}">{{ $event }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute top-1/2 -translate-y-1/2 right-2 w-9 h-9 rounded-lg flex items-center justify-center" style="background-color: var(--bg-hover);color: var(--text-muted);">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p id="claimEventError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="claimCurrency" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Currency<span style="color: #dc3545;">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="claimCurrency"
                                    class="hr-select appearance-none w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] pr-12"
                                    style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                >
                                    <option value="">-- Select --</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency }}">{{ $currency }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute top-1/2 -translate-y-1/2 right-2 w-9 h-9 rounded-lg flex items-center justify-center" style="background-color: var(--bg-hover);color: var(--text-muted);">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p id="claimCurrencyError" class="mt-1 text-xs hidden" style="color: #dc3545;">Required</p>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="claimRemarks" class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Remarks</label>
                        <textarea
                            id="claimRemarks"
                            rows="5"
                            class="hr-input w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
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
                            type="button"
                            id="claimCreateBtn"
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
                const eventEl = document.getElementById('claimEvent');
                const currencyEl = document.getElementById('claimCurrency');
                const eventErr = document.getElementById('claimEventError');
                const currencyErr = document.getElementById('claimCurrencyError');
                const createBtn = document.getElementById('claimCreateBtn');

                function setInvalid(selectEl, errEl, invalid) {
                    if (invalid) {
                        selectEl.style.borderColor = '#dc3545';
                        errEl.classList.remove('hidden');
                        return;
                    }
                    selectEl.style.borderColor = 'var(--border-strong)';
                    errEl.classList.add('hidden');
                }

                function validate() {
                    const eventInvalid = !eventEl.value;
                    const currencyInvalid = !currencyEl.value;
                    setInvalid(eventEl, eventErr, eventInvalid);
                    setInvalid(currencyEl, currencyErr, currencyInvalid);
                    return !(eventInvalid || currencyInvalid);
                }

                createBtn.addEventListener('click', validate);
                eventEl.addEventListener('change', validate);
                currencyEl.addEventListener('change', validate);
            })();
        </script>

        <style>
            /* Hide native select dropdown arrows (Windows/Edge legacy) for this page only */
            #claimEvent::-ms-expand,
            #claimCurrency::-ms-expand {
                display: none;
            }
        </style>
    </x-main-layout>
@endsection

