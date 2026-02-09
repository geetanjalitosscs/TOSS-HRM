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

                    <!-- Manage Performance Reviews Section -->
                    <section class="hr-card p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2">
                            <i class="fas fa-star text-[var(--color-primary)]"></i> <span class="mt-0.5">Manage Performance Reviews</span>
                        </h2>
                            <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                                <button
                                    id="reviews-delete-selected"
                                    type="button"
                                    class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                    onclick="openReviewBulkDeleteModal()"
                                >
                                    <i class="fas fa-trash-alt mr-2"></i>Delete Selected
                                </button>
                                <x-admin.add-button class="mb-0" onClick="openReviewAddModal()" />
                            </div>
                        </div>

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

                        <!-- Filter Form -->
                        <div class="bg-[var(--color-primary-light)] rounded-lg p-3 mb-3 border border-[var(--border-default)]">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white" placeholder="Type for hints...">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white">
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
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white">
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
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white">
                                        <option>Current Employees Only</option>
                                        <option>Past Employees Only</option>
                                        <option>All Employees</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Review Status</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white">
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
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white" placeholder="Type for hints...">
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

                        @if(isset($reviews) && count($reviews) > 0)
                        <!-- Records Count -->
                        <x-records-found :count="count($reviews)" />
                        @endif

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
                            <div class="flex-shrink-0" style="width: 90px;">
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
                                                    {{ $review->review_status }}
                                                </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 90px;">
                                    <div class="flex items-center justify-center gap-2">
                                                    <button class="hr-action-view flex-shrink-0" title="View"
                                                            onclick="event.preventDefault(); event.stopPropagation(); openReviewViewModal({{ $review->id }});">
                                            <i class="fas fa-file-alt text-sm"></i>
                                        </button>
                                                    <button class="hr-action-edit flex-shrink-0" title="Edit"
                                                            onclick="event.preventDefault(); event.stopPropagation(); openReviewEditModalFromRow(this.closest('.hr-table-row'));">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
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
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
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
            title="Edit Performance Review"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeReviewEditModal(true)"
        >
            <form method="POST" id="review-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="employee_id"
                        id="review-edit-employee-id"
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
                        id="review-edit-cycle-id"
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
                        id="review-edit-reviewer-id"
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
                        id="review-edit-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
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
            icon="fas fa-file-alt"
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
            (function () {
                var reviewEditUrlTemplate = "{{ route('performance.reviews.update', ['id' => '__ID__']) }}";
                var reviewDeleteUrlTemplate = "{{ route('performance.reviews.delete', ['id' => '__ID__']) }}";

                var pendingReviewDeleteId = null;

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
                var info = row.querySelector('[data-review-id]');
                if (!info) return;

                var reviewId = info.dataset.reviewId;
                var employee = info.dataset.reviewEmployee || '';
                var jobTitle = info.dataset.reviewJobTitle || '';
                var reviewPeriod = info.dataset.reviewReviewPeriod || '';
                var dueDate = info.dataset.reviewDueDate || '';
                var reviewer = info.dataset.reviewReviewer || '';
                var status = info.dataset.reviewStatus || 'pending';

                var form = document.getElementById('review-edit-form');
                if (form) {
                    form.action = reviewEditUrlTemplate.replace('__ID__', reviewId);
                }

                var employeeSelect = document.getElementById('review-edit-employee-id');
                if (employeeSelect) {
                    employeeSelect.value = '';
                    Array.from(employeeSelect.options).forEach(function(opt) {
                        if (opt.text === employee) {
                            employeeSelect.value = opt.value;
                        }
                    });
                }

                var statusSelect = document.getElementById('review-edit-status');
                if (statusSelect) {
                    statusSelect.value = status.toLowerCase();
                }

                document.getElementById('review-edit-modal').classList.remove('hidden');
                if (employeeSelect) employeeSelect.focus();
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
                document.getElementById('review-view-modal').classList.remove('hidden');
                document.getElementById('review-view-content').innerHTML = '<p class="text-xs" style="color: var(--text-muted);">Loading...</p>';
                // TODO: Fetch review details via AJAX and populate modal
            }
            window.openReviewViewModal = openReviewViewModal;

            function closeReviewViewModal() {
                document.getElementById('review-view-modal').classList.add('hidden');
            }
            window.closeReviewViewModal = closeReviewViewModal;
        </script>
    </x-main-layout>
@endsection
