@extends('layouts.app')

@section('title', 'PIM - Custom Fields')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-custom-fields" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-list-alt text-purple-500"></i> Custom Fields
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button 
                        id="custom-fields-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openCustomFieldBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openCustomFieldAddModal()" />
                </div>
            </div>

            <!-- Table -->
            <div id="custom-fields-table">
            <x-admin.data-table 
                title="" 
                :records="$customFields"
                :columns="[
                    ['label' => 'Custom Field Name', 'sortable' => false],
                    ['label' => 'Screen', 'sortable' => false],
                    ['label' => 'Field Type', 'sortable' => false]
                ]"
                :addButton="false">
                @foreach($customFields as $field)
                <x-admin.table-row>
                    <x-admin.table-cell>
                            <div class="text-xs font-medium text-gray-700"
                                data-custom-field-id="{{ $field->id }}"
                                data-custom-field-name="{{ $field->name }}"
                                data-custom-field-screen="{{ $field->screen }}"
                                data-custom-field-type="{{ $field->field_type }}">
                                {{ $field->name }}
                            </div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $field->screen }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $field->field_type }}</div>
                    </x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
            </div>
        </section>

        <!-- Add Custom Field Modal -->
        <x-admin.modal 
            id="custom-field-add-modal" 
            title="Add Custom Field" 
            icon="fas fa-list-alt" 
            maxWidth="md"
            backdropOnClick="closeCustomFieldAddModal(true)"
        >
            <form method="POST" action="{{ route('pim.configuration.custom-fields.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Custom Field Name<span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="custom-field-add-name" 
                                name="name"
                                class="hr-input px-3 py-1.5 text-xs" 
                                style="background-color: var(--bg-input); color: var(--text-primary);"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Screen
                            </label>
                            <input 
                                type="text" 
                                id="custom-field-add-screen" 
                                name="screen"
                                class="hr-input px-3 py-1.5 text-xs" 
                                placeholder="e.g. pim"
                                style="background-color: var(--bg-input); color: var(--text-primary);"
                            >
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Field Type
                        </label>
                        @if(!empty($dataTypeOptions ?? []))
                            <select 
                                id="custom-field-add-type" 
                                name="field_type"
                                class="hr-select text-xs"
                                style="background-color: var(--bg-input); color: var(--text-primary);"
                            >
                                @foreach($dataTypeOptions as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        @else
                            <input 
                                type="text" 
                                id="custom-field-add-type" 
                                name="field_type"
                                class="hr-input px-3 py-1.5 text-xs" 
                                placeholder="e.g. text"
                                style="background-color: var(--bg-input); color: var(--text-primary);"
                            >
                        @endif
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button 
                        type="button" 
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomFieldAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Custom Field Modal -->
        <x-admin.modal 
            id="custom-field-edit-modal" 
            title="Edit Custom Field" 
            icon="fas fa-edit" 
            maxWidth="md"
            backdropOnClick="closeCustomFieldEditModal(true)"
        >
            <form method="POST" id="custom-field-edit-form" action="#">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Custom Field Name<span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="custom-field-edit-name" 
                            name="name"
                            class="hr-input px-3 py-1.5 text-xs" 
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Screen
                        </label>
                        <input 
                            type="text" 
                            id="custom-field-edit-screen" 
                            name="screen"
                            class="hr-input px-3 py-1.5 text-xs" 
                            placeholder="e.g. pim"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Field Type
                    </label>
                    @if(!empty($dataTypeOptions ?? []))
                        <select 
                            id="custom-field-edit-type" 
                            name="field_type"
                            class="hr-select text-xs"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                            @foreach($dataTypeOptions as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    @else
                        <input 
                            type="text" 
                            id="custom-field-edit-type" 
                            name="field_type"
                            class="hr-input px-3 py-1.5 text-xs" 
                            placeholder="e.g. text"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                        >
                    @endif
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button 
                        type="button" 
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomFieldEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Custom Field Confirm Modal -->
        <x-admin.modal 
            id="custom-field-delete-modal" 
            title="Delete Custom Field" 
            maxWidth="xs"
            backdropOnClick="closeCustomFieldDeleteModal()"
        >
            <div>
                    <p class="text-xs mb-4" style="color: var(--text-muted);">
                        Are you sure you want to delete this custom field?
                    </p>
                    <div class="flex justify-end gap-2">
                        <button 
                            type="button" 
                            class="hr-btn-secondary px-4 py-1.5 text-xs"
                            onclick="closeCustomFieldDeleteModal()"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            class="hr-btn-primary px-4 py-1.5 text-xs"
                            onclick="confirmCustomFieldDelete()"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Custom Fields Confirm Modal -->
        <x-admin.modal 
            id="custom-field-bulk-delete-modal" 
            title="Delete Selected Custom Fields" 
            maxWidth="xs"
            backdropOnClick="closeCustomFieldBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected custom fields?
                </p>
                <div class="flex justify-end gap-2">
                    <button 
                        type="button" 
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomFieldBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmCustomFieldBulkDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Shared Delete Forms -->
        <form id="custom-field-delete-form" method="POST" action="#" class="hidden">
            @csrf
        </form>
        <form id="custom-field-bulk-delete-form" method="POST" action="{{ route('pim.configuration.custom-fields.bulk-delete') }}" class="hidden">
            @csrf
            <input type="hidden" name="ids" id="custom-field-bulk-delete-ids">
        </form>

        <script>
            function openCustomFieldAddModal() {
                var m = document.getElementById('custom-field-add-modal');
                if (!m) return;
                document.getElementById('custom-field-add-name').value = '';
                document.getElementById('custom-field-add-screen').value = '';
                document.getElementById('custom-field-add-type').value = '';
                m.classList.remove('hidden');
            }

            function closeCustomFieldAddModal(reset) {
                var m = document.getElementById('custom-field-add-modal');
                if (!m) return;
                m.classList.add('hidden');
                if (reset) {
                    document.getElementById('custom-field-add-name').value = '';
                    document.getElementById('custom-field-add-screen').value = '';
                    document.getElementById('custom-field-add-type').value = '';
                }
            }

            var customFieldEditUpdateUrlTemplate = "{{ route('pim.configuration.custom-fields.update', ['id' => '__ID__']) }}";
            var customFieldDeleteUrlTemplate = "{{ route('pim.configuration.custom-fields.delete', ['id' => '__ID__']) }}";

            function openCustomFieldEditModalFromRow(row) {
                var info = row.querySelector('[data-custom-field-id]');
                if (!info) return;

                document.getElementById('custom-field-edit-name').value = info.dataset.customFieldName || '';
                document.getElementById('custom-field-edit-screen').value = info.dataset.customFieldScreen || '';
                document.getElementById('custom-field-edit-type').value = info.dataset.customFieldType || '';

                var form = document.getElementById('custom-field-edit-form');
                if (form) {
                    form.action = customFieldEditUpdateUrlTemplate.replace('__ID__', info.dataset.customFieldId);
                }

                var m = document.getElementById('custom-field-edit-modal');
                if (m) m.classList.remove('hidden');
            }

            function closeCustomFieldEditModal(reset) {
                var m = document.getElementById('custom-field-edit-modal');
                if (m) m.classList.add('hidden');
                if (reset) {
                    document.getElementById('custom-field-edit-name').value = '';
                    document.getElementById('custom-field-edit-screen').value = '';
                    document.getElementById('custom-field-edit-type').value = '';
                }
            }

            var pendingCustomFieldDeleteId = null;

            function openCustomFieldDeleteModalFromRow(row) {
                var info = row.querySelector('[data-custom-field-id]');
                if (!info) return;
                pendingCustomFieldDeleteId = info.dataset.customFieldId;
                var m = document.getElementById('custom-field-delete-modal');
                if (m) m.classList.remove('hidden');
            }

            function closeCustomFieldDeleteModal() {
                var m = document.getElementById('custom-field-delete-modal');
                if (m) m.classList.add('hidden');
                pendingCustomFieldDeleteId = null;
            }

            function confirmCustomFieldDelete() {
                if (!pendingCustomFieldDeleteId) {
                    closeCustomFieldDeleteModal();
                    return;
                }
                var form = document.getElementById('custom-field-delete-form');
                if (!form) {
                    closeCustomFieldDeleteModal();
                    return;
                }
                form.action = customFieldDeleteUrlTemplate.replace('__ID__', pendingCustomFieldDeleteId);
                closeCustomFieldDeleteModal();
                form.submit();
            }

            function openCustomFieldBulkDeleteModal() {
                var m = document.getElementById('custom-field-bulk-delete-modal');
                if (m) m.classList.remove('hidden');
            }

            function closeCustomFieldBulkDeleteModal() {
                var m = document.getElementById('custom-field-bulk-delete-modal');
                if (m) m.classList.add('hidden');
            }

            function confirmCustomFieldBulkDelete() {
                var table = document.getElementById('custom-fields-table');
                if (!table) {
                    closeCustomFieldBulkDeleteModal();
                    return;
                }
                var checked = table.querySelectorAll('.custom-field-row-checkbox:checked');
                var ids = [];
                checked.forEach(function (cb) {
                    var row = cb.closest('.border-b');
                    if (!row) return;
                    var info = row.querySelector('[data-custom-field-id]');
                    if (info && info.dataset.customFieldId) {
                        ids.push(info.dataset.customFieldId);
                    }
                });

                if (!ids.length) {
                    closeCustomFieldBulkDeleteModal();
                    return;
                }

                var form = document.getElementById('custom-field-bulk-delete-form');
                var input = document.getElementById('custom-field-bulk-delete-ids');
                if (!form || !input) {
                    closeCustomFieldBulkDeleteModal();
                    return;
                }

                input.value = ids.join(',');
                closeCustomFieldBulkDeleteModal();
                form.submit();
            }

            function refreshCustomFieldSelectionState() {
                var table = document.getElementById('custom-fields-table');
                if (!table) return;

                var headerCheckbox = document.getElementById('custom-fields-master-checkbox');
                var rowCheckboxes = table.querySelectorAll('.custom-field-row-checkbox');
                var deleteSelectedBtn = document.getElementById('custom-fields-delete-selected');

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

            // Attach handlers to existing action buttons inside this table only
            document.addEventListener('DOMContentLoaded', function () {
                var table = document.getElementById('custom-fields-table');
                if (!table) return;

                function setupCheckboxes() {
                    // Add ID to header checkbox and class to row checkboxes (matching reporting-methods pattern)
                    var headerCheckbox = table.querySelector('.hr-table-wrapper > div input[type="checkbox"]');
                    if (!headerCheckbox) {
                        // Retry after a short delay if checkbox not found yet
                        setTimeout(setupCheckboxes, 50);
                        return;
                    }

                    if (!headerCheckbox.id) {
                        headerCheckbox.id = 'custom-fields-master-checkbox';
                    }

                    var rowCheckboxes = table.querySelectorAll('.hr-table-wrapper .border-b input[type="checkbox"]');
                    rowCheckboxes.forEach(function (cb) {
                        if (!cb.classList.contains('custom-field-row-checkbox')) {
                            cb.classList.add('custom-field-row-checkbox');
                        }
                    });

                    // Attach header checkbox change handler - when header clicked, check/uncheck all rows
                    var masterCheckbox = document.getElementById('custom-fields-master-checkbox');
                    if (masterCheckbox && !masterCheckbox.dataset.listenerAttached) {
                        masterCheckbox.dataset.listenerAttached = 'true';
                        masterCheckbox.addEventListener('change', function () {
                            // When header checkbox is clicked → check/uncheck all rows
                            var allRowCheckboxes = table.querySelectorAll('.custom-field-row-checkbox');
                            allRowCheckboxes.forEach(function (cb) {
                                cb.checked = masterCheckbox.checked;
                            });
                            refreshCustomFieldSelectionState();
                        });
                    }
                }

                setupCheckboxes();

                table.addEventListener('click', function (e) {
                    // Don't interfere with header checkbox clicks
                    var headerCheckboxClick = e.target.closest('#custom-fields-master-checkbox');
                    if (headerCheckboxClick) {
                        return; // Let the change event handler handle it
                    }

                    var editBtn = e.target.closest('.hr-action-edit');
                    var deleteBtn = e.target.closest('.hr-action-delete');
                    var rowCheckbox = e.target.closest('.custom-field-row-checkbox');

                    if (editBtn) {
                        var row = e.target.closest('.border-b');
                        if (row) openCustomFieldEditModalFromRow(row);
                        return;
                    }

                    if (deleteBtn) {
                        var rowDel = e.target.closest('.border-b');
                        if (rowDel) openCustomFieldDeleteModalFromRow(rowDel);
                        return;
                    }

                    if (rowCheckbox) {
                        refreshCustomFieldSelectionState();
                    }
                });

                refreshCustomFieldSelectionState();
            });
        </script>
    </x-main-layout>
@endsection
