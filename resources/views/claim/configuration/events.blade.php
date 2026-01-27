@extends('layouts.app')

@section('title', 'Claim - Configuration - Events')

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
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- Events Configuration Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-alt" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Events</span>
                </h2>

                <!-- Search/Filter Section -->
                <div class="rounded-lg p-3 mb-3 border" style="background-color: var(--color-hr-primary-light); border-color: var(--border-default);">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Event Name</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Status</label>
                            <div class="relative">
                                <select class="hr-select appearance-none w-full px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] pr-12" style="-webkit-appearance:none;-moz-appearance:none;appearance:none;background-image:none;border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);">
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
                    <div class="flex justify-end gap-2">
                        <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium rounded-lg transition-all whitespace-nowrap">
                            Reset
                        </button>
                        <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium rounded-lg transition-all whitespace-nowrap">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Add Button Section -->
                <div class="rounded-lg p-3 mb-3 border" style="background-color: var(--color-hr-primary-light); border-color: var(--border-default);">
                    <a href="{{ route('claim.configuration.events.add') }}" class="hr-btn-primary inline-flex items-center gap-1 px-4 py-1.5 text-xs font-bold rounded-lg transition-all shadow-md">
                        <span class="text-sm">+</span> Add
                    </a>
                </div>

                <!-- Records Count -->
                <x-records-found :count="count($events)" />

                <!-- Table Wrapper -->
                <div class="hr-table-wrapper">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" class="rounded border" style="border-color: var(--border-strong); color: var(--color-hr-primary); width: 0.875rem; height: 0.875rem;">
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
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Status
                                <div class="flex items-center gap-0.5">
                                    <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                    <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 70px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                        </div>
                    </div>

                    <!-- Events List -->
                    <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                        @foreach($events as $event)
                        <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                            <!-- Checkbox -->
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" class="rounded border" style="border-color: var(--border-strong); color: var(--color-hr-primary); width: 0.875rem; height: 0.875rem;">
                            </div>
                            
                            <!-- Event Name -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $event['event_name'] }}</div>
                            </div>
                            
                            <!-- Status -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $event['status'] }}</div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex-shrink-0" style="width: 70px;">
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        class="hr-action-delete flex-shrink-0" 
                                        title="Delete"
                                    >
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                    <button 
                                        class="hr-action-edit flex-shrink-0" 
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <style>
            /* Hide native select dropdown arrows (Windows/Edge legacy) for this page only */
            select::-ms-expand {
                display: none;
            }
        </style>
    </x-main-layout>
@endsection
