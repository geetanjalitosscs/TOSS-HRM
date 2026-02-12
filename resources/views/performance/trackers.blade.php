@extends('layouts.app')

@section('title', 'Performance - Trackers')

@section('body')
    <x-main-layout title="Performance">
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
            
            <form method="GET" action="{{ route('performance.trackers') }}" id="trackers-search-form">
            <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                            <input
                                type="text"
                                name="employee_name"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                placeholder="Type for hints..."
                                value="{{ request('employee_name') }}"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Tracker</label>
                            <input
                                type="text"
                                name="tracker"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                placeholder="Type for hints..."
                                value="{{ request('tracker') }}"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Added Date Range</label>
                            <div class="flex gap-2">
                                <input
                                    type="date"
                                    name="from_date"
                                    class="hr-input flex-1 px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    value="{{ request('from_date') }}"
                                    placeholder="From"
                                >
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                            <select
                                name="status"
                                class="hr-select w-full px-2 py-1.5 text-xs"
                            >
                                <option value="">All</option>
                                <option value="not_started" {{ request('status') === 'not_started' ? 'selected' : '' }}>Not Started</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                    </div>
                    <x-admin.action-buttons resetType="button" searchType="submit" />
                </div>
            </form>
        </section>

        <!-- Trackers Table Section -->
        <section class="hr-card p-6" id="trackers-table-section">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-list-alt" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Trackers List</span>
            </h2>
            
            @if(count($trackers) > 0)
            <!-- Records Count + Actions -->
            <div class="flex items-center justify-between mb-2">
                <x-records-found :count="count($trackers)" />
                <div class="flex items-center gap-3">
                    <button
                        id="trackers-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openTrackerBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button label="+ Add" onClick="openTrackerAddModal()" />
                </div>
            </div>

            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto; overflow-x: hidden;">
                <!-- Table Header -->
                <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" id="trackers-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee</span>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Tracker</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Added Date</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Modified Date</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</span>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                    </div>
                </div>

                <!-- Table Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @foreach($trackers as $tracker)
                    <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'"
                         data-tracker-id="{{ $tracker->id }}"
                         data-tracker-employee-id="{{ $tracker->employee_id }}"
                         data-tracker-cycle-id="{{ $tracker->cycle_id }}"
                         data-tracker-status="{{ $tracker->status }}">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" class="tracker-row-checkbox rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" data-tracker-checkbox-id="{{ $tracker->id }}">
                        </div>
                        <div class="flex-1" style="min-width: 0%;">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker->employee }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0%;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->tracker }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0%;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->added_date }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0%;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->modified_date }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0%;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">
                                @php
                                    $statusLabelMap = [
                                        'not_started' => 'Not Started',
                                        'in_progress' => 'In Progress',
                                        'completed'   => 'Completed',
                                        'approved'    => 'Approved',
                                    ];
                                    $statusValue = $tracker->status ?? 'not_started';
                                @endphp
                                {{ $statusLabelMap[$statusValue] ?? ucfirst(str_replace('_', ' ', $statusValue)) }}
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 90px;">
                            <div class="flex items-center justify-center gap-2">
                                <button class="hr-action-edit flex-shrink-0" title="Edit" type="button" onclick="openTrackerEditModalFromRow(this.closest('.hr-table-row'))">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="hr-action-delete flex-shrink-0" title="Delete" type="button" onclick="openTrackerDeleteModalFromRow(this.closest('.hr-table-row'))">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <!-- No Records Found -->
            <div class="flex items-center justify-between mb-2">
                <x-records-found :count="0" />
                <x-admin.add-button label="+ Add" onClick="openTrackerAddModal()" />
            </div>
            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto; overflow-x: hidden;">
                <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" disabled>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Tracker</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Added Date</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Modified Date</span>
                    </div>
                    <div class="flex-1" style="min-width: 0%;">
                        <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</span>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                    </div>
                </div>
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    <div class="px-4 py-6 text-center text-xs" style="color: var(--text-muted);">
                        No records found.
                    </div>
                </div>
            </div>
            @endif
        </section>

        <!-- Add Tracker Modal -->
        <x-admin.modal
            id="tracker-add-modal"
            title="Add Tracker"
            icon="fas fa-list-alt"
            maxWidth="md"
            backdropOnClick="closeTrackerAddModal(true)"
        >
            <form method="POST" action="{{ route('performance.trackers.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="employee_id"
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
                        Tracker (Review Cycle) <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="cycle_id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Cycle --</option>
                        @foreach($cycles ?? [] as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status
                    </label>
                    <select
                        name="status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
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
                        onclick="closeTrackerAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Tracker Modal -->
        <x-admin.modal
            id="tracker-edit-modal"
            title="Edit Tracker"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeTrackerEditModal(true)"
        >
            <form method="POST" id="tracker-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="employee_id"
                        id="tracker-edit-employee-id"
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
                        Tracker (Review Cycle) <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="cycle_id"
                        id="tracker-edit-cycle-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Cycle --</option>
                        @foreach($cycles ?? [] as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status
                    </label>
                    <select
                        name="status"
                        id="tracker-edit-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
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
                        onclick="closeTrackerEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Tracker Modal -->
        <x-admin.modal
            id="tracker-delete-modal"
            title="Delete Tracker"
            icon="fas fa-trash-alt"
            maxWidth="sm"
            backdropOnClick="closeTrackerDeleteModal()"
        >
            <form method="POST" id="tracker-delete-form" action="#">
                @csrf
                <p class="text-xs mb-4" style="color: var(--text-primary);">
                    Are you sure you want to delete this tracker? This action cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeTrackerDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        Delete
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Bulk Delete Trackers Modal -->
        <x-admin.modal
            id="tracker-bulk-delete-modal"
            title="Delete Selected Trackers"
            icon="fas fa-trash-alt"
            maxWidth="sm"
            backdropOnClick="closeTrackerBulkDeleteModal()"
        >
            <form method="POST" id="tracker-bulk-delete-form" action="{{ route('performance.trackers.bulk-delete') }}">
                @csrf
                <input type="hidden" name="ids" id="tracker-bulk-delete-ids">
                <p class="text-xs mb-4" style="color: var(--text-primary);">
                    Are you sure you want to delete the selected trackers? This action cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeTrackerBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        Delete
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <script>
            (function () {
                var trackerEditUrlTemplate = "{{ route('performance.trackers.update', ['id' => '__ID__']) }}";
                var trackerDeleteUrlTemplate = "{{ route('performance.trackers.delete', ['id' => '__ID__']) }}";
                var pendingTrackerDeleteId = null;

                function refreshTrackerSelectionState() {
                    var checkboxes = document.querySelectorAll('.tracker-row-checkbox');
                    var master = document.getElementById('trackers-master-checkbox');
                    var deleteSelectedBtn = document.getElementById('trackers-delete-selected');

                    var total = checkboxes.length;
                    var checked = 0;
                    checkboxes.forEach(function (cb) {
                        if (cb.checked && !cb.disabled) checked++;
                    });

                    if (master) {
                        if (total === 0 || checked === 0) {
                            master.checked = false;
                        } else if (checked === total) {
                            master.checked = true;
                        }
                        master.indeterminate = false;
                    }

                    if (deleteSelectedBtn) {
                        deleteSelectedBtn.classList.toggle('hidden', checked === 0);
                    }
                }

                function setupTrackerCheckboxes() {
                    var master = document.getElementById('trackers-master-checkbox');
                    var checkboxes = document.querySelectorAll('.tracker-row-checkbox');

                    if (master) {
                        master.addEventListener('change', function () {
                            var checked = master.checked;
                            checkboxes.forEach(function (cb) {
                                if (!cb.disabled) {
                                    cb.checked = checked;
                                }
                            });
                            refreshTrackerSelectionState();
                        });
                    }

                    checkboxes.forEach(function (cb) {
                        cb.addEventListener('change', refreshTrackerSelectionState);
                    });

                    refreshTrackerSelectionState();
                }

                function openTrackerAddModal() {
                    var m = document.getElementById('tracker-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openTrackerAddModal = openTrackerAddModal;

                function closeTrackerAddModal(reset) {
                    var m = document.getElementById('tracker-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeTrackerAddModal = closeTrackerAddModal;

                function openTrackerEditModalFromRow(row) {
                    if (!row || !row.dataset) return;

                    var id = row.dataset.trackerId;
                    var employeeId = row.dataset.trackerEmployeeId || '';
                    var cycleId = row.dataset.trackerCycleId || '';
                    var status = row.dataset.trackerStatus || 'not_started';

                    var m = document.getElementById('tracker-edit-modal');
                    if (!m) return;

                    var employeeSelect = document.getElementById('tracker-edit-employee-id');
                    if (employeeSelect) employeeSelect.value = employeeId;

                    var cycleSelect = document.getElementById('tracker-edit-cycle-id');
                    if (cycleSelect) cycleSelect.value = cycleId;

                    var statusSelect = document.getElementById('tracker-edit-status');
                    if (statusSelect) statusSelect.value = status;

                    var form = document.getElementById('tracker-edit-form');
                    if (form) {
                        form.action = trackerEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openTrackerEditModalFromRow = openTrackerEditModalFromRow;

                function closeTrackerEditModal(reset) {
                    var m = document.getElementById('tracker-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeTrackerEditModal = closeTrackerEditModal;

                function openTrackerDeleteModalFromRow(row) {
                    if (!row || !row.dataset) return;
                    pendingTrackerDeleteId = row.dataset.trackerId || null;
                    var m = document.getElementById('tracker-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openTrackerDeleteModalFromRow = openTrackerDeleteModalFromRow;

                function closeTrackerDeleteModal() {
                    var m = document.getElementById('tracker-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingTrackerDeleteId = null;
                }
                window.closeTrackerDeleteModal = closeTrackerDeleteModal;

                var deleteForm = document.getElementById('tracker-delete-form');
                if (deleteForm) {
                    deleteForm.addEventListener('submit', function (e) {
                        if (!pendingTrackerDeleteId) {
                            e.preventDefault();
                            closeTrackerDeleteModal();
                            return;
                        }
                        deleteForm.action = trackerDeleteUrlTemplate.replace('__ID__', pendingTrackerDeleteId);
                    });
                }

                function openTrackerBulkDeleteModal() {
                    var m = document.getElementById('tracker-bulk-delete-modal');
                    if (!m) return;

                    var idsInput = document.getElementById('tracker-bulk-delete-ids');
                    if (!idsInput) return;

                    var ids = [];
                    document.querySelectorAll('.tracker-row-checkbox').forEach(function (cb) {
                        if (cb.checked && cb.dataset.trackerCheckboxId) {
                            ids.push(cb.dataset.trackerCheckboxId);
                        }
                    });

                    if (ids.length === 0) {
                        closeTrackerBulkDeleteModal();
                        return;
                    }

                    idsInput.value = ids.join(',');
                    m.classList.remove('hidden');
                }
                window.openTrackerBulkDeleteModal = openTrackerBulkDeleteModal;

                function closeTrackerBulkDeleteModal() {
                    var m = document.getElementById('tracker-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                    var idsInput = document.getElementById('tracker-bulk-delete-ids');
                    if (idsInput) idsInput.value = '';
                }
                window.closeTrackerBulkDeleteModal = closeTrackerBulkDeleteModal;

                // Search form submit: add hash so page scrolls to table after reload
                var searchForm = document.getElementById('trackers-search-form');
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

                        url.hash = 'trackers-table-section';
                        window.location.href = url.toString();
                    });

                    // Reset button: clear filters and go back to base route
                    var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type=\"button\"]') || searchForm.querySelector('button[type=\"button\"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            e.stopPropagation();

                            searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                                el.value = '';
                            });

                            window.location.href = "{{ route('performance.trackers') }}";
                        });
                    }
                }

                // Scroll to table section if status message exists (after add/edit/delete)
                @if(session('status'))
                    (function () {
                        var tableSection = document.getElementById('trackers-table-section');
                        if (tableSection) {
                            setTimeout(function () {
                                tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 100);
                        }
                    })();
                @endif

                // Scroll to table section if hash exists or if search parameters are present
                if (window.location.hash === '#trackers-table-section' ||
                    (window.location.search && (window.location.search.includes('employee_name=') ||
                                                window.location.search.includes('tracker=') ||
                                                window.location.search.includes('from_date=') ||
                                                window.location.search.includes('to_date=')))) {
                    var tableSection = document.getElementById('trackers-table-section');
                    if (tableSection) {
                        setTimeout(function () {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 300);
                    }
                }

                // Initialize
                setupTrackerCheckboxes();
            })();
        </script>
    </x-main-layout>
@endsection