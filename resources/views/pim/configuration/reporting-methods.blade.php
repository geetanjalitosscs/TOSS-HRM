@extends('layouts.app')

@section('title', 'PIM - Reporting Methods')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-reporting-methods" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-purple-500"></i> Reporting Methods
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="reporting-methods-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openReportingMethodBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openReportingMethodAddModal()" />
                </div>
            </div>

            @if(isset($reportingMethods) && count($reportingMethods) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($reportingMethods)" />
            @endif

            <!-- Table -->
            <div id="reporting-methods-table">
                <div class="hr-table-wrapper">
                    <!-- Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="reporting-methods-master-checkbox"
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
                        @if(!empty($reportingEnumMeta))
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                     style="color: var(--text-primary);">
                                    {{ \Illuminate\Support\Str::headline($reportingEnumMeta['field']) }}
                                </div>
                            </div>
                        @endif
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
                        @forelse($reportingMethods as $method)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="reporting-method-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-reporting-id="{{ $method->id }}"
                                         data-reporting-name="{{ $method->name }}"
                                         data-reporting-description="{{ $method->description ?? '' }}"
                                         @if(!empty($reportingEnumMeta))
                                             data-reporting-enum="{{ $method->{$reportingEnumMeta['field']} ?? '' }}"
                                         @endif
                                    >
                                        {{ $method->name }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $method->description ?? '-' }}
                                    </div>
                                </div>
                                @if(!empty($reportingEnumMeta))
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ $method->{$reportingEnumMeta['field']} ?? '-' }}
                                        </div>
                                    </div>
                                @endif
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
                                No reporting methods found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Reporting Method Modal -->
        <x-admin.modal
            id="reporting-method-add-modal"
            title="Add Reporting Method"
            icon="fas fa-chart-line"
            maxWidth="md"
            backdropOnClick="closeReportingMethodAddModal(true)"
        >
            <form method="POST" action="{{ route('pim.configuration.reporting-methods.store') }}">
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

                @if(!empty($reportingEnumMeta))
                    <div class="mb-4">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            {{ \Illuminate\Support\Str::headline($reportingEnumMeta['field']) }}
                        </label>
                        <select
                            name="{{ $reportingEnumMeta['field'] }}"
                            class="hr-select text-xs"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                            @foreach($reportingEnumMeta['options'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportingMethodAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Reporting Method Modal -->
        <x-admin.modal
            id="reporting-method-edit-modal"
            title="Edit Reporting Method"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeReportingMethodEditModal(true)"
        >
            <form method="POST" id="reporting-method-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="reporting-method-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        type="text"
                        name="description"
                        id="reporting-method-edit-description"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>

                @if(!empty($reportingEnumMeta))
                    <div class="mb-4">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            {{ \Illuminate\Support\Str::headline($reportingEnumMeta['field']) }}
                        </label>
                        <select
                            name="{{ $reportingEnumMeta['field'] }}"
                            id="reporting-method-edit-enum"
                            class="hr-select text-xs"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                            @foreach($reportingEnumMeta['options'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportingMethodEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Reporting Method Modal -->
        <x-admin.modal
            id="reporting-method-delete-modal"
            title="Delete Reporting Method"
            maxWidth="xs"
            backdropOnClick="closeReportingMethodDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this reporting method?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportingMethodDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmReportingMethodDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Reporting Methods Modal -->
        <x-admin.modal
            id="reporting-method-bulk-delete-modal"
            title="Delete Selected Reporting Methods"
            maxWidth="xs"
            backdropOnClick="closeReportingMethodBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected reporting methods?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportingMethodBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmReportingMethodBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="reporting-method-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="reporting-method-bulk-delete-form" method="POST" action="{{ route('pim.configuration.reporting-methods.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="reporting-method-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var reportingMethodEditUrlTemplate = "{{ route('pim.configuration.reporting-methods.update', ['id' => '__ID__']) }}";
                var reportingMethodDeleteUrlTemplate = "{{ route('pim.configuration.reporting-methods.delete', ['id' => '__ID__']) }}";

                var pendingReportingMethodDeleteId = null;

                function openReportingMethodAddModal() {
                    var m = document.getElementById('reporting-method-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openReportingMethodAddModal = openReportingMethodAddModal;

                function closeReportingMethodAddModal(reset) {
                    var m = document.getElementById('reporting-method-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeReportingMethodAddModal = closeReportingMethodAddModal;

                function openReportingMethodEditModalFromRow(row) {
                    var info = row.querySelector('[data-reporting-id]');
                    if (!info) return;

                    var id = info.dataset.reportingId;
                    var name = info.dataset.reportingName || '';
                    var description = info.dataset.reportingDescription || '';
                    var enumValue = info.dataset.reportingEnum || '';

                    var m = document.getElementById('reporting-method-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('reporting-method-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('reporting-method-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var enumSelect = document.getElementById('reporting-method-edit-enum');
                    if (enumSelect) {
                        enumSelect.value = enumValue || '';
                    }

                    var form = document.getElementById('reporting-method-edit-form');
                    if (form) {
                        form.action = reportingMethodEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }

                function closeReportingMethodEditModal(reset) {
                    var m = document.getElementById('reporting-method-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeReportingMethodEditModal = closeReportingMethodEditModal;

                function openReportingMethodDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-reporting-id]');
                    if (!info) return;
                    pendingReportingMethodDeleteId = info.dataset.reportingId || null;
                    var m = document.getElementById('reporting-method-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeReportingMethodDeleteModal() {
                    var m = document.getElementById('reporting-method-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingReportingMethodDeleteId = null;
                }
                window.closeReportingMethodDeleteModal = closeReportingMethodDeleteModal;

                function confirmReportingMethodDelete() {
                    if (!pendingReportingMethodDeleteId) {
                        closeReportingMethodDeleteModal();
                        return;
                    }
                    var form = document.getElementById('reporting-method-delete-form');
                    if (!form) {
                        closeReportingMethodDeleteModal();
                        return;
                    }
                    form.action = reportingMethodDeleteUrlTemplate.replace('__ID__', pendingReportingMethodDeleteId);
                    closeReportingMethodDeleteModal();
                    form.submit();
                }
                window.confirmReportingMethodDelete = confirmReportingMethodDelete;

                function openReportingMethodBulkDeleteModal() {
                    var m = document.getElementById('reporting-method-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openReportingMethodBulkDeleteModal = openReportingMethodBulkDeleteModal;

                function closeReportingMethodBulkDeleteModal() {
                    var m = document.getElementById('reporting-method-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeReportingMethodBulkDeleteModal = closeReportingMethodBulkDeleteModal;

                function confirmReportingMethodBulkDelete() {
                    var table = document.getElementById('reporting-methods-table');
                    if (!table) {
                        closeReportingMethodBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.border-b input[type="checkbox"]:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.border-b');
                        if (!row) return;
                        var info = row.querySelector('[data-reporting-id]');
                        if (info && info.dataset.reportingId) {
                            ids.push(info.dataset.reportingId);
                        }
                    });

                    if (!ids.length) {
                        closeReportingMethodBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('reporting-method-bulk-delete-form');
                    var input = document.getElementById('reporting-method-bulk-delete-ids');
                    if (!form || !input) {
                        closeReportingMethodBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeReportingMethodBulkDeleteModal();
                    form.submit();
                }
                window.confirmReportingMethodBulkDelete = confirmReportingMethodBulkDelete;

                function refreshReportingMethodSelectionState() {
                    var table = document.getElementById('reporting-methods-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('reporting-methods-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.reporting-method-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('reporting-methods-delete-selected');

                    var checkedCount = 0;
                    rowCheckboxes.forEach(function (cb) {
                        if (cb.checked) checkedCount++;
                    });

                    // Show "Delete Selected" button only when at least 1 row is checked
                    if (deleteSelectedBtn) {
                        deleteSelectedBtn.classList.toggle('hidden', checkedCount === 0);
                    }

                    // Header checkbox: checked only when ALL rows are checked, otherwise empty (no "-")
                    if (headerCheckbox) {
                        if (rowCheckboxes.length === 0 || checkedCount === 0) {
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
                    var table = document.getElementById('reporting-methods-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('reporting-methods-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.reporting-method-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshReportingMethodSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.reporting-method-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.border-b');
                            if (row) openReportingMethodEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.border-b');
                            if (rowDel) openReportingMethodDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshReportingMethodSelectionState();
                        }
                    });

                    refreshReportingMethodSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
