@extends('layouts.app')

@section('title', 'Performance - Trackers')

@section('body')
    <x-main-layout title="Performance / Configure">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible flex-nowrap" style="border-color: var(--border-default);">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs'],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers', 'active' => true]
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 cursor-pointer flex items-center gap-2 flex-shrink-0 whitespace-nowrap" style="border-color: var(--color-hr-primary); background-color: var(--bg-hover);">
                        <span class="text-sm font-semibold" style="color: var(--color-hr-primary-dark);">Configure</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance'), 'label' => 'Manage Reviews'],
                        ['url' => route('performance.my-reviews'), 'label' => 'My Reviews'],
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)';">
                        <span class="text-sm font-medium">Manage Reviews</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)';">
                    <span class="text-sm font-medium">My Trackers</span>
                </a>
                <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)';">
                    <span class="text-sm font-medium">Employee Trackers</span>
                </a>
            </div>
        </div>

        <!-- Performance Trackers Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-bullseye" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Performance Trackers</span>
            </h2>
            
            <x-admin.search-panel title="" :collapsed="false">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                        <input type="text" class="hr-input w-full px-2 py-1.5 text-xs rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]" style="border: 1px solid var(--border-default); background-color: var(--bg-card); color: var(--text-primary);" placeholder="Type for hints...">
                    </div>
                    <x-admin.action-buttons />
                </div>
            </x-admin.search-panel>
        </section>

        <!-- Add Button -->
        <div class="mb-6">
            <x-admin.add-button label="+ Add" />
        </div>

        <!-- Trackers Table Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-list-alt" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Trackers List</span>
            </h2>
            
            @if(count($trackers) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($trackers)" />

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Tracker</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Added Date</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Modified Date</span>
                        <div class="flex items-center gap-0.5">
                            <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                            <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0" style="width: 90px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($trackers as $tracker)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker['employee'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker['tracker'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker['added_date'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker['modified_date'] ?: '' }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="flex items-center justify-center gap-2">
                            <button class="hr-action-edit flex-shrink-0" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="hr-action-delete flex-shrink-0" title="Delete">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- No Records Found -->
            <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                No Records Found
            </div>
            @endif
        </section>
    </x-main-layout>
@endsection

