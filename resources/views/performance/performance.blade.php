@extends('layouts.app')

@section('title', 'Performance - Manage Reviews')

@section('body')
    <x-main-layout title="Performance">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible flex-nowrap">
                            <x-dropdown-menu 
                                :items="[
                                    ['url' => route('performance.kpis'), 'label' => 'KPIs'],
                                    ['url' => route('performance.trackers'), 'label' => 'Trackers']
                                ]"
                                position="left"
                                width="w-48">
                                <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                                    <span class="text-sm font-medium text-slate-700">Configure</span>
                                    <x-dropdown-arrow class="flex-shrink-0" />
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
                    <div class="px-6 py-3 border-b-2 border-[var(--color-primary)] bg-[var(--color-primary-light)] cursor-pointer flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-semibold text-[var(--color-primary-dark)]">Manage Reviews</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                            <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-700">My Trackers</span>
                            </a>
                            <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                            </a>
                        </div>
                    </div>

                    <!-- Performance Reviews Search Panel -->
                    <section class="hr-card p-6 mb-6">
                        <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                            <i class="fas fa-star" style="color: var(--color-hr-primary);"></i>
                            <span class="mt-0.5">Manage Performance Reviews</span>
                        </h2>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('performance') }}" id="reviews-search-form">
                            <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                        <input 
                                            type="text" 
                                            name="employee_name"
                                            class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white" 
                                            placeholder="Type for hints..."
                                            value="{{ request('employee_name') }}"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                        <select 
                                            name="job_title"
                                            class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white"
                                        >
                                            <option value="">-- Select --</option>
                                            @foreach($jobTitles ?? [] as $title)
                                                <option value="{{ $title }}" {{ request('job_title') === $title ? 'selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Review Status</label>
                                        <select 
                                            name="review_status"
                                            class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white"
                                        >
                                            <option value="">-- Select --</option>
                                            <option value="pending" {{ request('review_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ request('review_status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ request('review_status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ request('review_status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Reviewer</label>
                                        <input 
                                            type="text" 
                                            name="reviewer"
                                            class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white" 
                                            placeholder="Type for hints..."
                                            value="{{ request('reviewer') }}"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">From Date</label>
                                        <x-date-picker 
                                            name="from_date"
                                            value="{{ request('from_date') }}"
                                            placeholder="From"
                                            variant="default"
                                            class="w-full text-xs"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">To Date</label>
                                        <x-date-picker 
                                            name="to_date"
                                            value="{{ request('to_date') }}"
                                            placeholder="To"
                                            variant="default"
                                            class="w-full text-xs"
                                        />
                                    </div>
                                </div>
                                <x-admin.action-buttons resetType="button" searchType="submit" />
                            </div>
                        </form>
                    </section>

                    <!-- Performance Reviews Table Section -->
                    <section class="hr-card p-6" id="reviews-table-section">
                        <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                            <i class="fas fa-list-alt" style="color: var(--color-hr-primary);"></i>
                            <span class="mt-0.5">Reviews List</span>
                        </h2>

                        @if(session('status'))
                            <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10B981;">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        @if(isset($reviews) && count($reviews) > 0)
                        <!-- Records Count + Actions -->
                        <div class="flex items-center justify-between mb-2">
                            <x-records-found :count="count($reviews)" />
                            <div class="flex items-center gap-3">
                                <button
                                    id="reviews-delete-selected"
                                    type="button"
                                    class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                    onclick="openReviewBulkDeleteModal()"
                                >
                                    Delete Selected
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div id="reviews-table">
                            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                        <!-- Table Header -->
                                <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                                     style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                    <div class="flex-shrink-0" style="width: 24px;">
                                        <input type="checkbox"
                                               id="reviews-master-checkbox"
                                               class="rounded w-3.5 h-3.5"
                                               style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Employee
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Job Title
                                        </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Review Period
                            </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Due Date
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Reviewer
                            </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Review Status
                                </div>
                            </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                             style="color: var(--text-primary);">
                                            Overall Rating
                                </div>
                            </div>
                            <div class="flex-shrink-0" style="width: 120px;">
                                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight text-center"
                                             style="color: var(--text-primary);">
                                            Actions
                                        </div>
                            </div>
                        </div>

                        <!-- Table Rows -->
                                <div class="border border-t-0 rounded-b-lg"
                                     style="border-color: var(--border-default);">
                                    @forelse($reviews as $review)
                                        <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                             style="background-color: var(--bg-card); border-color: var(--border-default);"
                                             onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                             onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                            <div class="flex-shrink-0" style="width: 24px;">
                                                <input type="checkbox"
                                                       class="review-row-checkbox rounded w-3.5 h-3.5"
                                                       style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                                                       data-review-id="{{ $review->id }}">
                                            </div>
                                            <div class="flex-1" style="min-width: 0;"
                                                 data-review-id="{{ $review->id }}"
                                                 data-review-employee-id="{{ $review->employee_id }}"
                                                 data-review-cycle-id="{{ $review->cycle_id }}"
                                                 data-review-reviewer-id="{{ $review->reviewer_id ?? '' }}"
                                                 data-review-overall-rating="{{ $review->overall_rating ?? '' }}"
                                                 data-review-employee="{{ $review->employee }}"
                                                 data-review-job-title="{{ $review->job_title }}"
                                                 data-review-review-period="{{ $review->review_period }}"
                                                 data-review-due-date="{{ $review->due_date }}"
                                                 data-review-reviewer="{{ $review->reviewer }}"
                                                 data-review-status="{{ $review->review_status }}">
                                                <div class="text-xs font-medium break-words" style="color: var(--text-primary);">
                                                    {{ $review->employee }}
                                                </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                                    {{ $review->job_title }}
                                                </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                                    {{ $review->review_period }}
                                                </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                                    {{ $review->due_date }}
                                                </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                                    {{ $review->reviewer }}
                                                </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                                    @php
                                                        $statusLabelMap = [
                                                            'not_started' => 'Not Started',
                                                            'in_progress' => 'In Progress',
                                                            'completed' => 'Completed',
                                                            'approved' => 'Approved',
                                                            'cancelled' => 'Cancelled',
                                                        ];
                                                        $statusValue = strtolower($review->review_status ?? '');
                                                    @endphp
                                                    {{ $statusLabelMap[$statusValue] ?? ucfirst(str_replace('_', ' ', $statusValue)) }}
                                                </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">
                                                    @if($review->overall_rating !== null)
                                                        {{ number_format($review->overall_rating, 2) }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 140px;">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(strtolower($review->review_status) === 'completed')
                                            <button class="hr-action-edit flex-shrink-0" title="Approve Review"
                                                    onclick="event.preventDefault(); event.stopPropagation(); approveReview({{ $review->id }});">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        @endif
                                                    <button class="hr-action-delete flex-shrink-0" title="Delete"
                                                            onclick="event.preventDefault(); event.stopPropagation(); openReviewDeleteModalFromRow(this.closest('.hr-table-row'));">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                            No reviews found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- No Records Found -->
                        <div class="flex items-center justify-between mb-2">
                            <x-records-found :count="0" />
                        </div>

                        <!-- Empty table structure to match other pages -->
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                                 style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" disabled>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Employee
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Job Title
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Review Period
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Due Date
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Reviewer
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Review Status
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                         style="color: var(--text-primary);">
                                        Overall Rating
                                    </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 120px;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight text-center"
                                         style="color: var(--text-primary);">
                                        Actions
                                    </div>
                                </div>
                            </div>
                            <div class="border border-t-0 rounded-b-lg"
                                 style="border-color: var(--border-default);">
                                <div class="px-4 py-6 text-center text-xs" style="color: var(--text-muted);">
                                    No records found.
                                </div>
                            </div>
                        </div>
                        @endif
                    </section>

        <!-- Add Review Modal -->
        <x-admin.modal
            id="review-add-modal"
            title="Add Performance Review"
            icon="fas fa-star"
            maxWidth="md"
            backdropOnClick="closeReviewAddModal(true)"
        >
            <form method="POST" action="{{ route('performance.reviews.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="employee_id"
                        id="review-add-employee-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Employee --</option>
                        @foreach($employees ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Review Period <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="cycle_id"
                        id="review-add-cycle-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Review Period --</option>
                        @foreach($cycles ?? [] as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Reviewer
                    </label>
                    <select
                        name="reviewer_id"
                        id="review-add-reviewer-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="">-- Select Reviewer --</option>
                        @foreach($employees ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="review-add-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="not_started">Not Started</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="approved">Approved</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReviewAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Review Modal -->
        <x-admin.modal
            id="review-edit-modal"
            title="Edit Overall Rating"
            icon="fas fa-star"
            maxWidth="md"
            backdropOnClick="closeReviewEditModal(true)"
        >
            <form method="POST" id="review-edit-form" action="#">
                @csrf
                <input type="hidden" name="employee_id" id="review-edit-employee-id">
                <input type="hidden" name="cycle_id" id="review-edit-cycle-id">
                <input type="hidden" name="reviewer_id" id="review-edit-reviewer-id">
                <input type="hidden" name="status" id="review-edit-status">
                
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Overall Rating
                    </label>
                    <input
                        type="number"
                        name="overall_rating"
                        id="review-edit-overall-rating"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        placeholder="Enter overall rating (0-100)"
                        min="0"
                        max="100"
                        step="0.01"
                    >
                    <p class="text-xs mt-1" style="color: var(--text-muted);">
                        Leave empty to keep auto-calculated rating or enter manually.
                    </p>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReviewEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Review Modal -->
        <x-admin.modal
            id="review-delete-modal"
            title="Delete Performance Review"
            maxWidth="xs"
            backdropOnClick="closeReviewDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this performance review?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReviewDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmReviewDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Reviews Modal -->
        <x-admin.modal
            id="review-bulk-delete-modal"
            title="Delete Selected Reviews"
            maxWidth="xs"
            backdropOnClick="closeReviewBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected reviews?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReviewBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmReviewBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- View Review Modal -->
        <x-admin.modal
            id="review-view-modal"
            title="View Performance Review"
            icon="fas fa-eye"
            maxWidth="lg"
            backdropOnClick="closeReviewViewModal()"
        >
            <div id="review-view-content">
                <p class="text-xs" style="color: var(--text-muted);">Loading...</p>
            </div>
        </x-admin.modal>


        <!-- Hidden forms for deletes -->
        <form id="review-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="review-bulk-delete-form" method="POST" action="{{ route('performance.reviews.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="review-bulk-delete-ids" value="">
        </form>

        <script>
            // Global variables for review URLs
            var reviewEditUrlTemplate = "{{ route('performance.reviews.update', ['id' => '__ID__']) }}";
            var reviewDeleteUrlTemplate = "{{ route('performance.reviews.delete', ['id' => '__ID__']) }}";
            var pendingReviewDeleteId = null;

            (function () {

                function refreshReviewSelectionState() {
                    var table = document.getElementById('reviews-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('reviews-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.review-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('reviews-delete-selected');

                    var checkedCount = 0;
                    rowCheckboxes.forEach(function (cb) {
                        if (cb.checked) checkedCount++;
                    });

                    if (deleteSelectedBtn) {
                        deleteSelectedBtn.classList.toggle('hidden', checkedCount === 0);
                    }

                    if (headerCheckbox) {
                        if (rowCheckboxes.length === 0) {
                            headerCheckbox.checked = false;
                        } else if (checkedCount === rowCheckboxes.length) {
                            headerCheckbox.checked = true;
                        } else {
                            headerCheckbox.checked = false;
                        }
                        headerCheckbox.indeterminate = false;
                    }
                }

                function setupCheckboxes() {
                    var table = document.getElementById('reviews-table');
                    if (!table) return;

                    var masterCheckbox = document.getElementById('reviews-master-checkbox');
                    if (masterCheckbox && !masterCheckbox.dataset.listenerAttached) {
                        masterCheckbox.dataset.listenerAttached = 'true';
                        masterCheckbox.addEventListener('change', function () {
                            var allRowCheckboxes = table.querySelectorAll('.review-row-checkbox');
                            allRowCheckboxes.forEach(function (cb) {
                                cb.checked = masterCheckbox.checked;
                            });
                            refreshReviewSelectionState();
                        });
                    }
                }

                setupCheckboxes();

                var table = document.getElementById('reviews-table');
                if (table) {
                    table.addEventListener('click', function (e) {
                    var headerCheckboxClick = e.target.closest('#reviews-master-checkbox');
                    if (headerCheckboxClick) {
                        return;
                    }

                    var editBtn = e.target.closest('.hr-action-edit');
                    var deleteBtn = e.target.closest('.hr-action-delete');
                    var rowCheckbox = e.target.closest('.review-row-checkbox');

                    if (editBtn) {
                        var row = e.target.closest('.hr-table-row');
                        if (row) openReviewEditModalFromRow(row);
                        return;
                    }

                    if (deleteBtn) {
                        var rowDel = e.target.closest('.hr-table-row');
                        if (rowDel) openReviewDeleteModalFromRow(rowDel);
                        return;
                    }

                    if (rowCheckbox) {
                        refreshReviewSelectionState();
                    }
                    });
                }

                refreshReviewSelectionState();
            })();

            function openReviewAddModal() {
                document.getElementById('review-add-modal').classList.remove('hidden');
                document.getElementById('review-add-employee-id').focus();
            }

            function closeReviewAddModal(reset) {
                var m = document.getElementById('review-add-modal');
                if (m) {
                    m.classList.add('hidden');
                }
                if (reset) {
                    var form = m ? m.querySelector('form') : null;
                    if (form) form.reset();
                }
            }
            window.closeReviewAddModal = closeReviewAddModal;

            function openReviewEditModalFromRow(row) {
                if (!row) {
                    console.error('Row element not found');
                    return;
                }
                
                var info = row.querySelector('[data-review-id]');
                if (!info) {
                    console.error('Review data element not found in row');
                    return;
                }

                var reviewId = info.dataset.reviewId;
                if (!reviewId) {
                    console.error('Review ID not found');
                    return;
                }

                var employeeId = info.dataset.reviewEmployeeId || '';
                var cycleId = info.dataset.reviewCycleId || '';
                var reviewerId = info.dataset.reviewReviewerId || '';
                var overallRating = info.dataset.reviewOverallRating || '';
                var status = info.dataset.reviewStatus || 'not_started';

                var form = document.getElementById('review-edit-form');
                if (!form) {
                    console.error('Edit form not found');
                    return;
                }
                form.action = reviewEditUrlTemplate.replace('__ID__', reviewId);

                var modal = document.getElementById('review-edit-modal');
                if (!modal) {
                    console.error('Edit modal not found');
                    return;
                }

                // Set hidden fields to preserve existing data
                var employeeInput = document.getElementById('review-edit-employee-id');
                if (employeeInput) employeeInput.value = employeeId;

                var cycleInput = document.getElementById('review-edit-cycle-id');
                if (cycleInput) cycleInput.value = cycleId;

                var reviewerInput = document.getElementById('review-edit-reviewer-id');
                if (reviewerInput) reviewerInput.value = reviewerId || '';

                var statusInput = document.getElementById('review-edit-status');
                if (statusInput) statusInput.value = status.toLowerCase();

                // Set overall rating field
                var overallRatingInput = document.getElementById('review-edit-overall-rating');
                if (overallRatingInput) {
                    if (overallRating) {
                        overallRatingInput.value = overallRating;
                    } else {
                        overallRatingInput.value = '';
                    }
                    overallRatingInput.focus();
                }

                modal.classList.remove('hidden');
            }
            window.openReviewEditModalFromRow = openReviewEditModalFromRow;

            function closeReviewEditModal(reset) {
                var m = document.getElementById('review-edit-modal');
                if (m) {
                    m.classList.add('hidden');
                }
                if (reset) {
                    var form = m ? m.querySelector('form') : null;
                    if (form) form.reset();
                }
            }
            window.closeReviewEditModal = closeReviewEditModal;

            // Handle edit form submission
            var editForm = document.getElementById('review-edit-form');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    // Form will submit normally - no need to prevent default
                    // The action is set dynamically in openReviewEditModalFromRow
                });
            }

            function openReviewDeleteModalFromRow(row) {
                var info = row.querySelector('[data-review-id]');
                if (!info) return;
                pendingReviewDeleteId = info.dataset.reviewId;
                document.getElementById('review-delete-modal').classList.remove('hidden');
            }
            window.openReviewDeleteModalFromRow = openReviewDeleteModalFromRow;

            function closeReviewDeleteModal() {
                document.getElementById('review-delete-modal').classList.add('hidden');
                pendingReviewDeleteId = null;
            }
            window.closeReviewDeleteModal = closeReviewDeleteModal;

            function confirmReviewDelete() {
                if (!pendingReviewDeleteId) {
                    closeReviewDeleteModal();
                    return;
                }
                var form = document.getElementById('review-delete-form');
                if (form) {
                    form.action = reviewDeleteUrlTemplate.replace('__ID__', pendingReviewDeleteId);
                    closeReviewDeleteModal();
                    form.submit();
                }
            }
            window.confirmReviewDelete = confirmReviewDelete;

            function openReviewBulkDeleteModal() {
                var checkboxes = document.querySelectorAll('.review-row-checkbox:checked');
                var ids = Array.from(checkboxes).map(function(cb) {
                    return cb.dataset.reviewId;
                });
                if (ids.length === 0) return;
                document.getElementById('review-bulk-delete-ids').value = ids.join(',');
                document.getElementById('review-bulk-delete-modal').classList.remove('hidden');
            }
            window.openReviewBulkDeleteModal = openReviewBulkDeleteModal;

            function closeReviewBulkDeleteModal() {
                document.getElementById('review-bulk-delete-modal').classList.add('hidden');
            }
            window.closeReviewBulkDeleteModal = closeReviewBulkDeleteModal;

            function confirmReviewBulkDelete() {
                var form = document.getElementById('review-bulk-delete-form');
                if (form) {
                    form.submit();
                }
            }
            window.confirmReviewBulkDelete = confirmReviewBulkDelete;

            function openReviewViewModal(reviewId) {
                var modal = document.getElementById('review-view-modal');
                var content = document.getElementById('review-view-content');
                
                if (!modal || !content) return;
                
                modal.classList.remove('hidden');
                content.innerHTML = '<p class="text-xs" style="color: var(--text-muted);">Loading...</p>';
                
                fetch("{{ route('performance.reviews.view', ['id' => '__ID__']) }}".replace('__ID__', reviewId))
                    .then(response => response.json())
                    .then(data => {
                        // Format status
                        var statusText = data.status || '-';
                        if (statusText !== '-') {
                            statusText = statusText.replace(/_/g, ' ').replace(/\b\w/g, function(l) {
                                return l.toUpperCase();
                            });
                        }
                        
                        var html = '<div class="space-y-4">';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Employee:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + (data.employee || '-') + '</p></div>';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Job Title:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + (data.job_title || '-') + '</p></div>';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Review Period:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + (data.review_period || '-') + '</p></div>';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Due Date:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + (data.due_date || '-') + '</p></div>';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Reviewer:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + (data.reviewer || '-') + '</p></div>';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Status:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + statusText + '</p></div>';
                        html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Overall Rating:</label><p class="text-xs mt-1" style="color: var(--text-muted);">' + (data.overall_rating || '-') + '</p></div>';
                        if (data.comments) {
                            html += '<div><label class="text-xs font-semibold" style="color: var(--text-primary);">Comments:</label><p class="text-xs mt-1 whitespace-pre-wrap" style="color: var(--text-muted);">' + data.comments + '</p></div>';
                        }
                        html += '</div>';
                        content.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading review:', error);
                        content.innerHTML = '<p class="text-xs" style="color: #DC2626;">Error loading review details. Please try again.</p>';
                    });
            }
            window.openReviewViewModal = openReviewViewModal;

            function closeReviewViewModal() {
                document.getElementById('review-view-modal').classList.add('hidden');
            }
            window.closeReviewViewModal = closeReviewViewModal;


            // Approve Review Function
            function approveReview(reviewId) {
                var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                var formData = new FormData();
                formData.append('_token', csrfToken);
                fetch("{{ route('performance.reviews.approve', ['id' => '__ID__']) }}".replace('__ID__', reviewId), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                })
                .catch(error => {
                    console.error('Error approving review:', error);
                    alert('Error approving review. Please try again.');
                });
            }
            window.approveReview = approveReview;

            // Search form submit: add hash so page scrolls to table after reload
            var searchForm = document.getElementById('reviews-search-form');
            if (searchForm) {
                searchForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    var formAction = searchForm.getAttribute('action') || window.location.pathname;
                    var url = new URL(formAction, window.location.origin);

                    var formData = new FormData(searchForm);
                    for (var pair of formData.entries()) {
                        if (pair[1]) {
                            url.searchParams.set(pair[0], pair[1]);
                        }
                    }

                    url.hash = 'reviews-table-section';
                    window.location.href = url.toString();
                });

                // Reset button: clear filters and go back to base route
                var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]') || searchForm.querySelector('button[type="button"]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();

                        searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                            el.value = '';
                        });

                        window.location.href = "{{ route('performance') }}";
                    });
                }
            }

            // Scroll to table section if status message exists (after add/edit/delete)
            @if(session('status') || session('error'))
                (function () {
                    var tableSection = document.getElementById('reviews-table-section');
                    if (tableSection) {
                        setTimeout(function () {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                })();
            @endif

            // Scroll to table section if hash exists or if search parameters are present
            if (window.location.hash === '#reviews-table-section' ||
                (window.location.search && (window.location.search.includes('employee_name=') ||
                                            window.location.search.includes('job_title=') ||
                                            window.location.search.includes('review_status=') ||
                                            window.location.search.includes('reviewer=') ||
                                            window.location.search.includes('from_date=') ||
                                            window.location.search.includes('to_date=')))) {
                var tableSection = document.getElementById('reviews-table-section');
                if (tableSection) {
                    setTimeout(function () {
                        tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            }
        </script>
    </x-main-layout>
@endsection
