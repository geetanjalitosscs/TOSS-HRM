@extends('layouts.app')

@section('title', 'Performance - KPIs')

@section('body')
    <x-main-layout title="Performance">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible flex-nowrap">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs', 'active' => true],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)] cursor-pointer flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Configure</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance'), 'label' => 'Manage Reviews'],
                        ['url' => route('performance.my-reviews'), 'label' => 'My Reviews'],
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Manage Reviews</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">My Trackers</span>
                </a>
                <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                </a>
            </div>
        </div>

        <!-- Key Performance Indicators Section -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-bullseye text-[var(--color-primary)]"></i> <span class="mt-0.5">Key Performance Indicators (KPIs)</span>
            </h2>

            <!-- Search Panel -->
            <form method="GET" action="{{ route('performance.kpis') }}" id="kpis-search-form">
            <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Key Performance Indicator</label>
                            <input
                                type="text"
                                name="indicator"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                placeholder="Enter KPI name..."
                                value="{{ request('indicator') }}"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Description</label>
                            <input
                                type="text"
                                name="job_title"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                placeholder="Enter description..."
                                value="{{ request('job_title') }}"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Min Rate From</label>
                            <input
                                type="number"
                                step="1"
                                name="min_rate"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                placeholder="0"
                                value="{{ request('min_rate') }}"
                            >
                        </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Min Rate To</label>
                                <input
                                    type="number"
                                    step="1"
                                    name="max_rate"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    placeholder="100"
                                    value="{{ request('max_rate') }}"
                                >
                            </div>
                    </div>
                    <x-admin.action-buttons resetType="button" searchType="submit" />
                </div>
            </form>
        </section>

        <!-- KPIs Table Section -->
        <section class="hr-card p-6">
            @if(count($kpis) > 0)
            <!-- Records Count + Actions -->
            <div class="flex items-center justify-between mb-2">
                <x-records-found :count="count($kpis)" />
                <div class="flex items-center gap-3">
                    <button
                        id="kpis-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openKpiBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button label="+ Add" onClick="openKpiAddModal()" />
                </div>
            </div>

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" id="kpis-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                        Key Performance Indicator
                    </span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                        Description
                    </span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Min Rate</span>
                </div>
                <div class="flex-shrink-0" style="width: 90px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($kpis as $kpi)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input
                            type="checkbox"
                            class="kpi-row-checkbox rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                            data-kpi-checkbox-id="{{ $kpi->id }}"
                        >
                    </div>
                    <div class="flex-1" style="min-width: 0;"
                         data-kpi-id="{{ $kpi->id }}"
                         data-kpi-name="{{ $kpi->name }}"
                         data-kpi-description="{{ $kpi->description }}"
                         data-kpi-weight="{{ $kpi->weight }}"
                    >
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $kpi->name }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $kpi->description }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ (int) $kpi->weight }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="flex items-center justify-center gap-2">
                            <button class="hr-action-edit flex-shrink-0" title="Edit" type="button" onclick="openKpiEditModalFromRow(this.closest('.border-b'))">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="hr-action-delete flex-shrink-0" title="Delete" type="button" onclick="openKpiDeleteModalFromRow(this.closest('.border-b'))">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- No Records Found -->
            <div class="flex items-center justify-between mb-2">
                <x-records-found :count="0" />
                <x-admin.add-button label="+ Add" onClick="openKpiAddModal()" />
            </div>

            <!-- Empty table structure to match other pages -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" disabled>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                        Key Performance Indicator
                    </span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                        Description
                    </span>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                        Min Rate
                    </span>
                </div>
                <div class="flex-shrink-0" style="width: 90px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">
                        Actions
                    </div>
                </div>
            </div>
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                <div class="px-4 py-6 text-center text-xs" style="color: var(--text-muted);">
                    No records found.
                </div>
            </div>
            @endif
        </section>

        <!-- Add KPI Modal -->
        <x-admin.modal
            id="kpi-add-modal"
            title="Add KPI"
            icon="fas fa-bullseye"
            maxWidth="md"
            backdropOnClick="closeKpiAddModal(true)"
        >
            <form method="POST" action="{{ route('performance.kpis.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Key Performance Indicator <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        type="text"
                        name="description"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Min Rate <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        step="1"
                        name="weight"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        min="0"
                    >
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeKpiAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit KPI Modal -->
        <x-admin.modal
            id="kpi-edit-modal"
            title="Edit KPI"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeKpiEditModal(true)"
        >
            <form method="POST" id="kpi-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Key Performance Indicator <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="kpi-edit-name"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        type="text"
                        name="description"
                        id="kpi-edit-description"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                        autocomplete="off"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Min Rate <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        step="1"
                        name="weight"
                        id="kpi-edit-weight"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        min="0"
                    >
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeKpiEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete KPI Modal -->
        <x-admin.modal
            id="kpi-delete-modal"
            title="Delete KPI"
            icon="fas fa-trash-alt"
            maxWidth="sm"
            backdropOnClick="closeKpiDeleteModal()"
        >
            <form method="POST" id="kpi-delete-form" action="#">
                @csrf
                <p class="text-xs mb-4" style="color: var(--text-primary);">
                    Are you sure you want to delete this KPI? This action cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeKpiDeleteModal()">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">Delete</button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Bulk Delete KPI Modal -->
        <x-admin.modal
            id="kpi-bulk-delete-modal"
            title="Delete Selected KPIs"
            icon="fas fa-trash-alt"
            maxWidth="sm"
            backdropOnClick="closeKpiBulkDeleteModal()"
        >
            <form method="POST" id="kpi-bulk-delete-form" action="{{ route('performance.kpis.bulk-delete') }}">
                @csrf
                <input type="hidden" name="ids" id="kpi-bulk-delete-ids">
                <p class="text-xs mb-4" style="color: var(--text-primary);">
                    Are you sure you want to delete the selected KPIs? This action cannot be undone.
                </p>
            <div class="flex justify-end gap-2">
                    <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeKpiBulkDeleteModal()">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">Delete</button>
                </div>
            </form>
        </x-admin.modal>

        <script>
            (function () {
                var kpiEditUrlTemplate = "{{ route('performance.kpis.update', ['id' => '__ID__']) }}";
                var kpiDeleteUrlTemplate = "{{ route('performance.kpis.delete', ['id' => '__ID__']) }}";
                var pendingKpiDeleteId = null;

                function refreshKpiSelectionState() {
                    var checkboxes = document.querySelectorAll('.kpi-row-checkbox');
                    var master = document.getElementById('kpis-master-checkbox');
                    var deleteSelectedBtn = document.getElementById('kpis-delete-selected');

                    var total = checkboxes.length;
                    var checked = 0;
                    checkboxes.forEach(function (cb) {
                        if (cb.checked && !cb.disabled) checked++;
                    });

                    if (master) {
                        if (total === 0 || checked === 0) {
                            master.checked = false;
                        } else if (checked === total) {
                            master.checked = true;
                        }
                        // Minus / intermediate icon disable
                        master.indeterminate = false;
                    }

                    if (deleteSelectedBtn) {
                        deleteSelectedBtn.classList.toggle('hidden', checked === 0);
                    }
                }

                function setupKpiCheckboxes() {
                    var master = document.getElementById('kpis-master-checkbox');
                    var checkboxes = document.querySelectorAll('.kpi-row-checkbox');

                    if (master) {
                        master.addEventListener('change', function () {
                            var checked = master.checked;
                            checkboxes.forEach(function (cb) {
                                if (!cb.disabled) {
                                    cb.checked = checked;
                                }
                            });
                            refreshKpiSelectionState();
                        });
                    }

                    checkboxes.forEach(function (cb) {
                        cb.addEventListener('change', refreshKpiSelectionState);
                    });

                    refreshKpiSelectionState();
                }

                function openKpiAddModal() {
                    var m = document.getElementById('kpi-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openKpiAddModal = openKpiAddModal;

                function closeKpiAddModal(reset) {
                    var m = document.getElementById('kpi-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeKpiAddModal = closeKpiAddModal;

                function openKpiEditModalFromRow(row) {
                    var info = row.querySelector('[data-kpi-id]');
                    if (!info) return;

                    var id = info.dataset.kpiId;
                    var name = info.dataset.kpiName || '';
                    var description = info.dataset.kpiDescription || '';
                    var weight = info.dataset.kpiWeight || '';

                    var m = document.getElementById('kpi-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('kpi-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descInput = document.getElementById('kpi-edit-description');
                    if (descInput) descInput.value = description;

                    var weightInput = document.getElementById('kpi-edit-weight');
                    if (weightInput) weightInput.value = weight;

                    var form = document.getElementById('kpi-edit-form');
                    if (form) {
                        form.action = kpiEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openKpiEditModalFromRow = openKpiEditModalFromRow;

                function closeKpiEditModal(reset) {
                    var m = document.getElementById('kpi-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeKpiEditModal = closeKpiEditModal;

                function openKpiDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-kpi-id]');
                    if (!info) return;

                    pendingKpiDeleteId = info.dataset.kpiId || null;
                    var m = document.getElementById('kpi-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openKpiDeleteModalFromRow = openKpiDeleteModalFromRow;

                function closeKpiDeleteModal() {
                    var m = document.getElementById('kpi-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingKpiDeleteId = null;
                }
                window.closeKpiDeleteModal = closeKpiDeleteModal;

                document.getElementById('kpi-delete-form').addEventListener('submit', function (e) {
                    if (!pendingKpiDeleteId) {
                        e.preventDefault();
                        closeKpiDeleteModal();
                        return;
                    }
                    this.action = kpiDeleteUrlTemplate.replace('__ID__', pendingKpiDeleteId);
                });

                function openKpiBulkDeleteModal() {
                    var m = document.getElementById('kpi-bulk-delete-modal');
                    if (!m) return;

                    var idsInput = document.getElementById('kpi-bulk-delete-ids');
                    if (!idsInput) return;

                    var ids = [];
                    document.querySelectorAll('.kpi-row-checkbox').forEach(function (cb) {
                        if (cb.checked && cb.dataset.kpiCheckboxId) {
                            ids.push(cb.dataset.kpiCheckboxId);
                        }
                    });

                    if (ids.length === 0) {
                        closeKpiBulkDeleteModal();
                        return;
                    }

                    idsInput.value = ids.join(',');
                    m.classList.remove('hidden');
                }
                window.openKpiBulkDeleteModal = openKpiBulkDeleteModal;

                function closeKpiBulkDeleteModal() {
                    var m = document.getElementById('kpi-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                    var idsInput = document.getElementById('kpi-bulk-delete-ids');
                    if (idsInput) idsInput.value = '';
                }
                window.closeKpiBulkDeleteModal = closeKpiBulkDeleteModal;

                // Setup search reset
                var searchForm = document.getElementById('kpis-search-form');
                if (searchForm) {
                    var resetBtn = searchForm.querySelector('button[type="button"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function () {
                            searchForm.querySelectorAll('input').forEach(function (input) {
                                input.value = '';
                            });
                            searchForm.submit();
                        });
                    }
                }

                // Initialize
                setupKpiCheckboxes();
            })();
        </script>
    </x-main-layout>
@endsection

