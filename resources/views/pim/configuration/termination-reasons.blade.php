@extends('layouts.app')

@section('title', 'PIM - Termination Reasons')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-termination-reasons" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-ban text-[var(--color-primary)]"></i> Termination Reasons
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="termination-reasons-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openTerminationReasonBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openTerminationReasonAddModal()" />
                </div>
            </div>

            @if(isset($terminationReasons) && count($terminationReasons) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($terminationReasons)" />
            @endif

            <!-- Table -->
            <div id="termination-reasons-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="termination-reasons-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Name
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Description
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
                        @forelse($terminationReasons as $reason)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="termination-reason-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-termination-id="{{ $reason->id }}"
                                         data-termination-name="{{ $reason->name }}"
                                         data-termination-description="{{ $reason->description ?? '' }}"
                                    >
                                        {{ $reason->name }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $reason->description ?? '-' }}
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
                                No termination reasons found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Termination Reason Modal -->
        <x-admin.modal
            id="termination-reason-add-modal"
            title="Add Termination Reason"
            icon="fas fa-ban"
            maxWidth="md"
            backdropOnClick="closeTerminationReasonAddModal(true)"
        >
            <form method="POST" action="{{ route('pim.configuration.termination-reasons.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-[var(--color-primary)]">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        type="text"
                        name="description"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeTerminationReasonAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Termination Reason Modal -->
        <x-admin.modal
            id="termination-reason-edit-modal"
            title="Edit Termination Reason"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeTerminationReasonEditModal(true)"
        >
            <form method="POST" id="termination-reason-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-[var(--color-primary)]">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="termination-reason-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        type="text"
                        name="description"
                        id="termination-reason-edit-description"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeTerminationReasonEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Termination Reason Modal -->
        <x-admin.modal
            id="termination-reason-delete-modal"
            title="Delete Termination Reason"
            maxWidth="xs"
            backdropOnClick="closeTerminationReasonDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this termination reason?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeTerminationReasonDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmTerminationReasonDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Termination Reasons Modal -->
        <x-admin.modal
            id="termination-reason-bulk-delete-modal"
            title="Delete Selected Termination Reasons"
            maxWidth="xs"
            backdropOnClick="closeTerminationReasonBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected termination reasons?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeTerminationReasonBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmTerminationReasonBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="termination-reason-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="termination-reason-bulk-delete-form" method="POST" action="{{ route('pim.configuration.termination-reasons.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="termination-reason-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var terminationReasonEditUrlTemplate = "{{ route('pim.configuration.termination-reasons.update', ['id' => '__ID__']) }}";
                var terminationReasonDeleteUrlTemplate = "{{ route('pim.configuration.termination-reasons.delete', ['id' => '__ID__']) }}";

                var pendingTerminationReasonDeleteId = null;

                function openTerminationReasonAddModal() {
                    var m = document.getElementById('termination-reason-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openTerminationReasonAddModal = openTerminationReasonAddModal;

                function closeTerminationReasonAddModal(reset) {
                    var m = document.getElementById('termination-reason-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeTerminationReasonAddModal = closeTerminationReasonAddModal;

                function openTerminationReasonEditModalFromRow(row) {
                    var info = row.querySelector('[data-termination-id]');
                    if (!info) return;

                    var id = info.dataset.terminationId;
                    var name = info.dataset.terminationName || '';
                    var description = info.dataset.terminationDescription || '';

                    var m = document.getElementById('termination-reason-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('termination-reason-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('termination-reason-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var form = document.getElementById('termination-reason-edit-form');
                    if (form) {
                        form.action = terminationReasonEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }

                function closeTerminationReasonEditModal(reset) {
                    var m = document.getElementById('termination-reason-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeTerminationReasonEditModal = closeTerminationReasonEditModal;

                function openTerminationReasonDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-termination-id]');
                    if (!info) return;
                    pendingTerminationReasonDeleteId = info.dataset.terminationId || null;
                    var m = document.getElementById('termination-reason-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeTerminationReasonDeleteModal() {
                    var m = document.getElementById('termination-reason-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingTerminationReasonDeleteId = null;
                }
                window.closeTerminationReasonDeleteModal = closeTerminationReasonDeleteModal;

                function confirmTerminationReasonDelete() {
                    if (!pendingTerminationReasonDeleteId) {
                        closeTerminationReasonDeleteModal();
                        return;
                    }
                    var form = document.getElementById('termination-reason-delete-form');
                    if (!form) {
                        closeTerminationReasonDeleteModal();
                        return;
                    }
                    form.action = terminationReasonDeleteUrlTemplate.replace('__ID__', pendingTerminationReasonDeleteId);
                    closeTerminationReasonDeleteModal();
                    form.submit();
                }
                window.confirmTerminationReasonDelete = confirmTerminationReasonDelete;

                function openTerminationReasonBulkDeleteModal() {
                    var m = document.getElementById('termination-reason-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openTerminationReasonBulkDeleteModal = openTerminationReasonBulkDeleteModal;

                function closeTerminationReasonBulkDeleteModal() {
                    var m = document.getElementById('termination-reason-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeTerminationReasonBulkDeleteModal = closeTerminationReasonBulkDeleteModal;

                function confirmTerminationReasonBulkDelete() {
                    var table = document.getElementById('termination-reasons-table');
                    if (!table) {
                        closeTerminationReasonBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.termination-reason-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.border-b');
                        if (!row) return;
                        var info = row.querySelector('[data-termination-id]');
                        if (info && info.dataset.terminationId) {
                            ids.push(info.dataset.terminationId);
                        }
                    });

                    if (!ids.length) {
                        closeTerminationReasonBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('termination-reason-bulk-delete-form');
                    var input = document.getElementById('termination-reason-bulk-delete-ids');
                    if (!form || !input) {
                        closeTerminationReasonBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeTerminationReasonBulkDeleteModal();
                    form.submit();
                }
                window.confirmTerminationReasonBulkDelete = confirmTerminationReasonBulkDelete;

                function refreshTerminationReasonSelectionState() {
                    var table = document.getElementById('termination-reasons-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('termination-reasons-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.termination-reason-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('termination-reasons-delete-selected');

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
                    var table = document.getElementById('termination-reasons-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('termination-reasons-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.termination-reason-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshTerminationReasonSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        // Don't interfere with header checkbox clicks
                        var headerCheckboxClick = e.target.closest('#termination-reasons-master-checkbox');
                        if (headerCheckboxClick) {
                            return; // Let the change event handler handle it
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.termination-reason-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.border-b');
                            if (row) openTerminationReasonEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.border-b');
                            if (rowDel) openTerminationReasonDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshTerminationReasonSelectionState();
                        }
                    });

                    refreshTerminationReasonSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
