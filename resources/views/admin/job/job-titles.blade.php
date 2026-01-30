@extends('layouts.app')

@section('title', 'Admin - Job Titles')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="job-titles" />

        <!-- Job Titles Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-briefcase text-purple-500"></i> Job Titles
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="job-titles-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openJobTitleBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button class="mb-0" onClick="openJobTitleAddModal()" />
                </div>
            </div>

            @if(isset($jobTitles) && count($jobTitles) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($jobTitles)" />
            @endif

            <!-- Table -->
            <div id="job-titles-table">
                <div class="hr-table-wrapper">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="job-titles-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Job Titles
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Job Description
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
                        @forelse($jobTitles as $jobTitle)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);"
                                 onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                 onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="job-title-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-job-title-id="{{ $jobTitle->id }}"
                                         data-job-title-name="{{ $jobTitle->title }}"
                                         data-job-title-description="{{ $jobTitle->description ?? '' }}"
                                    >
                                        {{ $jobTitle->title }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $jobTitle->description ?: '-' }}
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
                                No job titles found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Job Title Modal -->
        <x-admin.modal
            id="job-title-add-modal"
            title="Add Job Title"
            icon="fas fa-briefcase"
            maxWidth="md"
            backdropOnClick="closeJobTitleAddModal(true)"
        >
            <form method="POST" action="{{ route('admin.job-titles.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Job Title <span class="text-red-500">*</span>
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
                        Job Description
                    </label>
                    <textarea
                        name="description"
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
                        onclick="closeJobTitleAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Job Title Modal -->
        <x-admin.modal
            id="job-title-edit-modal"
            title="Edit Job Title"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeJobTitleEditModal(true)"
        >
            <form method="POST" id="job-title-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="job-title-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Job Description
                    </label>
                    <textarea
                        name="description"
                        id="job-title-edit-description"
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
                        onclick="closeJobTitleEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Job Title Modal -->
        <x-admin.modal
            id="job-title-delete-modal"
            title="Delete Job Title"
            maxWidth="xs"
            backdropOnClick="closeJobTitleDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this job title?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeJobTitleDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmJobTitleDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Job Titles Modal -->
        <x-admin.modal
            id="job-title-bulk-delete-modal"
            title="Delete Selected Job Titles"
            maxWidth="xs"
            backdropOnClick="closeJobTitleBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected job titles?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeJobTitleBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmJobTitleBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="job-title-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="job-title-bulk-delete-form" method="POST" action="{{ route('admin.job-titles.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="job-title-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var jobTitleEditUrlTemplate = "{{ route('admin.job-titles.update', ['id' => '__ID__']) }}";
                var jobTitleDeleteUrlTemplate = "{{ route('admin.job-titles.delete', ['id' => '__ID__']) }}";

                var pendingJobTitleDeleteId = null;

                function openJobTitleAddModal() {
                    var m = document.getElementById('job-title-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openJobTitleAddModal = openJobTitleAddModal;

                function closeJobTitleAddModal(reset) {
                    var m = document.getElementById('job-title-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeJobTitleAddModal = closeJobTitleAddModal;

                function openJobTitleEditModalFromRow(row) {
                    var info = row.querySelector('[data-job-title-id]');
                    if (!info) return;

                    var id = info.dataset.jobTitleId;
                    var name = info.dataset.jobTitleName || '';
                    var description = info.dataset.jobTitleDescription || '';

                    var m = document.getElementById('job-title-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('job-title-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('job-title-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var form = document.getElementById('job-title-edit-form');
                    if (form) {
                        form.action = jobTitleEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openJobTitleEditModalFromRow = openJobTitleEditModalFromRow;

                function closeJobTitleEditModal(reset) {
                    var m = document.getElementById('job-title-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeJobTitleEditModal = closeJobTitleEditModal;

                function openJobTitleDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-job-title-id]');
                    if (!info) return;
                    pendingJobTitleDeleteId = info.dataset.jobTitleId || null;
                    var m = document.getElementById('job-title-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openJobTitleDeleteModalFromRow = openJobTitleDeleteModalFromRow;

                function closeJobTitleDeleteModal() {
                    var m = document.getElementById('job-title-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingJobTitleDeleteId = null;
                }
                window.closeJobTitleDeleteModal = closeJobTitleDeleteModal;

                function confirmJobTitleDelete() {
                    if (!pendingJobTitleDeleteId) {
                        closeJobTitleDeleteModal();
                        return;
                    }
                    var form = document.getElementById('job-title-delete-form');
                    if (!form) {
                        closeJobTitleDeleteModal();
                        return;
                    }
                    form.action = jobTitleDeleteUrlTemplate.replace('__ID__', pendingJobTitleDeleteId);
                    closeJobTitleDeleteModal();
                    form.submit();
                }
                window.confirmJobTitleDelete = confirmJobTitleDelete;

                function openJobTitleBulkDeleteModal() {
                    var m = document.getElementById('job-title-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openJobTitleBulkDeleteModal = openJobTitleBulkDeleteModal;

                function closeJobTitleBulkDeleteModal() {
                    var m = document.getElementById('job-title-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeJobTitleBulkDeleteModal = closeJobTitleBulkDeleteModal;

                function confirmJobTitleBulkDelete() {
                    var table = document.getElementById('job-titles-table');
                    if (!table) {
                        closeJobTitleBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.job-title-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.hr-table-row');
                        if (!row) return;
                        var info = row.querySelector('[data-job-title-id]');
                        if (info && info.dataset.jobTitleId) {
                            ids.push(info.dataset.jobTitleId);
                        }
                    });

                    if (!ids.length) {
                        closeJobTitleBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('job-title-bulk-delete-form');
                    var input = document.getElementById('job-title-bulk-delete-ids');
                    if (!form || !input) {
                        closeJobTitleBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeJobTitleBulkDeleteModal();
                    form.submit();
                }
                window.confirmJobTitleBulkDelete = confirmJobTitleBulkDelete;

                function refreshJobTitleSelectionState() {
                    var table = document.getElementById('job-titles-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('job-titles-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.job-title-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('job-titles-delete-selected');

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
                    var table = document.getElementById('job-titles-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('job-titles-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.job-title-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshJobTitleSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#job-titles-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.job-title-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openJobTitleEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openJobTitleDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshJobTitleSelectionState();
                        }
                    });

                    refreshJobTitleSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
