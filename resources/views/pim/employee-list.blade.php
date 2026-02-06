@extends('layouts.app')

@section('title', 'PIM - Employee List')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="employee-list" />

        <div class="space-y-6">
            <!-- Employee Information Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-[var(--color-primary)]"></i> Employee Information
                </h2>
                <form method="GET" action="{{ route('pim.employee-list') }}#employee-list-section" id="employee-search-form">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                            <input 
                                type="text" 
                                name="employee_name"
                                value="{{ request('employee_name') }}"
                                class="hr-input w-full px-2 py-1.5 text-xs border bordtext-[var(--color-primary)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                            <input 
                                type="text" 
                                name="employee_id"
                                value="{{ request('employee_id') }}"
                                class="hr-input w-full px-2 py-1.5 text-xs border bordtext-[var(--color-primary)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                placeholder="">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employment Status</label>
                            <select 
                                name="employment_status"
                                class="hr-select w-full px-2 py-1.5 text-xs border bordtext-[var(--color-primary)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option value="">-- Select --</option>
                                @foreach($employmentStatuses ?? [] as $status)
                                    <option value="{{ $status->id }}" {{ request('employment_status') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Include</label>
                            <select 
                                name="include"
                                class="hr-select w-full px-2 py-1.5 text-xs border bordtext-[var(--color-primary)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option value="current" {{ request('include', 'current') == 'current' ? 'selected' : '' }}>Current Employees Only</option>
                                <option value="past" {{ request('include') == 'past' ? 'selected' : '' }}>Past Employees Only</option>
                                <option value="all" {{ request('include') == 'all' ? 'selected' : '' }}>All Employees</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                            <select 
                                name="job_title"
                                class="hr-select w-full px-2 py-1.5 text-xs border bordtext-[var(--color-primary)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option value="">-- Select --</option>
                                @foreach($jobTitles ?? [] as $title)
                                    <option value="{{ $title->id }}" {{ request('job_title') == $title->id ? 'selected' : '' }}>
                                        {{ $title->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <x-admin.action-buttons resetType="button" searchType="submit" />
                </form>
            </section>

            <!-- Employee List Card -->
            <section id="employee-list-section" class="hr-card p-6">
                <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-[var(--color-primary)]"></i> Employee List
                    </h2>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="employees-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openEmployeeBulkDeleteModal()"
                        >
                            Delete Selected
                        </button>
                        <a
                            href="{{ route('pim.add-employee') }}"
                            class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-[var(--color-primary-light)] transition-all flex items-center gap-1 shadow-md hover:scale-105 transform"
                            style="transform-origin: center; position: relative; z-index: 10;"
                        >
                            + Add
                        </a>
                    </div>
                </div>

                @if(isset($employees) && count($employees) > 0)
                    <!-- Records Count -->
                    <x-records-found :count="count($employees)" />
                @endif

                <!-- Table -->
                <div id="employees-table">
                    <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                        <!-- Header -->
                        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                             style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox"
                                       id="employees-master-checkbox"
                                       class="rounded w-3.5 h-3.5"
                                       style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                     style="color: var(--text-primary);">
                                    ID
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                     style="color: var(--text-primary);">
                                    First (& Middle) Name
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                     style="color: var(--text-primary);">
                                    Last Name
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
                                    Employment Status
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
                            @forelse($employees as $employee)
                                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                     style="background-color: var(--bg-card); border-color: var(--border-default);">
                                    <div class="flex-shrink-0" style="width: 24px;">
                                        <input type="checkbox"
                                               class="employee-row-checkbox rounded w-3.5 h-3.5"
                                               style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-medium break-words"
                                             style="color: var(--text-primary);"
                                             data-employee-id="{{ $employee->id }}"
                                             data-employee-number="{{ $employee->employee_number }}"
                                             data-employee-first-name="{{ $employee->first_name }}"
                                             data-employee-last-name="{{ $employee->last_name }}"
                                             data-employee-job-title-id="{{ $employee->job_title_id ?? '' }}"
                                             data-employee-employment-status-id="{{ $employee->employment_status_id ?? '' }}"
                                        >
                                            {{ $employee->employee_number }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ $employee->first_name }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ $employee->last_name }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ $employee->job_title ?: '-' }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ $employee->employment_status ?: '-' }}
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 80px;">
                                        <div class="flex items-center justify-center gap-2">
                                            <a
                                                class="hr-action-edit flex-shrink-0"
                                                title="Edit"
                                                href="{{ route('pim.add-employee.edit', $employee->id) }}"
                                            >
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <button class="hr-action-delete flex-shrink-0" title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                    No employees found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Delete Employee Modal -->
        <x-admin.modal
            id="employee-delete-modal"
            title="Delete Employee"
            maxWidth="xs"
            backdropOnClick="closeEmployeeDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this employee?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEmployeeDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmEmployeeDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Employees Modal -->
        <x-admin.modal
            id="employee-bulk-delete-modal"
            title="Delete Selected Employees"
            maxWidth="xs"
            backdropOnClick="closeEmployeeBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected employees?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEmployeeBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmEmployeeBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="employee-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="employee-bulk-delete-form" method="POST" action="{{ route('pim.employee-list.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="employee-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var employeeDeleteUrlTemplate = "{{ route('pim.employee-list.delete', ['id' => '__ID__']) }}";

                var pendingEmployeeDeleteId = null;

                function openEmployeeDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-employee-id]');
                    if (!info) return;
                    pendingEmployeeDeleteId = info.dataset.employeeId || null;
                    var m = document.getElementById('employee-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeEmployeeDeleteModal() {
                    var m = document.getElementById('employee-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingEmployeeDeleteId = null;
                }
                window.closeEmployeeDeleteModal = closeEmployeeDeleteModal;

                function confirmEmployeeDelete() {
                    if (!pendingEmployeeDeleteId) {
                        closeEmployeeDeleteModal();
                        return;
                    }
                    var form = document.getElementById('employee-delete-form');
                    if (!form) {
                        closeEmployeeDeleteModal();
                        return;
                    }
                    form.action = employeeDeleteUrlTemplate.replace('__ID__', pendingEmployeeDeleteId);
                    closeEmployeeDeleteModal();
                    form.submit();
                }
                window.confirmEmployeeDelete = confirmEmployeeDelete;

                function openEmployeeBulkDeleteModal() {
                    var m = document.getElementById('employee-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEmployeeBulkDeleteModal = openEmployeeBulkDeleteModal;

                function closeEmployeeBulkDeleteModal() {
                    var m = document.getElementById('employee-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeEmployeeBulkDeleteModal = closeEmployeeBulkDeleteModal;

                function confirmEmployeeBulkDelete() {
                    var table = document.getElementById('employees-table');
                    if (!table) {
                        closeEmployeeBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.employee-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.border-b');
                        if (!row) return;
                        var info = row.querySelector('[data-employee-id]');
                        if (info && info.dataset.employeeId) {
                            ids.push(info.dataset.employeeId);
                        }
                    });

                    if (!ids.length) {
                        closeEmployeeBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('employee-bulk-delete-form');
                    var input = document.getElementById('employee-bulk-delete-ids');
                    if (!form || !input) {
                        closeEmployeeBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeEmployeeBulkDeleteModal();
                    form.submit();
                }
                window.confirmEmployeeBulkDelete = confirmEmployeeBulkDelete;

                function refreshEmployeeSelectionState() {
                    var table = document.getElementById('employees-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('employees-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.employee-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('employees-delete-selected');

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
                    // Reset button: clear all filters and reload base employee list
                    var searchForm = document.getElementById('employee-search-form');
                    if (searchForm) {
                        var resetBtn = searchForm.querySelector('button[type="button"]');
                        if (resetBtn) {
                            resetBtn.addEventListener('click', function () {
                                // Clear input/select values
                                searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                                    if (el.tagName === 'SELECT') {
                                        if (el.name === 'include') {
                                            el.value = 'current';
                                        } else {
                                            el.value = '';
                                        }
                                    } else {
                                        el.value = '';
                                    }
                                });
                                // Navigate to base route (no query) so URL is clean
                                window.location.href = "{{ route('pim.employee-list') }}";
                            });
                        }
                    }

                    var table = document.getElementById('employees-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('employees-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.employee-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshEmployeeSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        // Don't interfere with header checkbox clicks
                        var headerCheckboxClick = e.target.closest('#employees-master-checkbox');
                        if (headerCheckboxClick) {
                            return; // Let the change event handler handle it
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.employee-row-checkbox');

                        if (editBtn) {
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.border-b');
                            if (rowDel) openEmployeeDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshEmployeeSelectionState();
                        }
                    });

                    refreshEmployeeSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
