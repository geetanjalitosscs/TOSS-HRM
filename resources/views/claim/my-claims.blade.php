@extends('layouts.app')

@section('title', 'Claim - My Claims')

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
                <div class="px-6 py-3 border-b-2 flex items-center flex-shrink-0 whitespace-nowrap" style="border-bottom-color: var(--color-hr-primary); background-color: var(--color-hr-primary-light);">
                    <span class="text-sm font-semibold" style="color: var(--color-hr-primary-dark);">My Claims</span>
                </div>
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- My Claims Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-file-invoice-dollar" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">My Claims</span>
                </h2>

                <!-- Filter Form -->
                <div class="rounded-lg p-4 mb-4 border" style="background-color: var(--color-hr-primary-light); border-color: var(--border-default);">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Reference Id</label>
                            <input type="text" class="hr-input w-full px-3 py-2 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Event Name</label>
                            <div class="relative">
                                <select
                                    class="hr-select appearance-none w-full px-3 py-2 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] pr-12"
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
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Status</label>
                            <div class="relative">
                                <select
                                    class="hr-select appearance-none w-full px-3 py-2 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] pr-12"
                                    style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                >
                                    <option value="">-- Select --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute top-1/2 -translate-y-1/2 right-2 w-9 h-9 rounded-lg flex items-center justify-center" style="background-color: var(--bg-hover);color: var(--text-muted);">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div>
                            <x-date-picker 
                                name="from_date"
                                label="From Date"
                                class="text-xs"
                            />
                        </div>
                        <div>
                            <x-date-picker 
                                name="to_date"
                                label="To Date"
                                class="text-xs"
                            />
                        </div>
                        <div></div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button class="hr-btn-secondary px-8 py-2 text-xs font-medium rounded-full transition-all whitespace-nowrap">
                            Reset
                        </button>
                        <button class="hr-btn-primary px-8 py-2 text-xs font-medium rounded-full transition-all whitespace-nowrap">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Submit Claim Button -->
                <div class="mb-4">
                    <a href="{{ route('claim.submit') }}" class="hr-btn-primary inline-flex items-center gap-2 px-8 py-2 text-xs font-bold rounded-full transition-all shadow-md">
                        <span class="text-sm leading-none">+</span>
                        <span>Submit Claim</span>
                    </a>
                </div>

                <div class="border-t mb-4" style="border-color: var(--border-default);"></div>

                <!-- Records Count -->
                <x-records-found :count="count($claims)" />

                <!-- Table Wrapper -->
                <div class="hr-table-wrapper">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Reference Id
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Employee Name
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Event Name
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Description</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Currency
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Submitted Date
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Status
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Amount
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                        </div>
                    </div>

                    <!-- Claims List -->
                    <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                        @foreach($claims as $claim)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <!-- Reference Id -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $claim['reference_id'] }}</div>
                                </div>
                                
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['employee_name'] }}</div>
                                </div>
                                
                                <!-- Event Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['event_name'] }}</div>
                                </div>
                                
                                <!-- Description -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['description'] ?: '-' }}</div>
                                </div>
                                
                                <!-- Currency -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['currency'] }}</div>
                                </div>
                                
                                <!-- Submitted Date -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['submitted_date'] }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['status'] }}</div>
                                </div>
                                
                                <!-- Amount -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim['amount'] }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 100px;">
                                    <div class="flex items-center justify-center">
                                        <button class="px-3 py-1 text-xs font-medium border rounded-lg transition-all" style="color: var(--color-hr-primary-dark); border-color: var(--border-strong); background-color: transparent;" onmouseover="this.style.backgroundColor='var(--color-hr-primary-light)'" onmouseout="this.style.backgroundColor='transparent'">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <style>
                    /* Hide native select dropdown arrows (Windows/Edge legacy) for this page only */
                    select::-ms-expand { display: none; }
                </style>
            </section>
        </div>
    </x-main-layout>
@endsection

