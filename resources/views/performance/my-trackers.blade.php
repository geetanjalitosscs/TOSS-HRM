@extends('layouts.app')

@section('title', 'Performance - My Trackers')

@section('body')
    <x-main-layout title="Performance / My Trackers">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible flex-nowrap">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs'],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Configure</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
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
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Manage Reviews</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50 flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">My Trackers</span>
                </div>
                <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                </a>
            </div>
        </div>

        <!-- My Performance Trackers Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-chart-line text-purple-500"></i> <span class="mt-0.5">My Performance Trackers</span>
            </h2>

            @if(count($trackers) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($trackers)" />

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
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
                <div class="flex-shrink-0" style="width: 70px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($trackers as $tracker)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker->tracker }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->added_date }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->modified_date }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 70px;">
                        <div class="flex items-center justify-center">
                            <button class="hr-btn-primary px-2 py-1 text-xs font-medium">
                                View
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

