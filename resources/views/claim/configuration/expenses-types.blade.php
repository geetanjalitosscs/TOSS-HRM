@extends('layouts.app')

@section('title', 'Claim - Configuration - Expense Types')

@section('body')
    <x-main-layout title="Claim">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible flex-nowrap" style="border-color: var(--border-default);">
                <div class="relative group" onclick="toggleDropdown(event)" style="overflow: visible;">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center justify-between gap-2" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <span class="text-sm font-medium" style="color: var(--text-primary);">Configuration</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                    <div class="hr-dropdown-menu absolute top-full left-0 mt-0 w-48" style="z-index: 9999; display: none; background-color: var(--bg-card); border: 1px solid var(--border-default); border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding: 0.5rem 0;">
                        <a href="{{ route('claim.configuration.events') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                            Events
                        </a>
                        <a href="{{ route('claim.configuration.expenses-types') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary); background-color: var(--bg-hover);">
                            Expenses Types
                        </a>
                    </div>
                </div>
                <a href="{{ route('claim.submit') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Submit Claim</span>
                </a>
                <a href="{{ route('claim.my-claims') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">My Claims</span>
                </a>
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- Expense Types Configuration Section -->
        <div>
            <section class="hr-card p-6 mb-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-list-alt" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Expense Types</span>
                </h2>

                <!-- Search/Filter Section -->
                <form method="GET" action="{{ route('claim.configuration.expenses-types') }}" id="expense-types-search-form">
                    <x-admin.search-panel title="" :collapsed="false" :collapsible="false">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Name</label>
                                <input 
                                    type="text" 
                                    name="name"
                                    value="{{ request('name') }}"
                                    class="hr-input w-full px-3 py-1.5 text-xs" 
                                    style="background-color: var(--bg-input); color: var(--text-primary);"
                                    placeholder="Type for hints..."
                                >
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Status</label>
                                <select 
                                    name="status"
                                    class="hr-select w-full px-3 py-1.5 text-xs" 
                                    style="background-color: var(--bg-input); color: var(--text-primary);"
                                >
                                    <option value="">-- Select --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" />
                    </x-admin.search-panel>
                </form>
            </section>

            <!-- Expense Types Table Section -->
            <section id="expense-types-table-section" class="hr-card p-6">
                @if(session('status'))
                    <div class="mb-4 px-3 py-2 rounded border text-xs" style="background-color: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.3); color: rgb(22, 163, 74);">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-list-alt text-[var(--color-primary)]"></i> Expense Types
                    </h2>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="expense-types-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openExpenseTypeBulkDeleteModal()"
                        >
                            Delete Selected
                        </button>
                        <x-admin.add-button class="mb-0" onClick="openExpenseTypeAddModal()" />
                    </div>
                </div>

                @if(isset($expenseTypes) && count($expenseTypes) > 0)
                    <!-- Records Count -->
                    <x-records-found :count="count($expenseTypes)" />
                @endif

                <!-- Table Wrapper -->
                <div id="expense-types-table">
                    <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                        <!-- Table Header -->
                        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" id="expense-types-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                                    Name
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                                    Description
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                                    Status
                                </div>
                            </div>
                            <div class="flex-shrink-0" style="width: 80px;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                            </div>
                        </div>

                        <!-- Expense Types List -->
                        <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                            @forelse($expenseTypes as $type)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="expense-type-row-checkbox rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>

                                <!-- Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" 
                                         style="color: var(--text-primary);"
                                         data-expense-type-id="{{ $type->id }}"
                                         data-expense-type-name="{{ $type->name }}"
                                         data-expense-type-description="{{ $type->description ?? '' }}"
                                         data-expense-type-status="{{ $type->status }}"
                                    >
                                        {{ $type->name }}
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $type->description ?: '-' }}</div>
                                </div>

                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $type->status }}</div>
                                </div>

                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 80px;">
                                    <div class="flex items-center justify-center gap-2">
                                        <button 
                                            class="hr-action-edit flex-shrink-0" 
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button 
                                            class="hr-action-delete flex-shrink-0" 
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                    No expense types found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Add Expense Type Modal -->
        <x-admin.modal
            id="expense-type-add-modal"
            title="Add Expense Type"
            icon="fas fa-list-alt"
            maxWidth="md"
            backdropOnClick="closeExpenseTypeAddModal(true)"
        >
            <form method="POST" action="{{ route('claim.configuration.expenses-types.store') }}">
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
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Description</label>
                    <textarea
                        name="description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs resize-y"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                    ></textarea>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            checked
                            class="rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                        >
                        <span class="text-xs" style="color: var(--text-primary);">Active</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeExpenseTypeAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Expense Type Modal -->
        <x-admin.modal
            id="expense-type-edit-modal"
            title="Edit Expense Type"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeExpenseTypeEditModal(true)"
        >
            <form method="POST" id="expense-type-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="expense-type-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Description</label>
                    <textarea
                        name="description"
                        id="expense-type-edit-description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs resize-y"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                    ></textarea>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="expense-type-edit-is-active"
                            value="1"
                            class="rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                        >
                        <span class="text-xs" style="color: var(--text-primary);">Active</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeExpenseTypeEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Expense Type Modal -->
        <x-admin.modal
            id="expense-type-delete-modal"
            title="Delete Expense Type"
            maxWidth="xs"
            backdropOnClick="closeExpenseTypeDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this expense type?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeExpenseTypeDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmExpenseTypeDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Expense Types Modal -->
        <x-admin.modal
            id="expense-type-bulk-delete-modal"
            title="Delete Selected Expense Types"
            maxWidth="xs"
            backdropOnClick="closeExpenseTypeBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected expense types?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeExpenseTypeBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmExpenseTypeBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="expense-type-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="expense-type-bulk-delete-form" method="POST" action="{{ route('claim.configuration.expenses-types.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="expense-type-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var expenseTypeEditUrlTemplate = "{{ route('claim.configuration.expenses-types.update', ['id' => '__ID__']) }}";
                var expenseTypeDeleteUrlTemplate = "{{ route('claim.configuration.expenses-types.delete', ['id' => '__ID__']) }}";

                var pendingExpenseTypeDeleteId = null;

                function openExpenseTypeAddModal() {
                    var m = document.getElementById('expense-type-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openExpenseTypeAddModal = openExpenseTypeAddModal;

                function closeExpenseTypeAddModal(reset) {
                    var m = document.getElementById('expense-type-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeExpenseTypeAddModal = closeExpenseTypeAddModal;

                function openExpenseTypeEditModalFromRow(row) {
                    var info = row.querySelector('[data-expense-type-id]');
                    if (!info) return;

                    var id = info.dataset.expenseTypeId;
                    var name = info.dataset.expenseTypeName || '';
                    var description = info.dataset.expenseTypeDescription || '';
                    var status = info.dataset.expenseTypeStatus || 'Active';

                    var m = document.getElementById('expense-type-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('expense-type-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('expense-type-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var isActiveCheckbox = document.getElementById('expense-type-edit-is-active');
                    if (isActiveCheckbox) isActiveCheckbox.checked = status === 'Active';

                    var form = document.getElementById('expense-type-edit-form');
                    if (form) {
                        form.action = expenseTypeEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openExpenseTypeEditModalFromRow = openExpenseTypeEditModalFromRow;

                function closeExpenseTypeEditModal(reset) {
                    var m = document.getElementById('expense-type-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeExpenseTypeEditModal = closeExpenseTypeEditModal;

                function openExpenseTypeDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-expense-type-id]');
                    if (!info) return;
                    pendingExpenseTypeDeleteId = info.dataset.expenseTypeId || null;
                    var m = document.getElementById('expense-type-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openExpenseTypeDeleteModalFromRow = openExpenseTypeDeleteModalFromRow;

                function closeExpenseTypeDeleteModal() {
                    var m = document.getElementById('expense-type-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingExpenseTypeDeleteId = null;
                }
                window.closeExpenseTypeDeleteModal = closeExpenseTypeDeleteModal;

                function confirmExpenseTypeDelete() {
                    if (!pendingExpenseTypeDeleteId) {
                        closeExpenseTypeDeleteModal();
                        return;
                    }
                    var form = document.getElementById('expense-type-delete-form');
                    if (!form) {
                        closeExpenseTypeDeleteModal();
                        return;
                    }
                    form.action = expenseTypeDeleteUrlTemplate.replace('__ID__', pendingExpenseTypeDeleteId);
                    closeExpenseTypeDeleteModal();
                    form.submit();
                }
                window.confirmExpenseTypeDelete = confirmExpenseTypeDelete;

                function openExpenseTypeBulkDeleteModal() {
                    var m = document.getElementById('expense-type-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openExpenseTypeBulkDeleteModal = openExpenseTypeBulkDeleteModal;

                function closeExpenseTypeBulkDeleteModal() {
                    var m = document.getElementById('expense-type-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeExpenseTypeBulkDeleteModal = closeExpenseTypeBulkDeleteModal;

                function confirmExpenseTypeBulkDelete() {
                    var table = document.getElementById('expense-types-table');
                    if (!table) {
                        closeExpenseTypeBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.expense-type-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.hr-table-row');
                        if (!row) return;
                        var info = row.querySelector('[data-expense-type-id]');
                        if (info && info.dataset.expenseTypeId) {
                            ids.push(info.dataset.expenseTypeId);
                        }
                    });

                    if (!ids.length) {
                        closeExpenseTypeBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('expense-type-bulk-delete-form');
                    var input = document.getElementById('expense-type-bulk-delete-ids');
                    if (!form || !input) {
                        closeExpenseTypeBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeExpenseTypeBulkDeleteModal();
                    form.submit();
                }
                window.confirmExpenseTypeBulkDelete = confirmExpenseTypeBulkDelete;

                function refreshExpenseTypeSelectionState() {
                    var table = document.getElementById('expense-types-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('expense-types-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.expense-type-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('expense-types-delete-selected');

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
                    var table = document.getElementById('expense-types-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('expense-types-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.expense-type-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshExpenseTypeSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#expense-types-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.expense-type-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openExpenseTypeEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openExpenseTypeDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshExpenseTypeSelectionState();
                        }
                    });

                    refreshExpenseTypeSelectionState();

                    // Reset button handler
                    var resetBtn = document.querySelector('#expense-types-search-form button[type="button"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var form = document.getElementById('expense-types-search-form');
                            if (form) {
                                form.querySelector('input[name="name"]').value = '';
                                form.querySelector('select[name="status"]').value = '';
                                window.location.href = '{{ route("claim.configuration.expenses-types") }}';
                            }
                        });
                    }

                    // Scroll to table section if status message exists
                    @if(session('status'))
                        var tableSection = document.getElementById('expense-types-table-section');
                        if (tableSection) {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    @endif

                    // Scroll to table section on search form submit
                    var searchForm = document.getElementById('expense-types-search-form');
                    if (searchForm) {
                        searchForm.addEventListener('submit', function(e) {
                            var formAction = searchForm.getAttribute('action') || window.location.pathname;
                            var url = new URL(formAction, window.location.origin);
                            
                            var formData = new FormData(searchForm);
                            for (var [key, value] of formData.entries()) {
                                if (value) {
                                    url.searchParams.set(key, value);
                                }
                            }
                            
                            url.hash = 'expense-types-table-section';
                            window.location.href = url.toString();
                            e.preventDefault();
                        });
                    }

                    // Scroll to table section if hash exists or if search parameters are present
                    if (window.location.hash === '#expense-types-table-section' || 
                        (window.location.search && (window.location.search.includes('name=') || 
                         window.location.search.includes('status=')))) {
                        var tableSection = document.getElementById('expense-types-table-section');
                        if (tableSection) {
                            setTimeout(function() {
                                tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 300);
                        }
                    }
                });
            })();
        </script>

    </x-main-layout>
@endsection