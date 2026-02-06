@extends('layouts.app')

@section('title', 'Admin - Employment Status')

@section('body')
    <x-main-layout title="Admin">
        <x-admin.tabs activeTab="employment-status" />

        <!-- Employment Status Section -->
        <section id="employment-status-table-section" class="hr-card p-6">
            <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-check text-[var(--color-primary)]"></i> Employment Status
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="employment-status-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openEmploymentStatusBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openEmploymentStatusAddModal()" />
                </div>
            </div>

            @if(isset($statuses) && count($statuses) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($statuses)" />
            @endif

            <!-- Table -->
            <div id="employment-status-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="employment-status-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
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

                    <!-- Table Rows -->
                    <div class="border border-t-0 rounded-b-lg"
                         style="border-color: var(--border-default);">
                        @forelse($statuses as $status)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);"
                                 onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                 onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="employment-status-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-employment-status-id="{{ $status->id }}"
                                         data-employment-status-name="{{ $status->name }}"
                                    >
                                        {{ $status->name }}
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
                                No employment statuses found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Employment Status Modal -->
        <x-admin.modal
            id="employment-status-add-modal"
            title="Add Employment Status"
            icon="fas fa-user-check"
            maxWidth="md"
            backdropOnClick="closeEmploymentStatusAddModal(true)"
        >
            <form method="POST" action="{{ route('admin.employment-status.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employment Status <span class="text-red-500">*</span>
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

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEmploymentStatusAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Employment Status Modal -->
        <x-admin.modal
            id="employment-status-edit-modal"
            title="Edit Employment Status"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeEmploymentStatusEditModal(true)"
        >
            <form method="POST" id="employment-status-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employment Status <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="employment-status-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEmploymentStatusEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Employment Status Modal -->
        <x-admin.modal
            id="employment-status-delete-modal"
            title="Delete Employment Status"
            maxWidth="xs"
            backdropOnClick="closeEmploymentStatusDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this employment status?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEmploymentStatusDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmEmploymentStatusDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Employment Status Modal -->
        <x-admin.modal
            id="employment-status-bulk-delete-modal"
            title="Delete Selected Employment Statuses"
            maxWidth="xs"
            backdropOnClick="closeEmploymentStatusBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected employment statuses?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEmploymentStatusBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmEmploymentStatusBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="employment-status-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="employment-status-bulk-delete-form" method="POST" action="{{ route('admin.employment-status.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="employment-status-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var employmentStatusEditUrlTemplate = "{{ route('admin.employment-status.update', ['id' => '__ID__']) }}";
                var employmentStatusDeleteUrlTemplate = "{{ route('admin.employment-status.delete', ['id' => '__ID__']) }}";

                var pendingEmploymentStatusDeleteId = null;

                function openEmploymentStatusAddModal() {
                    var m = document.getElementById('employment-status-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEmploymentStatusAddModal = openEmploymentStatusAddModal;

                function closeEmploymentStatusAddModal(reset) {
                    var m = document.getElementById('employment-status-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeEmploymentStatusAddModal = closeEmploymentStatusAddModal;

                function openEmploymentStatusEditModalFromRow(row) {
                    var info = row.querySelector('[data-employment-status-id]');
                    if (!info) return;

                    var id = info.dataset.employmentStatusId;
                    var name = info.dataset.employmentStatusName || '';

                    var m = document.getElementById('employment-status-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('employment-status-edit-name');
                    if (nameInput) nameInput.value = name;

                    var form = document.getElementById('employment-status-edit-form');
                    if (form) {
                        form.action = employmentStatusEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openEmploymentStatusEditModalFromRow = openEmploymentStatusEditModalFromRow;

                function closeEmploymentStatusEditModal(reset) {
                    var m = document.getElementById('employment-status-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeEmploymentStatusEditModal = closeEmploymentStatusEditModal;

                function openEmploymentStatusDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-employment-status-id]');
                    if (!info) return;
                    pendingEmploymentStatusDeleteId = info.dataset.employmentStatusId || null;
                    var m = document.getElementById('employment-status-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEmploymentStatusDeleteModalFromRow = openEmploymentStatusDeleteModalFromRow;

                function closeEmploymentStatusDeleteModal() {
                    var m = document.getElementById('employment-status-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingEmploymentStatusDeleteId = null;
                }
                window.closeEmploymentStatusDeleteModal = closeEmploymentStatusDeleteModal;

                function confirmEmploymentStatusDelete() {
                    if (!pendingEmploymentStatusDeleteId) {
                        closeEmploymentStatusDeleteModal();
                        return;
                    }
                    var form = document.getElementById('employment-status-delete-form');
                    if (!form) {
                        closeEmploymentStatusDeleteModal();
                        return;
                    }
                    form.action = employmentStatusDeleteUrlTemplate.replace('__ID__', pendingEmploymentStatusDeleteId);
                    closeEmploymentStatusDeleteModal();
                    form.submit();
                }
                window.confirmEmploymentStatusDelete = confirmEmploymentStatusDelete;

                function openEmploymentStatusBulkDeleteModal() {
                    var m = document.getElementById('employment-status-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEmploymentStatusBulkDeleteModal = openEmploymentStatusBulkDeleteModal;

                function closeEmploymentStatusBulkDeleteModal() {
                    var m = document.getElementById('employment-status-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeEmploymentStatusBulkDeleteModal = closeEmploymentStatusBulkDeleteModal;

                function confirmEmploymentStatusBulkDelete() {
                    var table = document.getElementById('employment-status-table');
                    if (!table) {
                        closeEmploymentStatusBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.employment-status-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.hr-table-row');
                        if (!row) return;
                        var info = row.querySelector('[data-employment-status-id]');
                        if (info && info.dataset.employmentStatusId) {
                            ids.push(info.dataset.employmentStatusId);
                        }
                    });

                    if (!ids.length) {
                        closeEmploymentStatusBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('employment-status-bulk-delete-form');
                    var input = document.getElementById('employment-status-bulk-delete-ids');
                    if (!form || !input) {
                        closeEmploymentStatusBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeEmploymentStatusBulkDeleteModal();
                    form.submit();
                }
                window.confirmEmploymentStatusBulkDelete = confirmEmploymentStatusBulkDelete;

                function refreshEmploymentStatusSelectionState() {
                    var table = document.getElementById('employment-status-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('employment-status-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.employment-status-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('employment-status-delete-selected');

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

                document.addEventListener('DOMContentLoaded', function () {
                    var table = document.getElementById('employment-status-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('employment-status-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.employment-status-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshEmploymentStatusSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#employment-status-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.employment-status-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openEmploymentStatusEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openEmploymentStatusDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshEmploymentStatusSelectionState();
                        }
                    });

                    refreshEmploymentStatusSelectionState();

                    // Scroll to table section if status message exists
                    @if(session('status'))
                        var tableSection = document.getElementById('employment-status-table-section');
                        if (tableSection) {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    @endif
                });
            })();
        </script>
    </x-main-layout>
@endsection
