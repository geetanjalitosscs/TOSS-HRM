@extends('layouts.app')

@section('title', 'Performance - Manage Reviews')

@section('body')
    <x-main-layout title="Performance / Manage Reviews">
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
                        ['url' => route('performance'), 'label' => 'Manage Reviews', 'active' => true],
                        ['url' => route('performance.my-reviews'), 'label' => 'My Reviews'],
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50 cursor-pointer flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Manage Reviews</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                            <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-700">My Trackers</span>
                            </a>
                            <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                            </a>
                        </div>
                    </div>

                    <!-- Manage Performance Reviews Section -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                            <i class="fas fa-star text-purple-500"></i> <span class="mt-0.5">Manage Performance Reviews</span>
                        </h2>

                        <!-- Filter Form -->
                        <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Software Engineer</option>
                                        <option>QA Engineer</option>
                                        <option>HR Manager</option>
                                        <option>Business Analyst</option>
                                        <option>Project Manager</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Sub Unit</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Engineering</option>
                                        <option>Human Resources</option>
                                        <option>Quality Assurance</option>
                                        <option>Business Development</option>
                                        <option>Management</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Include</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>Current Employees Only</option>
                                        <option>Past Employees Only</option>
                                        <option>All Employees</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Review Status</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Pending</option>
                                        <option>In Progress</option>
                                        <option>Completed</option>
                                        <option>Cancelled</option>
                                        <option>Activated</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Reviewer</label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                </div>
                                <div>
                                    <x-date-picker 
                                        name="from_date"
                                        value="2026-01-01"
                                        label="From Date"
                                        class="text-xs"
                                    />
                                </div>
                                <div>
                                    <x-date-picker 
                                        name="to_date"
                                        value="2026-12-31"
                                        label="To Date"
                                        class="text-xs"
                                    />
                                </div>
                            </div>
                            <x-admin.action-buttons />
                        </div>

                        <!-- Add Button -->
                        <div class="mb-3">
                            <x-admin.add-button label="+ Add" />
                        </div>

                        @if(count($reviews) > 0)
                        <!-- Records Count -->
                        <x-records-found :count="count($reviews)" />
                        @endif

                        <!-- No Records Found Message -->
                        @if(count($reviews) == 0)
                        <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                            No Records Found
                        </div>
                        @endif

                        @if(count($reviews) > 0)
                        <!-- Table Header -->
                        <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
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
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Job Title</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Review Period</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Due Date</span>
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Reviewer</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Review Status</span>
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
                            @foreach($reviews as $review)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $review->employee }}</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->job_title }}</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->review_period }}</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->due_date }}</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->reviewer }}</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->review_status }}</div>
                                </div>
                                <div class="flex-shrink-0" style="width: 90px;">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="hr-action-view flex-shrink-0" title="View">
                                            <i class="fas fa-file-alt text-sm"></i>
                                        </button>
                                        <button class="hr-action-edit flex-shrink-0" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </section>
    </x-main-layout>
@endsection

