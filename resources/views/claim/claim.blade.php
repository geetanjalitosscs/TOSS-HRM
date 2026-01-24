@extends('layouts.app')

@section('title', 'Claim - Employee Claims')

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
                <div class="px-6 py-3 border-b-2 flex items-center flex-shrink-0 whitespace-nowrap" style="border-bottom-color: var(--color-hr-primary); background-color: var(--color-hr-primary-light);">
                    <span class="text-sm font-semibold" style="color: var(--color-hr-primary-dark);">Employee Claims</span>
                </div>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- Employee Claims Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-file-invoice-dollar" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Employee Claims</span>
                </h2>

                <!-- Filter Form -->
                <div class="rounded-lg p-3 mb-3 border" style="background-color: var(--color-hr-primary-light); border-color: var(--border-default);">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Reference Id</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Event Name</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);">
                                <option>-- Select --</option>
                                <option>Travel Allowance</option>
                                <option>Medical Reimbursement</option>
                                <option>Accommodation</option>
                                <option>Meal Allowance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Status</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);">
                                <option>-- Select --</option>
                                <option>Initiated</option>
                                <option>Submitted</option>
                                <option>Approved</option>
                                <option>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">From Date</label>
                            <input type="date" class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">To Date</label>
                            <input type="date" class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Include</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);">
                                <option>Current Employees Only</option>
                                <option>Past Employees Only</option>
                                <option>All Employees</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium rounded-lg transition-all whitespace-nowrap">
                                Reset
                            </button>
                            <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium rounded-lg transition-all whitespace-nowrap">
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Assign Claim Button -->
                <div class="mb-3">
                    <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold rounded-lg transition-all flex items-center gap-1 shadow-md">
                        <i class="fas fa-plus"></i> Assign Claim
                    </button>
                </div>

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
                                    <button class="px-2 py-1 text-xs font-medium border rounded-lg transition-all" style="color: var(--color-hr-primary-dark); border-color: var(--border-strong); background-color: transparent;" onmouseover="this.style.backgroundColor='var(--color-hr-primary-light)'" onmouseout="this.style.backgroundColor='transparent'">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </x-main-layout>
@endsection

