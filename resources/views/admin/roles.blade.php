@extends('layouts.app')

@section('title', 'Admin - Roles')

@section('body')
    <x-main-layout title="Admin">
        <x-admin.tabs activeTab="roles" />

        <!-- Roles Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-shield text-[var(--color-primary)]"></i> Roles
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="roles-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openRoleBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openRoleAddModal()" />
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

            @if(isset($roles) && count($roles) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($roles)" />
            @endif

            <!-- Table -->
            <div id="roles-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="roles-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Role Name
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Slug
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
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

                    <!-- Table Rows -->
                    <div class="border border-t-0 rounded-b-lg"
                         style="border-color: var(--border-default);">
                        @forelse($roles as $role)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);"
                                 onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                 onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="role-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                                           data-role-checkbox-id="{{ $role->id }}"
                                           {{ $role->is_system == 1 ? 'disabled' : '' }}>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-role-id="{{ $role->id }}"
                                         data-role-name="{{ $role->name }}"
                                         data-role-slug="{{ $role->slug }}"
                                         data-role-description="{{ $role->description ?? '' }}"
                                         data-role-is-system="{{ $role->is_system }}"
                                    >
                                        {{ $role->name }}
                                        @if($role->is_system == 1)
                                            <span class="text-[10px] ml-1" style="color: var(--text-muted);">(System)</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $role->slug }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $role->description ?: '-' }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0" style="width: 80px;">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="hr-action-edit flex-shrink-0" title="Edit" type="button">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button class="hr-action-delete flex-shrink-0" title="Delete" type="button">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                No roles found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Role Modal -->
        <x-admin.modal
            id="role-add-modal"
            title="Add Role"
            icon="fas fa-user-shield"
            maxWidth="md"
            backdropOnClick="closeRoleAddModal(true)"
        >
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="role-add-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="slug"
                        id="role-add-slug"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                        placeholder="e.g., manager, employee"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <textarea
                        name="description"
                        id="role-add-description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                        autocomplete="off"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeRoleAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Role Modal -->
        <x-admin.modal
            id="role-edit-modal"
            title="Edit Role"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeRoleEditModal(true)"
        >
            <form method="POST" id="role-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="role-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="slug"
                        id="role-edit-slug"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <textarea
                        name="description"
                        id="role-edit-description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeRoleEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Role Modal -->
        <x-admin.modal
            id="role-delete-modal"
            title="Delete Role"
            maxWidth="xs"
            backdropOnClick="closeRoleDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this role?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeRoleDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmRoleDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Roles Modal -->
        <x-admin.modal
            id="role-bulk-delete-modal"
            title="Delete Selected Roles"
            maxWidth="xs"
            backdropOnClick="closeRoleBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected roles?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeRoleBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmRoleBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Error/Warning Modal -->
        <div 
            id="role-error-modal" 
            class="hidden fixed inset-0 z-50 flex items-center justify-center"
        >
            <div 
                class="absolute inset-0 bg-black/40"
                onclick="closeRoleErrorModal()"
            ></div>

            <div 
                class="relative w-full max-w-xs mx-4 rounded-2xl border shadow-xl"
                style="background-color: var(--bg-card); border-color: var(--border-strong);"
            >
                <div class="px-5 py-4 border-b" style="border-color: var(--border-default);">
                    <h3 class="text-sm font-bold flex items-center gap-2" style="color: var(--text-primary);">
                        <i class="fas fa-exclamation-triangle text-[var(--color-primary)]"></i>
                        <span id="role-error-title">Warning</span>
                    </h3>
                </div>

                <div class="px-5 py-4">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center" style="background: rgba(239, 68, 68, 0.1);">
                            <i class="fas fa-exclamation-triangle text-lg" style="color: #DC2626;"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs leading-relaxed" style="color: var(--text-muted);" id="role-error-message">This action cannot be performed.</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            class="hr-btn-primary px-4 py-1.5 text-xs"
                            onclick="closeRoleErrorModal()"
                        >
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden forms for deletes -->
        <form id="role-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="role-bulk-delete-form" method="POST" action="{{ route('admin.roles.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="role-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var roleEditUrlTemplate = "{{ route('admin.roles.update', ['id' => '__ID__']) }}";
                var roleDeleteUrlTemplate = "{{ route('admin.roles.delete', ['id' => '__ID__']) }}";

                var pendingRoleDeleteId = null;

                function openRoleAddModal() {
                    var m = document.getElementById('role-add-modal');
                    if (m) {
                        m.classList.remove('hidden');
                        // Focus on first input after modal opens
                        setTimeout(function() {
                            var firstInput = document.getElementById('role-add-name');
                            if (firstInput) firstInput.focus();
                        }, 100);
                    }
                }
                window.openRoleAddModal = openRoleAddModal;

                function closeRoleAddModal(reset) {
                    var m = document.getElementById('role-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeRoleAddModal = closeRoleAddModal;

                function openRoleEditModalFromRow(row) {
                    var info = row.querySelector('[data-role-id]');
                    if (!info) return;

                    var id = info.dataset.roleId;
                    var name = info.dataset.roleName || '';
                    var slug = info.dataset.roleSlug || '';
                    var description = info.dataset.roleDescription || '';

                    var m = document.getElementById('role-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('role-edit-name');
                    if (nameInput) nameInput.value = name;

                    var slugInput = document.getElementById('role-edit-slug');
                    if (slugInput) slugInput.value = slug;

                    var descriptionInput = document.getElementById('role-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var form = document.getElementById('role-edit-form');
                    if (form) {
                        form.action = roleEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openRoleEditModalFromRow = openRoleEditModalFromRow;

                function closeRoleEditModal(reset) {
                    var m = document.getElementById('role-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeRoleEditModal = closeRoleEditModal;

                function openRoleDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-role-id]');
                    if (!info) return;
                    
                    pendingRoleDeleteId = info.dataset.roleId || null;
                    var m = document.getElementById('role-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openRoleDeleteModalFromRow = openRoleDeleteModalFromRow;

                function closeRoleDeleteModal() {
                    var m = document.getElementById('role-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingRoleDeleteId = null;
                }
                window.closeRoleDeleteModal = closeRoleDeleteModal;

                function confirmRoleDelete() {
                    if (!pendingRoleDeleteId) {
                        closeRoleDeleteModal();
                        return;
                    }
                    var form = document.getElementById('role-delete-form');
                    if (!form) {
                        closeRoleDeleteModal();
                        return;
                    }
                    form.action = roleDeleteUrlTemplate.replace('__ID__', pendingRoleDeleteId);
                    closeRoleDeleteModal();
                    form.submit();
                }
                window.confirmRoleDelete = confirmRoleDelete;

                function openRoleBulkDeleteModal() {
                    var m = document.getElementById('role-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openRoleBulkDeleteModal = openRoleBulkDeleteModal;

                function closeRoleBulkDeleteModal() {
                    var m = document.getElementById('role-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeRoleBulkDeleteModal = closeRoleBulkDeleteModal;

                function confirmRoleBulkDelete() {
                    var table = document.getElementById('roles-table');
                    if (!table) {
                        closeRoleBulkDeleteModal();
                        return;
                    }
                    var allChecked = table.querySelectorAll('.role-row-checkbox:checked');
                    var ids = [];
                    allChecked.forEach(function (cb) {
                        if (cb.disabled) return;
                        var row = cb.closest('.hr-table-row');
                        if (!row) return;
                        var info = row.querySelector('[data-role-id]');
                        if (info && info.dataset.roleId) {
                            ids.push(info.dataset.roleId);
                        }
                    });

                    if (!ids.length) {
                        closeRoleBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('role-bulk-delete-form');
                    var input = document.getElementById('role-bulk-delete-ids');
                    if (!form || !input) {
                        closeRoleBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeRoleBulkDeleteModal();
                    form.submit();
                }
                window.confirmRoleBulkDelete = confirmRoleBulkDelete;

                function showRoleError(title, message) {
                    var modal = document.getElementById('role-error-modal');
                    var titleEl = document.getElementById('role-error-title');
                    var messageEl = document.getElementById('role-error-message');
                    if (modal && titleEl && messageEl) {
                        titleEl.textContent = title;
                        messageEl.textContent = message;
                        modal.classList.remove('hidden');
                    }
                }
                window.showRoleError = showRoleError;

                function closeRoleErrorModal() {
                    var modal = document.getElementById('role-error-modal');
                    if (modal) modal.classList.add('hidden');
                }
                window.closeRoleErrorModal = closeRoleErrorModal;

                function refreshRoleSelectionState() {
                    var table = document.getElementById('roles-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('roles-master-checkbox');
                    var allRowCheckboxes = table.querySelectorAll('.role-row-checkbox');
                    var rowCheckboxes = Array.from(allRowCheckboxes).filter(function(cb) {
                        return !cb.disabled;
                    });
                    var deleteSelectedBtn = document.getElementById('roles-delete-selected');

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
                        } else if (checkedCount === rowCheckboxes.length && checkedCount > 0) {
                            headerCheckbox.checked = true;
                        } else {
                            headerCheckbox.checked = false;
                        }
                        headerCheckbox.indeterminate = (checkedCount > 0 && checkedCount < rowCheckboxes.length);
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var table = document.getElementById('roles-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('roles-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var allRowCheckboxes = table.querySelectorAll('.role-row-checkbox');
                            allRowCheckboxes.forEach(function (cb) {
                                if (!cb.disabled) {
                                    cb.checked = headerCheckbox.checked;
                                }
                            });
                            refreshRoleSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#roles-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.role-row-checkbox');

                        if (editBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            var row = editBtn.closest('.hr-table-row');
                            if (row) {
                                var info = row.querySelector('[data-role-id]');
                                if (info && info.dataset.roleIsSystem == '1') {
                                    showRoleError('Cannot Edit System Role', 'System roles cannot be edited. These roles are protected and required for the system to function properly.');
                                    return;
                                }
                                openRoleEditModalFromRow(row);
                            }
                            return;
                        }

                        if (deleteBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            var rowDel = deleteBtn.closest('.hr-table-row');
                            if (rowDel) {
                                var info = rowDel.querySelector('[data-role-id]');
                                if (info && info.dataset.roleIsSystem == '1') {
                                    showRoleError('Cannot Delete System Role', 'System roles cannot be deleted. These roles are protected and required for the system to function properly.');
                                    return;
                                }
                                openRoleDeleteModalFromRow(rowDel);
                            }
                            return;
                        }

                        if (rowCheckbox) {
                            if (rowCheckbox.disabled) {
                                e.preventDefault();
                                return;
                            }
                            refreshRoleSelectionState();
                        }
                    });

                    refreshRoleSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection

