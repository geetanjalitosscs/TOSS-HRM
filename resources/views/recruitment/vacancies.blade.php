@extends('layouts.app')

@section('title', 'Recruitment - Vacancies')

@section('body')
    <x-main-layout title="Recruitment">
        <x-recruitment.tabs activeTab="vacancies" />

        <div class="space-y-6">
            <!-- Vacancies Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-[var(--color-primary)]"></i> Vacancies
                </h2>
                <form id="vacancies-search-form" method="GET" action="{{ route('recruitment.vacancies') }}">
                    <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                <select name="job_title" class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    @foreach($jobTitles ?? [] as $title)
                                        <option value="{{ $title->id }}" {{ request('job_title') == $title->id ? 'selected' : '' }}>{{ $title->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Vacancy</label>
                                <input type="text" name="vacancy" class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints..." value="{{ request('vacancy') }}">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Hiring Manager</label>
                                <select name="hiring_manager" class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    @foreach($employees ?? [] as $emp)
                                        <option value="{{ $emp->id }}" {{ request('hiring_manager') == $emp->id ? 'selected' : '' }}>{{ $emp->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Active</option>
                                    <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" />
                    </div>
                </form>
            </section>

            <!-- Vacancies List Card -->
            <section id="vacancies-table-section" class="hr-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-briefcase text-[var(--color-primary)]"></i> Vacancies List
                    </h2>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="vacancies-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openVacancyBulkDeleteModal()"
                        >
                            <i class="fas fa-trash-alt mr-2"></i>Delete Selected
                        </button>
                        <x-admin.add-button class="mb-0" onClick="openVacancyAddModal()" />
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

                @if(isset($vacancies) && count($vacancies) > 0)
                    <!-- Records Count -->
                    <x-records-found :count="count($vacancies)" />
                @endif

                <!-- Table Wrapper -->
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto; overflow-x: hidden;" id="vacancies-table-wrapper">
                    <!-- Table Header -->
                    <div class="rounded-t-lg border border-b-0 px-2 py-1.5 mb-0" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex items-center gap-1">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" 
                                       id="vacancies-master-checkbox"
                                       class="rounded w-3.5 h-3.5" 
                                       style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" 
                                       onfocus="this.style.outline='2px solid var(--color-hr-primary)'" 
                                       onblur="this.style.outline='none'">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Vacancy</span>
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Job Title</span>
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Hiring Manager</span>
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</span>
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0" style="width: 120px;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Vacancy Rows -->
                    <div class="border border-t-0 rounded-b-lg" id="vacancies-table" style="border-color: var(--border-default);">
                        @forelse($vacancies as $vacancy)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors hr-table-row" 
                                 style="background-color: var(--bg-card); border-color: var(--border-default);" 
                                 onmouseover="this.style.backgroundColor='var(--bg-hover)'" 
                                 onmouseout="this.style.backgroundColor='var(--bg-card)'"
                                 data-vacancy-id="{{ $vacancy->id }}"
                                 data-vacancy-name="{{ $vacancy->vacancy }}"
                                 data-vacancy-job-title-id="{{ $vacancy->job_title_id }}"
                                 data-vacancy-hiring-manager-id="{{ $vacancy->hiring_manager_id ?? '' }}"
                                 data-vacancy-status="{{ $vacancy->status }}">
                                <div class="flex items-center gap-1">
                                    <div class="flex-shrink-0" style="width: 24px;">
                                        <input type="checkbox" 
                                               class="vacancy-row-checkbox rounded w-3.5 h-3.5" 
                                               style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" 
                                               data-vacancy-id="{{ $vacancy->id }}"
                                               onfocus="this.style.outline='2px solid var(--color-hr-primary)'" 
                                               onblur="this.style.outline='none'">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $vacancy->vacancy }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $vacancy->job_title }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $vacancy->hiring_manager }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <span class="px-1.5 py-0.5 text-xs rounded-full 
                                            @if($vacancy->status_display === 'Active') bg-green-100 text-green-700
                                            @elseif($vacancy->status_display === 'On Hold') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700
                                            @endif">
                                            {{ $vacancy->status_display }}
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 120px;">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="hr-action-edit flex-shrink-0" title="Edit"
                                                    onclick="event.preventDefault(); event.stopPropagation(); openVacancyEditModalFromRow(this.closest('.hr-table-row'));">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <button class="hr-action-delete flex-shrink-0" title="Delete"
                                                    onclick="event.preventDefault(); event.stopPropagation(); openVacancyDeleteModalFromRow(this.closest('.hr-table-row'));">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                No vacancies found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <!-- Add Vacancy Modal -->
        <x-admin.modal
            id="vacancy-add-modal"
            title="Add Vacancy"
            icon="fas fa-briefcase"
            maxWidth="md"
            backdropOnClick="closeVacancyAddModal(true)"
        >
            <form method="POST" action="{{ route('recruitment.vacancies.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Vacancy Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="vacancy-add-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="job_title_id"
                        id="vacancy-add-job-title-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Job Title --</option>
                        @foreach($jobTitles ?? [] as $title)
                            <option value="{{ $title->id }}">{{ $title->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Hiring Manager
                    </label>
                    <select
                        name="hiring_manager_id"
                        id="vacancy-add-hiring-manager-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="">-- Select Hiring Manager --</option>
                        @foreach($employees ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="vacancy-add-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="open">Active</option>
                        <option value="on_hold">On Hold</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeVacancyAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Vacancy Modal -->
        <x-admin.modal
            id="vacancy-edit-modal"
            title="Edit Vacancy"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeVacancyEditModal(true)"
        >
            <form method="POST" id="vacancy-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Vacancy Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="vacancy-edit-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="job_title_id"
                        id="vacancy-edit-job-title-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Job Title --</option>
                        @foreach($jobTitles ?? [] as $title)
                            <option value="{{ $title->id }}">{{ $title->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Hiring Manager
                    </label>
                    <select
                        name="hiring_manager_id"
                        id="vacancy-edit-hiring-manager-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="">-- Select Hiring Manager --</option>
                        @foreach($employees ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="vacancy-edit-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="open">Active</option>
                        <option value="on_hold">On Hold</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeVacancyEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Vacancy Modal -->
        <x-admin.modal
            id="vacancy-delete-modal"
            title="Delete Vacancy"
            maxWidth="xs"
            backdropOnClick="closeVacancyDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this vacancy?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeVacancyDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmVacancyDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Vacancies Modal -->
        <x-admin.modal
            id="vacancy-bulk-delete-modal"
            title="Delete Selected Vacancies"
            maxWidth="xs"
            backdropOnClick="closeVacancyBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected vacancies?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeVacancyBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmVacancyBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="vacancy-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="vacancy-bulk-delete-form" method="POST" action="{{ route('recruitment.vacancies.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="vacancy-bulk-delete-ids" value="">
        </form>

        <script>
            var vacancyEditUrlTemplate = "{{ route('recruitment.vacancies.update', ['id' => '__ID__']) }}";
            var vacancyDeleteUrlTemplate = "{{ route('recruitment.vacancies.delete', ['id' => '__ID__']) }}";
            var pendingVacancyDeleteId = null;

            (function () {

                function refreshVacancySelectionState() {
                    var table = document.getElementById('vacancies-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('vacancies-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.vacancy-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('vacancies-delete-selected');

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

                function setupCheckboxes() {
                    var table = document.getElementById('vacancies-table');
                    if (!table) return;

                    var masterCheckbox = document.getElementById('vacancies-master-checkbox');
                    if (masterCheckbox && !masterCheckbox.dataset.listenerAttached) {
                        masterCheckbox.dataset.listenerAttached = 'true';
                        masterCheckbox.addEventListener('change', function () {
                            var allRowCheckboxes = table.querySelectorAll('.vacancy-row-checkbox');
                            allRowCheckboxes.forEach(function (cb) {
                                cb.checked = masterCheckbox.checked;
                            });
                            refreshVacancySelectionState();
                        });
                    }
                }

                setupCheckboxes();

                var table = document.getElementById('vacancies-table');
                if (table) {
                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#vacancies-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.vacancy-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openVacancyEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openVacancyDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshVacancySelectionState();
                        }
                    });
                }

                refreshVacancySelectionState();
            })();

            function openVacancyAddModal() {
                document.getElementById('vacancy-add-modal').classList.remove('hidden');
                document.getElementById('vacancy-add-name').focus();
            }
            window.openVacancyAddModal = openVacancyAddModal;

            function closeVacancyAddModal(reset) {
                var m = document.getElementById('vacancy-add-modal');
                if (m) {
                    m.classList.add('hidden');
                }
                if (reset) {
                    var form = m ? m.querySelector('form') : null;
                    if (form) form.reset();
                }
            }
            window.closeVacancyAddModal = closeVacancyAddModal;

            function openVacancyEditModalFromRow(row) {
                var vacancyId = row.dataset.vacancyId;
                var vacancyName = row.dataset.vacancyName || '';
                var jobTitleId = row.dataset.vacancyJobTitleId || '';
                var hiringManagerId = row.dataset.vacancyHiringManagerId || '';
                var status = row.dataset.vacancyStatus || 'open';

                var form = document.getElementById('vacancy-edit-form');
                if (form) {
                    form.action = vacancyEditUrlTemplate.replace('__ID__', vacancyId);
                }

                var nameInput = document.getElementById('vacancy-edit-name');
                if (nameInput) {
                    nameInput.value = vacancyName;
                }

                var jobTitleSelect = document.getElementById('vacancy-edit-job-title-id');
                if (jobTitleSelect) {
                    jobTitleSelect.value = jobTitleId;
                }

                var hiringManagerSelect = document.getElementById('vacancy-edit-hiring-manager-id');
                if (hiringManagerSelect) {
                    hiringManagerSelect.value = hiringManagerId;
                }

                var statusSelect = document.getElementById('vacancy-edit-status');
                if (statusSelect) {
                    statusSelect.value = status;
                }

                document.getElementById('vacancy-edit-modal').classList.remove('hidden');
                if (nameInput) nameInput.focus();
            }
            window.openVacancyEditModalFromRow = openVacancyEditModalFromRow;

            function closeVacancyEditModal(reset) {
                var m = document.getElementById('vacancy-edit-modal');
                if (m) {
                    m.classList.add('hidden');
                }
                if (reset) {
                    var form = m ? m.querySelector('form') : null;
                    if (form) form.reset();
                }
            }
            window.closeVacancyEditModal = closeVacancyEditModal;

            function openVacancyDeleteModalFromRow(row) {
                pendingVacancyDeleteId = row.dataset.vacancyId;
                document.getElementById('vacancy-delete-modal').classList.remove('hidden');
            }
            window.openVacancyDeleteModalFromRow = openVacancyDeleteModalFromRow;

            function closeVacancyDeleteModal() {
                document.getElementById('vacancy-delete-modal').classList.add('hidden');
                pendingVacancyDeleteId = null;
            }
            window.closeVacancyDeleteModal = closeVacancyDeleteModal;

            function confirmVacancyDelete() {
                if (!pendingVacancyDeleteId) {
                    closeVacancyDeleteModal();
                    return;
                }
                var form = document.getElementById('vacancy-delete-form');
                if (form) {
                    form.action = vacancyDeleteUrlTemplate.replace('__ID__', pendingVacancyDeleteId);
                    closeVacancyDeleteModal();
                    form.submit();
                }
            }
            window.confirmVacancyDelete = confirmVacancyDelete;

            function openVacancyBulkDeleteModal() {
                var checkboxes = document.querySelectorAll('.vacancy-row-checkbox:checked');
                var ids = Array.from(checkboxes).map(function(cb) {
                    return cb.dataset.vacancyId;
                });
                if (ids.length === 0) return;
                document.getElementById('vacancy-bulk-delete-ids').value = ids.join(',');
                document.getElementById('vacancy-bulk-delete-modal').classList.remove('hidden');
            }
            window.openVacancyBulkDeleteModal = openVacancyBulkDeleteModal;

            function closeVacancyBulkDeleteModal() {
                document.getElementById('vacancy-bulk-delete-modal').classList.add('hidden');
            }
            window.closeVacancyBulkDeleteModal = closeVacancyBulkDeleteModal;

            function confirmVacancyBulkDelete() {
                var form = document.getElementById('vacancy-bulk-delete-form');
                if (form) {
                    form.submit();
                }
            }
            window.confirmVacancyBulkDelete = confirmVacancyBulkDelete;

            // Reset button functionality and scroll handling
            document.addEventListener('DOMContentLoaded', function () {
                // Scroll to table section if status message exists (after add/edit/delete)
                @if(session('status'))
                    var tableSection = document.getElementById('vacancies-table-section');
                    if (tableSection) {
                        setTimeout(function() {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                @endif

                // Scroll to table section on search form submit
                var searchForm = document.getElementById('vacancies-search-form');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        // Add hash to URL for scrolling after page reload
                        var formAction = searchForm.getAttribute('action') || window.location.pathname;
                        var url = new URL(formAction, window.location.origin);
                        
                        // Copy existing search parameters
                        var formData = new FormData(searchForm);
                        for (var pair of formData.entries()) {
                            if (pair[1]) {
                                url.searchParams.set(pair[0], pair[1]);
                            }
                        }
                        
                        // Add hash for scrolling
                        url.hash = 'vacancies-table-section';
                        
                        // Navigate to the URL with hash
                        window.location.href = url.toString();
                    });
                }
                
                // Scroll to table section if hash exists or if search parameters are present
                if (window.location.hash === '#vacancies-table-section' || 
                    (window.location.search && (window.location.search.includes('job_title=') || 
                     window.location.search.includes('vacancy=') || 
                     window.location.search.includes('hiring_manager=') || 
                     window.location.search.includes('status=')))) {
                    var tableSection = document.getElementById('vacancies-table-section');
                    if (tableSection) {
                        setTimeout(function() {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 300);
                    }
                }

                // Reset button functionality
                if (searchForm) {
                    var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                                el.value = '';
                            });
                            window.location.href = "{{ route('recruitment.vacancies') }}";
                        });
                    }
                }
            });
        </script>
    </x-main-layout>
@endsection
