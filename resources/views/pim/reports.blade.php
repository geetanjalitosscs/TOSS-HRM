@extends('layouts.app')

@section('title', 'PIM - Reports')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="reports" />

        <div class="space-y-6">
            <!-- Employee Reports Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-[var(--color-primary)]"></i> Employee Reports
                </h2>
                <form method="GET" action="{{ route('pim.reports') }}" id="reports-search-form">
                <div class="mb-3">
                    <label class="block text-xs font-medium text-slate-700 mb-1">Report Name</label>
                        <input 
                            type="text" 
                            name="report_name"
                            value="{{ request('report_name') }}"
                            class="hr-input w-full px-2 py-1.5 text-xs border bordtext-[var(--color-primary)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                            placeholder="Type for hints...">
                </div>
                    <x-admin.action-buttons resetType="reset" searchType="submit" />
                </form>
            </section>

            <!-- Reports List Card -->
            <section class="hr-card p-6">
                <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-file-alt text-[var(--color-primary)]"></i> Reports List
                    </h2>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="reports-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openReportBulkDeleteModal()"
                        >
                            Delete Selected
                        </button>
                        <x-admin.add-button class="mb-0" onClick="openReportAddModal()" />
                    </div>
                </div>

                @if(isset($reports) && count($reports) > 0)
                    <!-- Records Count -->
                    <x-records-found :count="count($reports)" />
                @endif

                <!-- Table -->
                <div id="reports-table">
                    <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto; overflow-x: hidden;">
                        <!-- Header -->
                        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                             style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox"
                                       id="reports-master-checkbox"
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
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                     style="color: var(--text-primary);">
                                    Type
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
                            @forelse($reports as $report)
                                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                     style="background-color: var(--bg-card); border-color: var(--border-default);">
                                    <div class="flex-shrink-0" style="width: 24px;">
                                        <input type="checkbox"
                                               class="report-row-checkbox rounded w-3.5 h-3.5"
                                               style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs font-medium break-words"
                                             style="color: var(--text-primary);"
                                             data-report-id="{{ $report->id }}"
                                             data-report-name="{{ $report->name }}"
                                             data-report-description="{{ $report->description ?? '' }}"
                                             data-report-type="{{ $report->type ?? 'education' }}">
                                            {{ $report->name }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ $report->description ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">
                                            {{ ucfirst($report->type ?? 'education') }}
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 80px;">
                                        <div class="flex items-center justify-center gap-2">
                        <button class="hr-action-copy flex-shrink-0" title="Copy">
                            <i class="fas fa-copy text-sm"></i>
                        </button>
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
                                    No reports found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Add Report Modal -->
        <x-admin.modal
            id="report-add-modal"
            title="Add Report"
            icon="fas fa-file-alt"
            maxWidth="md"
            backdropOnClick="closeReportAddModal(true)"
        >
            <form method="POST" action="{{ route('pim.reports.store') }}">
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
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Type
                    </label>
                    <select
                        name="type"
                        class="hr-select text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="education">Education</option>
                        <option value="skill">Skill</option>
                        <option value="language">Language</option>
                        <option value="certification">Certification</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Report Modal -->
        <x-admin.modal
            id="report-edit-modal"
            title="Edit Report"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeReportEditModal(true)"
        >
            <form method="POST" id="report-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="report-edit-name"
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
                        id="report-edit-description"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Type
                    </label>
                    <select
                        name="type"
                        id="report-edit-type"
                        class="hr-select text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="education">Education</option>
                        <option value="skill">Skill</option>
                        <option value="language">Language</option>
                        <option value="certification">Certification</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Report Modal -->
        <x-admin.modal
            id="report-delete-modal"
            title="Delete Report"
            maxWidth="xs"
            backdropOnClick="closeReportDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this report?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmReportDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Reports Modal -->
        <x-admin.modal
            id="report-bulk-delete-modal"
            title="Delete Selected Reports"
            maxWidth="xs"
            backdropOnClick="closeReportBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected reports?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeReportBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmReportBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="report-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="report-bulk-delete-form" method="POST" action="{{ route('pim.reports.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="report-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var reportEditUrlTemplate = "{{ route('pim.reports.update', ['id' => '__ID__']) }}";
                var reportDeleteUrlTemplate = "{{ route('pim.reports.delete', ['id' => '__ID__']) }}";

                var pendingReportDeleteId = null;

                function openReportAddModal() {
                    var m = document.getElementById('report-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openReportAddModal = openReportAddModal;

                function closeReportAddModal(reset) {
                    var m = document.getElementById('report-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeReportAddModal = closeReportAddModal;

                function openReportEditModalFromRow(row) {
                    var info = row.querySelector('[data-report-id]');
                    if (!info) return;

                    var id = info.dataset.reportId;
                    var name = info.dataset.reportName || '';
                    var description = info.dataset.reportDescription || '';
                    var type = info.dataset.reportType || 'education';

                    var m = document.getElementById('report-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('report-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('report-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var typeSelect = document.getElementById('report-edit-type');
                    if (typeSelect) {
                        typeSelect.value = type || 'education';
                    }

                    var form = document.getElementById('report-edit-form');
                    if (form) {
                        form.action = reportEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }

                function closeReportEditModal(reset) {
                    var m = document.getElementById('report-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeReportEditModal = closeReportEditModal;

                function openReportDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-report-id]');
                    if (!info) return;
                    pendingReportDeleteId = info.dataset.reportId || null;
                    var m = document.getElementById('report-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeReportDeleteModal() {
                    var m = document.getElementById('report-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingReportDeleteId = null;
                }
                window.closeReportDeleteModal = closeReportDeleteModal;

                function confirmReportDelete() {
                    if (!pendingReportDeleteId) {
                        closeReportDeleteModal();
                        return;
                    }
                    var form = document.getElementById('report-delete-form');
                    if (!form) {
                        closeReportDeleteModal();
                        return;
                    }
                    form.action = reportDeleteUrlTemplate.replace('__ID__', pendingReportDeleteId);
                    closeReportDeleteModal();
                    form.submit();
                }
                window.confirmReportDelete = confirmReportDelete;

                function openReportBulkDeleteModal() {
                    var m = document.getElementById('report-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openReportBulkDeleteModal = openReportBulkDeleteModal;

                function closeReportBulkDeleteModal() {
                    var m = document.getElementById('report-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeReportBulkDeleteModal = closeReportBulkDeleteModal;

                function confirmReportBulkDelete() {
                    var table = document.getElementById('reports-table');
                    if (!table) {
                        closeReportBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.report-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.border-b');
                        if (!row) return;
                        var info = row.querySelector('[data-report-id]');
                        if (info && info.dataset.reportId) {
                            ids.push(info.dataset.reportId);
                        }
                    });

                    if (!ids.length) {
                        closeReportBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('report-bulk-delete-form');
                    var input = document.getElementById('report-bulk-delete-ids');
                    if (!form || !input) {
                        closeReportBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeReportBulkDeleteModal();
                    form.submit();
                }
                window.confirmReportBulkDelete = confirmReportBulkDelete;

                function refreshReportSelectionState() {
                    var table = document.getElementById('reports-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('reports-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.report-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('reports-delete-selected');

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
                    var table = document.getElementById('reports-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('reports-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.report-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshReportSelectionState();
                        });
                    }

                    // Reset button functionality
                    var resetBtn = document.querySelector('#reports-search-form button[type="reset"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var form = document.getElementById('reports-search-form');
                            if (form) {
                                form.querySelector('input[name="report_name"]').value = '';
                                window.location.href = '{{ route("pim.reports") }}';
                            }
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var copyBtn = e.target.closest('.hr-action-copy');
                        var rowCheckbox = e.target.closest('.report-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.border-b');
                            if (row) openReportEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.border-b');
                            if (rowDel) openReportDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (copyBtn) {
                            var row = e.target.closest('.border-b');
                            if (row) {
                                var info = row.querySelector('[data-report-id]');
                                if (info) {
                                    var name = info.dataset.reportName || '';
                                    var description = info.dataset.reportDescription || '-';
                                    var type = info.dataset.reportType || 'education';
                                    var textToCopy = 'Name: ' + name + '\nDescription: ' + description + '\nType: ' + type;
                                    if (name) {
                                        navigator.clipboard.writeText(textToCopy).then(function() {
                                            // Show success message
                                            var originalTitle = copyBtn.getAttribute('title');
                                            copyBtn.setAttribute('title', 'Copied!');
                                            
                                            // Create a temporary toast message
                                            var toast = document.createElement('div');
                                            toast.textContent = 'Row copied to clipboard!';
                                            toast.style.cssText = 'position: fixed; top: 20px; right: 20px; background-color: var(--color-hr-primary); color: white; padding: 12px 20px; border-radius: 8px; z-index: 99999; font-size: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);';
                                            document.body.appendChild(toast);
                                            
                                            setTimeout(function() {
                                                copyBtn.setAttribute('title', originalTitle || 'Copy');
                                                toast.remove();
                                            }, 2000);
                                        }).catch(function(err) {
                                            console.error('Failed to copy:', err);
                                        });
                                    }
                                }
                            }
                            return;
                        }

                        if (rowCheckbox) {
                            refreshReportSelectionState();
                        }
                    });

                    refreshReportSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
