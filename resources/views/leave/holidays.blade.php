@extends('layouts.app')

@section('title', 'Leave - Holidays')

@section('body')
    <x-main-layout title="Leave / Configure">
        <x-leave.tabs activeTab="holidays" />
        
        <!-- Holidays Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-calendar-check" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Holidays</span>
            </h2>
            
            <x-admin.search-panel title="" :collapsed="false">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">From</label>
                        <div class="relative">
                            <input type="text" value="2026-01-01" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all pr-10" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <i class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">To</label>
                        <div class="relative">
                            <input type="text" value="2026-31-12" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all pr-10" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <i class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" style="color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <x-admin.action-buttons />
                </div>
            </x-admin.search-panel>
        </section>
        
        <!-- Add Button -->
        <div class="mb-6">
            <x-admin.add-button label="+ Add" />
        </div>
        
        <!-- Holidays Table Section -->
        <section class="hr-card p-6">
            @if(isset($holidays) && count($holidays) > 0)
            <!-- Records Count -->
            <div class="mb-4 text-xs font-medium" style="color: var(--text-muted);">
                ({{ count($holidays) }}) Records Found
            </div>
            @else
            <!-- Records Count -->
            <div class="mb-4 text-xs font-medium" style="color: var(--text-muted);">
                (16) Records Found
            </div>
            @endif
            
            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Name</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Date</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Full Day/ Half Day</span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Repeats Annually</span>
                </div>
                <div class="flex-shrink-0" style="width: 90px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>
            
            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @php
                    $holidays = [
                        ['name' => "New Year's Day", 'date' => '2026-01-01', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => "St. Patrick's Day (Canada)", 'date' => '2026-16-03', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => "St. George's Day (Canada)", 'date' => '2026-20-04', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Victoria Day (Canada)', 'date' => '2026-18-05', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'National Aboriginal Day (Canada)', 'date' => '2026-21-06', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'June Day (Canada)', 'date' => '2026-22-06', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'The National Holiday of Quebec (Canada)', 'date' => '2026-24-06', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Canada Day (Canada)', 'date' => '2026-01-07', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Independence Day (US)', 'date' => '2026-04-07', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Nunavut Day (Canada)', 'date' => '2026-09-07', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => "Orangeman's Day (Canada)", 'date' => '2026-13-07', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Remembrance Day (Canada)', 'date' => '2026-11-11', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Veterans Day (US)', 'date' => '2026-12-11', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Christmas Day', 'date' => '2026-25-12', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Boxing Day', 'date' => '2026-26-12', 'type' => 'Full Day', 'repeats' => 'Yes'],
                        ['name' => 'Boxing Day (Canada)', 'date' => '2026-28-12', 'type' => 'Full Day', 'repeats' => 'Yes']
                    ];
                @endphp
                @foreach($holidays as $holiday)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $holiday['name'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $holiday['date'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $holiday['type'] }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $holiday['repeats'] }}</div>
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
        </section>
    </x-main-layout>
@endsection
