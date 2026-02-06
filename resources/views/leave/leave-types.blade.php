@extends('layouts.app')

@section('title', 'Leave - Leave Types')

@section('body')
    <x-main-layout title="Leave / Configure">
        <x-leave.tabs activeTab="leave-types" />
        
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-list text-[var(--color-primary)]"></i> Leave Types
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="leave-types-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openLeaveTypeBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openLeaveTypeAddModal()" />
                </div>
            </div>

            {{-- <!-- Search Form -->
            <form method="GET" action="{{ route('leave.leave-types') }}" class="mb-4">
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by name"
                            class="hr-input w-full px-3 py-1.5 text-xs"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                    </div>
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        Search
                    </button>
                    @if(request('search'))
                        <a
                            href="{{ route('leave.leave-types') }}"
                            class="hr-btn-secondary px-4 py-1.5 text-xs"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </form> --}}

            @if(isset($leaveTypes) && count($leaveTypes) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($leaveTypes)" />
            @endif

            <!-- Table -->
            <div id="leave-types-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="leave-types-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Name
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 100px; display: flex; justify-content: center; align-items: center;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                 style="color: var(--text-primary);">
                                Max/Year
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 120px; display: flex; justify-content: center; align-items: center;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                 style="color: var(--text-primary);">
                                Calculate Monthly
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 80px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight text-center"
                                 style="color: var(--text-primary);">
                                Actions
                            </div>
                        </div>
                    </div>

                    <!-- Rows -->
                    <div class="border border-t-0 rounded-b-lg"
                         style="border-color: var(--border-default);">
                        @forelse($leaveTypes as $type)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="leave-type-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-leave-type-id="{{ $type->id }}"
                                         data-leave-type-name="{{ $type->name }}"
                                         data-leave-type-code="{{ $type->code }}"
                                         data-leave-type-is-paid="{{ $type->is_paid }}"
                                         data-leave-type-requires-approval="{{ $type->requires_approval }}"
                                         data-leave-type-max-per-year="{{ $type->max_per_year ?? '' }}"
                                         data-leave-type-carry-forward="{{ $type->carry_forward }}"
                                         data-leave-type-calculate-monthly="{{ $type->calculate_monthly ?? 0 }}"
                                    >
                                        {{ $type->name }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 100px; display: flex; justify-content: center; align-items: center;">
                                    <div class="text-xs text-center" style="color: var(--text-primary);">
                                        @if($type->max_per_year !== null)
                                            {{ number_format((float)$type->max_per_year, 0, '.', '') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 120px; display: flex; justify-content: center; align-items: center;">
                                    <div class="text-xs text-center" style="color: var(--text-primary);">
                                        @if(isset($type->calculate_monthly) && $type->calculate_monthly == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 80px;">
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
                        @empty
                            <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                No leave types found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Leave Type Modal -->
        <x-admin.modal
            id="leave-type-add-modal"
            title="Add Leave Type"
            icon="fas fa-list"
            maxWidth="md"
            backdropOnClick="closeLeaveTypeAddModal(true)"
        >
            <form method="POST" action="{{ route('leave.leave-types.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Max Per Year
                    </label>
                    <input
                        type="number"
                        name="max_per_year"
                        step="1"
                        min="0"
                        max="999"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Calculate Monthly
                    </label>
                    <select
                        name="calculate_monthly"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeLeaveTypeAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Leave Type Modal -->
        <x-admin.modal
            id="leave-type-edit-modal"
            title="Edit Leave Type"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeLeaveTypeEditModal(true)"
        >
            <form method="POST" id="leave-type-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="leave-type-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Max Per Year
                    </label>
                    <input
                        type="number"
                        name="max_per_year"
                        id="leave-type-edit-max-per-year"
                        step="1"
                        min="0"
                        max="999"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Calculate Monthly
                    </label>
                    <select
                        name="calculate_monthly"
                        id="leave-type-edit-calculate-monthly"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeLeaveTypeEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Leave Type Modal -->
        <x-admin.modal
            id="leave-type-delete-modal"
            title="Delete Leave Type"
            maxWidth="xs"
            backdropOnClick="closeLeaveTypeDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this leave type?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeLeaveTypeDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmLeaveTypeDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Leave Types Modal -->
        <x-admin.modal
            id="leave-type-bulk-delete-modal"
            title="Delete Selected Leave Types"
            maxWidth="xs"
            backdropOnClick="closeLeaveTypeBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected leave types?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeLeaveTypeBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmLeaveTypeBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="leave-type-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="leave-type-bulk-delete-form" method="POST" action="{{ route('leave.leave-types.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="leave-type-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var leaveTypeEditUrlBase = "{{ route('leave.leave-types.update', ['id' => 0]) }}";
                var leaveTypeDeleteUrlBase = "{{ route('leave.leave-types.delete', ['id' => 0]) }}";
                var leaveTypeEditUrlTemplate = leaveTypeEditUrlBase.replace('/0', '/__ID__');
                var leaveTypeDeleteUrlTemplate = leaveTypeDeleteUrlBase.replace('/0', '/__ID__');

                var pendingLeaveTypeDeleteId = null;

                function openLeaveTypeAddModal() {
                    var m = document.getElementById('leave-type-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openLeaveTypeAddModal = openLeaveTypeAddModal;

                function closeLeaveTypeAddModal(reset) {
                    var m = document.getElementById('leave-type-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeLeaveTypeAddModal = closeLeaveTypeAddModal;

                function openLeaveTypeEditModalFromRow(row) {
                    var info = row.querySelector('[data-leave-type-id]');
                    if (!info) return;

                    var id = info.dataset.leaveTypeId;
                    var name = info.dataset.leaveTypeName || '';
                    var maxPerYear = info.dataset.leaveTypeMaxPerYear || '';
                    var calculateMonthly = info.dataset.leaveTypeCalculateMonthly || '0';

                    var m = document.getElementById('leave-type-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('leave-type-edit-name');
                    if (nameInput) nameInput.value = name;

                    var maxPerYearInput = document.getElementById('leave-type-edit-max-per-year');
                    if (maxPerYearInput) {
                        // Remove trailing .00 from the value
                        if (maxPerYear && maxPerYear !== '') {
                            var numValue = parseFloat(maxPerYear);
                            if (numValue % 1 === 0) {
                                maxPerYearInput.value = numValue.toString();
                            } else {
                                maxPerYearInput.value = maxPerYear;
                            }
                        } else {
                            maxPerYearInput.value = '';
                        }
                    }

                    var calculateMonthlySelect = document.getElementById('leave-type-edit-calculate-monthly');
                    if (calculateMonthlySelect) {
                        calculateMonthlySelect.value = calculateMonthly;
                    }

                    var form = document.getElementById('leave-type-edit-form');
                    if (form) {
                        form.action = leaveTypeEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }

                function closeLeaveTypeEditModal(reset) {
                    var m = document.getElementById('leave-type-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeLeaveTypeEditModal = closeLeaveTypeEditModal;

                function openLeaveTypeDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-leave-type-id]');
                    if (!info) return;
                    pendingLeaveTypeDeleteId = info.dataset.leaveTypeId || null;
                    var m = document.getElementById('leave-type-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeLeaveTypeDeleteModal() {
                    var m = document.getElementById('leave-type-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingLeaveTypeDeleteId = null;
                }
                window.closeLeaveTypeDeleteModal = closeLeaveTypeDeleteModal;

                function confirmLeaveTypeDelete() {
                    if (!pendingLeaveTypeDeleteId) {
                        closeLeaveTypeDeleteModal();
                        return;
                    }
                    var form = document.getElementById('leave-type-delete-form');
                    if (!form) {
                        closeLeaveTypeDeleteModal();
                        return;
                    }
                    form.action = leaveTypeDeleteUrlTemplate.replace('__ID__', pendingLeaveTypeDeleteId);
                    closeLeaveTypeDeleteModal();
                    form.submit();
                }
                window.confirmLeaveTypeDelete = confirmLeaveTypeDelete;

                function openLeaveTypeBulkDeleteModal() {
                    var m = document.getElementById('leave-type-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openLeaveTypeBulkDeleteModal = openLeaveTypeBulkDeleteModal;

                function closeLeaveTypeBulkDeleteModal() {
                    var m = document.getElementById('leave-type-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeLeaveTypeBulkDeleteModal = closeLeaveTypeBulkDeleteModal;

                function confirmLeaveTypeBulkDelete() {
                    var table = document.getElementById('leave-types-table');
                    if (!table) {
                        closeLeaveTypeBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.leave-type-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.border-b');
                        if (!row) return;
                        var info = row.querySelector('[data-leave-type-id]');
                        if (info && info.dataset.leaveTypeId) {
                            ids.push(info.dataset.leaveTypeId);
                        }
                    });

                    if (!ids.length) {
                        closeLeaveTypeBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('leave-type-bulk-delete-form');
                    var input = document.getElementById('leave-type-bulk-delete-ids');
                    if (!form || !input) {
                        closeLeaveTypeBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeLeaveTypeBulkDeleteModal();
                    form.submit();
                }
                window.confirmLeaveTypeBulkDelete = confirmLeaveTypeBulkDelete;

                function refreshLeaveTypeSelectionState() {
                    var table = document.getElementById('leave-types-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('leave-types-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.leave-type-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('leave-types-delete-selected');

                    var checkedCount = 0;
                    rowCheckboxes.forEach(function (cb) {
                        if (cb.checked) checkedCount++;
                    });

                    // Show "Delete Selected" button only when at least 1 row is checked
                    if (deleteSelectedBtn) {
                        deleteSelectedBtn.classList.toggle('hidden', checkedCount === 0);
                    }

                    // Header checkbox: when checked ALL rows are checked, otherwise empty (no "-")
                    if (headerCheckbox) {
                        if (rowCheckboxes.length === 0) {
                            headerCheckbox.checked = false;
                        } else if (checkedCount === rowCheckboxes.length) {
                            // All rows checked → header checkbox checked
                            headerCheckbox.checked = true;
                        } else {
                            // Some or no rows checked → header checkbox empty (unchecked)
                            headerCheckbox.checked = false;
                        }
                        // Never show indeterminate state (no "-")
                        headerCheckbox.indeterminate = false;
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var table = document.getElementById('leave-types-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('leave-types-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.leave-type-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshLeaveTypeSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        // Don't interfere with header checkbox clicks
                        var headerCheckboxClick = e.target.closest('#leave-types-master-checkbox');
                        if (headerCheckboxClick) {
                            return; // Let the change event handler handle it
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.leave-type-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.border-b');
                            if (row) openLeaveTypeEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.border-b');
                            if (rowDel) openLeaveTypeDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshLeaveTypeSelectionState();
                        }
                    });

                    refreshLeaveTypeSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
