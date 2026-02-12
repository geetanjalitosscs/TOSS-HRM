@extends('layouts.app')

@section('title', 'Recruitment - Candidates')

@section('body')
    <x-main-layout title="Recruitment">
        <x-recruitment.tabs activeTab="candidates" />

        <div class="space-y-6">
            <!-- Candidate Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-[var(--color-primary)]"></i> Candidate Search
                </h2>

                <form id="candidates-search-form" method="GET" action="{{ route('recruitment') }}">
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
                                <select name="vacancy" class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    @foreach($vacancies ?? [] as $vacancy)
                                        <option value="{{ $vacancy->id }}" {{ request('vacancy') == $vacancy->id ? 'selected' : '' }}>{{ $vacancy->name }}</option>
                                    @endforeach
                        </select>
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
                                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Application Initiated</option>
                                    <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="interview_scheduled" {{ request('status') == 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                                    <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Offered</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Candidate Name</label>
                                <input type="text" name="candidate_name" class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints..." value="{{ request('candidate_name') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Keywords</label>
                                <input type="text" name="keywords" class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Enter comma separated words..." value="{{ request('keywords') }}">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Date of Application</label>
                        <div class="flex gap-2">
                                    <x-date-picker name="from_date" :value="request('from_date')" placeholder="From" wrapperClass="flex-1" />
                                    <x-date-picker name="to_date" :value="request('to_date')" placeholder="To" wrapperClass="flex-1" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Method of Application</label>
                                <select name="method" class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    <option value="online" {{ request('method') == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="email" {{ request('method') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="walk-in" {{ request('method') == 'walk-in' ? 'selected' : '' }}>Walk-in</option>
                                    <option value="referral" {{ request('method') == 'referral' ? 'selected' : '' }}>Referral</option>
                        </select>
                    </div>
                </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" />
            </div>
                </form>
            </section>

            <!-- Candidate List Card -->
            <section id="candidates-table-section" class="hr-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-user-tie text-[var(--color-primary)]"></i> Candidate List
                    </h2>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="candidates-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openCandidateBulkDeleteModal()"
                        >
                            <i class="fas fa-trash-alt mr-2"></i>Delete Selected
                        </button>
                        <x-admin.add-button class="mb-0" onClick="openCandidateAddModal()" />
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

                <!-- Records Count -->
                <x-records-found :count="count($candidates)" />

                <!-- Table Wrapper -->
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto; overflow-x: hidden;">
                <!-- Table Header -->
                <div class="rounded-t-lg border border-b-0 px-2 py-1.5 mb-0" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex items-center gap-1">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" 
                                   id="candidates-master-checkbox"
                                   class="rounded w-3.5 h-3.5" 
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" 
                                   onfocus="this.style.outline='2px solid var(--color-hr-primary)'" 
                                   onblur="this.style.outline='none'">
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Vacancy</span>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Candidate</span>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Hiring Manager</span>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Date of Application</span>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</span>
                        </div>
                        <div class="flex-shrink-0" style="width: 160px;">
                            <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</span>
                        </div>
                    </div>
                </div>

                <!-- Candidate Rows -->
                <div class="border border-t-0 rounded-b-lg" id="candidates-table" style="border-color: var(--border-default);">
                @forelse($candidates as $index => $candidate)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors hr-table-row" 
                         style="background-color: var(--bg-card); border-color: var(--border-default);" 
                         onmouseover="this.style.backgroundColor='var(--bg-hover)'" 
                         onmouseout="this.style.backgroundColor='var(--bg-card)'"
                         data-candidate-id="{{ $candidate->id }}"
                         data-candidate-vacancy="{{ $candidate->vacancy }}"
                         data-candidate-vacancy-id="{{ $candidate->vacancy_id ?? '' }}"
                         data-candidate-name="{{ $candidate->candidate }}"
                         data-candidate-manager="{{ $candidate->hiring_manager }}"
                         data-candidate-date="{{ $candidate->date }}"
                         data-candidate-status="{{ $candidate->status }}">
                        <div class="flex items-center gap-1">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" 
                                       class="candidate-row-checkbox rounded w-3.5 h-3.5" 
                                       style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" 
                                       data-candidate-id="{{ $candidate->id }}"
                                       onfocus="this.style.outline='2px solid var(--color-hr-primary)'" 
                                       onblur="this.style.outline='none'">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate->vacancy ?: '-' }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate->candidate }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate->hiring_manager }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate->date }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="px-1.5 py-0.5 text-xs rounded-full 
                                    @if($candidate->status_display === 'Shortlisted') bg-green-100 text-green-700
                                    @elseif($candidate->status_display === 'Interview Scheduled') bg-yellow-100 text-yellow-700
                                    @elseif($candidate->status_display === 'Offered') bg-purple-100 text-purple-700
                                    @elseif($candidate->status_display === 'Hired') bg-emerald-100 text-emerald-700
                                    @elseif($candidate->status_display === 'Rejected') bg-red-100 text-red-700
                                    @else bg-blue-100 text-blue-700
                                    @endif">
                                    {{ $candidate->status_display }}
                                </span>
                            </div>
                            <div class="flex-shrink-0" style="width: 160px;">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="hr-action-edit flex-shrink-0" title="Edit"
                                            onclick="event.preventDefault(); event.stopPropagation(); openCandidateEditModalFromRow(this.closest('.hr-table-row'));">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button class="hr-action-delete flex-shrink-0" title="Delete"
                                            onclick="event.preventDefault(); event.stopPropagation(); openCandidateDeleteModalFromRow(this.closest('.hr-table-row'));">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                        No candidates found.
                    </div>
                @endforelse
                </div>
            </div>
            </section>
        </div>

        <!-- Add Candidate Modal -->
        <x-admin.modal
            id="candidate-add-modal"
            title="Add Candidate Application"
            icon="fas fa-user-tie"
            maxWidth="md"
            backdropOnClick="closeCandidateAddModal(true)"
        >
            <form method="POST" action="{{ route('recruitment.candidates.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Vacancy <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="vacancy_id"
                        id="candidate-add-vacancy-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Vacancy --</option>
                        @foreach($vacancies ?? [] as $vacancy)
                            <option value="{{ $vacancy->id }}">{{ $vacancy->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="first_name"
                        id="candidate-add-first-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Last Name
                    </label>
                    <input
                        type="text"
                        name="last_name"
                        id="candidate-add-last-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="100"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="candidate-add-email"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="191"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="candidate-add-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="new">Application Initiated</option>
                        <option value="shortlisted">Shortlisted</option>
                        <option value="interview_scheduled">Interview Scheduled</option>
                        <option value="offered">Offered</option>
                        <option value="rejected">Rejected</option>
                        <option value="hired">Hired</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCandidateAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Candidate Modal -->
        <x-admin.modal
            id="candidate-edit-modal"
            title="Edit Candidate Application"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeCandidateEditModal(true)"
        >
            <form method="POST" id="candidate-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Vacancy <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="vacancy_id"
                        id="candidate-edit-vacancy-id"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Vacancy --</option>
                        @foreach($vacancies ?? [] as $vacancy)
                            <option value="{{ $vacancy->id }}">{{ $vacancy->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Candidate Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="candidate_name"
                        id="candidate-edit-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="200"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="candidate-edit-status"
                        class="hr-select px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="new">Application Initiated</option>
                        <option value="shortlisted">Shortlisted</option>
                        <option value="interview_scheduled">Interview Scheduled</option>
                        <option value="offered">Offered</option>
                        <option value="rejected">Rejected</option>
                        <option value="hired">Hired</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCandidateEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Candidate Modal -->
        <x-admin.modal
            id="candidate-delete-modal"
            title="Delete Candidate Application"
            maxWidth="xs"
            backdropOnClick="closeCandidateDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this candidate application?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCandidateDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmCandidateDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Candidates Modal -->
        <x-admin.modal
            id="candidate-bulk-delete-modal"
            title="Delete Selected Candidates"
            maxWidth="xs"
            backdropOnClick="closeCandidateBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected candidate applications?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCandidateBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmCandidateBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- View Candidate Modal -->
        <x-admin.modal
            id="candidate-view-modal"
            title="View Candidate Application"
            icon="fas fa-eye"
            maxWidth="lg"
            backdropOnClick="closeCandidateViewModal()"
        >
            <div id="candidate-view-content">
                <p class="text-xs" style="color: var(--text-muted);">Loading...</p>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="candidate-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="candidate-bulk-delete-form" method="POST" action="{{ route('recruitment.candidates.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="candidate-bulk-delete-ids" value="">
        </form>

        <script>
            var candidateEditUrlTemplate = "{{ route('recruitment.candidates.update', ['id' => '__ID__']) }}";
            var candidateDeleteUrlTemplate = "{{ route('recruitment.candidates.delete', ['id' => '__ID__']) }}";
            var pendingCandidateDeleteId = null;

            (function () {

                function refreshCandidateSelectionState() {
                    var table = document.getElementById('candidates-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('candidates-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.candidate-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('candidates-delete-selected');

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
                    var table = document.getElementById('candidates-table');
                    if (!table) return;

                    var masterCheckbox = document.getElementById('candidates-master-checkbox');
                    if (masterCheckbox && !masterCheckbox.dataset.listenerAttached) {
                        masterCheckbox.dataset.listenerAttached = 'true';
                        masterCheckbox.addEventListener('change', function () {
                            var allRowCheckboxes = table.querySelectorAll('.candidate-row-checkbox');
                            allRowCheckboxes.forEach(function (cb) {
                                cb.checked = masterCheckbox.checked;
                            });
                            refreshCandidateSelectionState();
                        });
                    }
                }

                setupCheckboxes();

                var table = document.getElementById('candidates-table');
                if (table) {
                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#candidates-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.candidate-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openCandidateEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openCandidateDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshCandidateSelectionState();
                        }
                    });
                }

                refreshCandidateSelectionState();
            })();

            function openCandidateAddModal() {
                document.getElementById('candidate-add-modal').classList.remove('hidden');
                document.getElementById('candidate-add-vacancy-id').focus();
            }
            window.openCandidateAddModal = openCandidateAddModal;

            function closeCandidateAddModal(reset) {
                var m = document.getElementById('candidate-add-modal');
                if (m) {
                    m.classList.add('hidden');
                }
                if (reset) {
                    var form = m ? m.querySelector('form') : null;
                    if (form) form.reset();
                }
            }
            window.closeCandidateAddModal = closeCandidateAddModal;

            function openCandidateEditModalFromRow(row) {
                var candidateId = row.dataset.candidateId;
                var vacancyId = row.dataset.candidateVacancyId || '';
                var candidateName = row.dataset.candidateName || '';
                var status = row.dataset.candidateStatus || 'new';

                var form = document.getElementById('candidate-edit-form');
                if (form) {
                    form.action = candidateEditUrlTemplate.replace('__ID__', candidateId);
                }

                var nameInput = document.getElementById('candidate-edit-name');
                if (nameInput) {
                    nameInput.value = candidateName;
                }

                var statusSelect = document.getElementById('candidate-edit-status');
                if (statusSelect) {
                    statusSelect.value = status.toLowerCase().replace(' ', '_');
                }

                var vacancySelect = document.getElementById('candidate-edit-vacancy-id');
                if (vacancySelect) {
                    vacancySelect.value = vacancyId;
                }

                document.getElementById('candidate-edit-modal').classList.remove('hidden');
                if (nameInput) nameInput.focus();
            }
            window.openCandidateEditModalFromRow = openCandidateEditModalFromRow;

            function closeCandidateEditModal(reset) {
                var m = document.getElementById('candidate-edit-modal');
                if (m) {
                    m.classList.add('hidden');
                }
                if (reset) {
                    var form = m ? m.querySelector('form') : null;
                    if (form) form.reset();
                }
            }
            window.closeCandidateEditModal = closeCandidateEditModal;

            function openCandidateDeleteModalFromRow(row) {
                pendingCandidateDeleteId = row.dataset.candidateId;
                document.getElementById('candidate-delete-modal').classList.remove('hidden');
            }
            window.openCandidateDeleteModalFromRow = openCandidateDeleteModalFromRow;

            function closeCandidateDeleteModal() {
                document.getElementById('candidate-delete-modal').classList.add('hidden');
                pendingCandidateDeleteId = null;
            }
            window.closeCandidateDeleteModal = closeCandidateDeleteModal;

            function confirmCandidateDelete() {
                if (!pendingCandidateDeleteId) {
                    closeCandidateDeleteModal();
                    return;
                }
                var form = document.getElementById('candidate-delete-form');
                if (form) {
                    form.action = candidateDeleteUrlTemplate.replace('__ID__', pendingCandidateDeleteId);
                    closeCandidateDeleteModal();
                    form.submit();
                }
            }
            window.confirmCandidateDelete = confirmCandidateDelete;

            function openCandidateBulkDeleteModal() {
                var checkboxes = document.querySelectorAll('.candidate-row-checkbox:checked');
                var ids = Array.from(checkboxes).map(function(cb) {
                    return cb.dataset.candidateId;
                });
                if (ids.length === 0) return;
                document.getElementById('candidate-bulk-delete-ids').value = ids.join(',');
                document.getElementById('candidate-bulk-delete-modal').classList.remove('hidden');
            }
            window.openCandidateBulkDeleteModal = openCandidateBulkDeleteModal;

            function closeCandidateBulkDeleteModal() {
                document.getElementById('candidate-bulk-delete-modal').classList.add('hidden');
            }
            window.closeCandidateBulkDeleteModal = closeCandidateBulkDeleteModal;

            function confirmCandidateBulkDelete() {
                var form = document.getElementById('candidate-bulk-delete-form');
                if (form) {
                    form.submit();
                }
            }
            window.confirmCandidateBulkDelete = confirmCandidateBulkDelete;

            function openCandidateViewModal(candidateId) {
                document.getElementById('candidate-view-modal').classList.remove('hidden');
                document.getElementById('candidate-view-content').innerHTML = '<p class="text-xs" style="color: var(--text-muted);">Loading...</p>';
                // TODO: Fetch candidate details via AJAX and populate modal
            }
            window.openCandidateViewModal = openCandidateViewModal;

            function closeCandidateViewModal() {
                document.getElementById('candidate-view-modal').classList.add('hidden');
            }
            window.closeCandidateViewModal = closeCandidateViewModal;

            // Reset button functionality and scroll handling
            document.addEventListener('DOMContentLoaded', function () {
                // Scroll to table section if status message exists (after add/edit/delete)
                @if(session('status'))
                    var tableSection = document.getElementById('candidates-table-section');
                    if (tableSection) {
                        setTimeout(function() {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                @endif

                // Scroll to table section on search form submit
                var searchForm = document.getElementById('candidates-search-form');
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
                        url.hash = 'candidates-table-section';
                        
                        // Navigate to the URL with hash
                        window.location.href = url.toString();
                    });
                }
                
                // Scroll to table section if hash exists or if search parameters are present
                if (window.location.hash === '#candidates-table-section' || 
                    (window.location.search && (window.location.search.includes('job_title=') || 
                     window.location.search.includes('vacancy=') || 
                     window.location.search.includes('hiring_manager=') || 
                     window.location.search.includes('status=') ||
                     window.location.search.includes('candidate_name=') ||
                     window.location.search.includes('from_date=') ||
                     window.location.search.includes('to_date=')))) {
                    var tableSection = document.getElementById('candidates-table-section');
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
                                if (el.type === 'date') {
                                    el.value = '';
                                } else {
                                    el.value = '';
                                }
                            });
                            window.location.href = "{{ route('recruitment') }}";
                        });
                    }
                }
            });
        </script>
    </x-main-layout>
@endsection

