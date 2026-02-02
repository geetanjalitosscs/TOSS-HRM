@extends('layouts.app')

@section('title', 'Leave - Holidays')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="holidays" />
        
        <!-- Holidays Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-calendar-check" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Holidays</span>
            </h2>
            
            <form method="GET" action="{{ route('leave.holidays') }}" id="holidays-search-form">
                <x-admin.search-panel title="" :collapsed="false">
                    <div class="flex items-end gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Name</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ request('name') }}"
                                placeholder="Search by name"
                                class="hr-input w-full px-3 py-1.5 text-xs"
                                style="background-color: var(--bg-input); color: var(--text-primary);"
                            >
                        </div>
                        <div class="flex-1">
                            <x-date-picker 
                                name="from_date"
                                value="{{ request('from_date', '') }}"
                                label="From"
                            />
                        </div>
                        <div class="flex-1">
                            <x-date-picker 
                                name="to_date"
                                value="{{ request('to_date', '') }}"
                                label="To"
                            />
                        </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" />
                    </div>
                </x-admin.search-panel>
            </form>
        </section>
        
        <!-- Holidays Table Section -->
        <section id="holidays-table-section" class="hr-card p-6">
            @if(session('status'))
                <div class="mb-4 px-3 py-2 rounded border text-xs" style="background-color: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.3); color: rgb(22, 163, 74);">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-calendar-check text-purple-500"></i> Holidays
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="holidays-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openHolidayBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openHolidayAddModal()" />
                </div>
            </div>

            @if(isset($holidays) && count($holidays) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($holidays)" />
            @endif

            <!-- Table -->
            <div id="holidays-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="holidays-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Name
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Date
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Full Day/Half Day
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Repeats Annually
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
                        @forelse($holidays as $holiday)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="holiday-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-holiday-id="{{ $holiday->id }}"
                                         data-holiday-name="{{ $holiday->name }}"
                                         data-holiday-date="{{ $holiday->date }}"
                                         data-holiday-is-full-day="{{ $holiday->is_full_day ?? 1 }}"
                                         data-holiday-is-recurring="{{ $holiday->is_recurring ?? 0 }}"
                                    >
                                        {{ $holiday->name }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $holiday->date }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $holiday->full_day_half_day ?? 'Full Day' }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $holiday->repeats }}
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
                                No holidays found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Holiday Modal -->
        <x-admin.modal
            id="holiday-add-modal"
            title="Add Holiday"
            icon="fas fa-calendar-check"
            maxWidth="md"
            backdropOnClick="closeHolidayAddModal(true)"
        >
            <form method="POST" action="{{ route('leave.holidays.store') }}">
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
                        maxlength="191"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <x-date-picker 
                        name="holiday_date"
                        value=""
                        label=""
                    />
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Full Day/Half Day <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="is_full_day"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="1">Full Day</option>
                        <option value="0">Half Day</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Repeats Annually
                    </label>
                    <select
                        name="is_recurring"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeHolidayAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Holiday Modal -->
        <x-admin.modal
            id="holiday-edit-modal"
            title="Edit Holiday"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeHolidayEditModal(true)"
        >
            <form method="POST" id="holiday-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="holiday-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <x-date-picker 
                        name="holiday_date"
                        value=""
                        id="holiday-edit-date-picker"
                        label=""
                    />
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Full Day/Half Day <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="is_full_day"
                        id="holiday-edit-is-full-day"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="1">Full Day</option>
                        <option value="0">Half Day</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Repeats Annually
                    </label>
                    <select
                        name="is_recurring"
                        id="holiday-edit-is-recurring"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeHolidayEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Holiday Modal -->
        <x-admin.modal
            id="holiday-delete-modal"
            title="Delete Holiday"
            maxWidth="xs"
            backdropOnClick="closeHolidayDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this holiday?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeHolidayDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmHolidayDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Holidays Modal -->
        <x-admin.modal
            id="holiday-bulk-delete-modal"
            title="Delete Selected Holidays"
            maxWidth="xs"
            backdropOnClick="closeHolidayBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected holidays?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeHolidayBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmHolidayBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="holiday-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="holiday-bulk-delete-form" method="POST" action="{{ route('leave.holidays.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="holiday-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var holidayEditUrlTemplate = "{{ route('leave.holidays.update', ['id' => '__ID__']) }}";
                var holidayDeleteUrlTemplate = "{{ route('leave.holidays.delete', ['id' => '__ID__']) }}";

                var pendingHolidayDeleteId = null;

                function openHolidayAddModal() {
                    var m = document.getElementById('holiday-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openHolidayAddModal = openHolidayAddModal;

                function closeHolidayAddModal(reset) {
                    var m = document.getElementById('holiday-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeHolidayAddModal = closeHolidayAddModal;

                function openHolidayEditModalFromRow(row) {
                    var info = row.querySelector('[data-holiday-id]');
                    if (!info) return;

                    var id = info.dataset.holidayId;
                    var name = info.dataset.holidayName || '';
                    var date = info.dataset.holidayDate || '';
                    var isFullDay = info.dataset.holidayIsFullDay || '1';
                    var isRecurring = info.dataset.holidayIsRecurring || '0';

                    var m = document.getElementById('holiday-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('holiday-edit-name');
                    if (nameInput) nameInput.value = name;

                    var dateInput = document.getElementById('holiday-edit-date-picker');
                    if (dateInput) dateInput.value = date;

                    var isFullDaySelect = document.getElementById('holiday-edit-is-full-day');
                    if (isFullDaySelect) isFullDaySelect.value = isFullDay;

                    var isRecurringSelect = document.getElementById('holiday-edit-is-recurring');
                    if (isRecurringSelect) isRecurringSelect.value = isRecurring;

                    var form = document.getElementById('holiday-edit-form');
                    if (form) {
                        form.action = holidayEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }

                function closeHolidayEditModal(reset) {
                    var m = document.getElementById('holiday-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeHolidayEditModal = closeHolidayEditModal;

                function openHolidayDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-holiday-id]');
                    if (!info) return;
                    pendingHolidayDeleteId = info.dataset.holidayId || null;
                    var m = document.getElementById('holiday-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeHolidayDeleteModal() {
                    var m = document.getElementById('holiday-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingHolidayDeleteId = null;
                }
                window.closeHolidayDeleteModal = closeHolidayDeleteModal;

                function confirmHolidayDelete() {
                    if (!pendingHolidayDeleteId) {
                        closeHolidayDeleteModal();
                        return;
                    }
                    var form = document.getElementById('holiday-delete-form');
                    if (!form) {
                        closeHolidayDeleteModal();
                        return;
                    }
                    form.action = holidayDeleteUrlTemplate.replace('__ID__', pendingHolidayDeleteId);
                    closeHolidayDeleteModal();
                    form.submit();
                }
                window.confirmHolidayDelete = confirmHolidayDelete;

                function openHolidayBulkDeleteModal() {
                    var m = document.getElementById('holiday-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openHolidayBulkDeleteModal = openHolidayBulkDeleteModal;

                function closeHolidayBulkDeleteModal() {
                    var m = document.getElementById('holiday-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeHolidayBulkDeleteModal = closeHolidayBulkDeleteModal;

                function confirmHolidayBulkDelete() {
                    var table = document.getElementById('holidays-table');
                    if (!table) {
                        closeHolidayBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.holiday-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.border-b');
                        if (!row) return;
                        var info = row.querySelector('[data-holiday-id]');
                        if (info && info.dataset.holidayId) {
                            ids.push(info.dataset.holidayId);
                        }
                    });

                    if (!ids.length) {
                        closeHolidayBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('holiday-bulk-delete-form');
                    var input = document.getElementById('holiday-bulk-delete-ids');
                    if (!form || !input) {
                        closeHolidayBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeHolidayBulkDeleteModal();
                    form.submit();
                }
                window.confirmHolidayBulkDelete = confirmHolidayBulkDelete;

                function refreshHolidaySelectionState() {
                    var table = document.getElementById('holidays-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('holidays-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.holiday-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('holidays-delete-selected');

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
                    var table = document.getElementById('holidays-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('holidays-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.holiday-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshHolidaySelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        // Don't interfere with header checkbox clicks
                        var headerCheckboxClick = e.target.closest('#holidays-master-checkbox');
                        if (headerCheckboxClick) {
                            return; // Let the change event handler handle it
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.holiday-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.border-b');
                            if (row) openHolidayEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.border-b');
                            if (rowDel) openHolidayDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshHolidaySelectionState();
                        }
                    });

                    refreshHolidaySelectionState();

                    // Reset button handler
                    var searchForm = document.getElementById('holidays-search-form');
                    if (searchForm) {
                        // Find reset button by class (hr-btn-secondary) to avoid selecting date picker buttons
                        var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]');
                        if (resetBtn) {
                            resetBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                // Clear input/select values
                                searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                                    if (el.type === 'date') {
                                        el.value = '';
                                    } else if (el.type === 'text') {
                                        el.value = '';
                                    } else {
                                        el.value = '';
                                    }
                                });
                                // Navigate to base route (no query) so URL is clean
                                window.location.href = '{{ route("leave.holidays") }}';
                            });
                        }
                    }

                    // Scroll to table section if there's a status message (after add/edit/delete)
                    @if(session('status'))
                        setTimeout(function() {
                            var tableSection = document.getElementById('holidays-table-section');
                            if (tableSection) {
                                tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }, 100);
                    @endif
                });
            })();
        </script>
    </x-main-layout>
@endsection
