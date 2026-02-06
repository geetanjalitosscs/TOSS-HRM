@extends('layouts.app')

@section('title', 'Time - Project Info - Customers')

@section('body')
    <x-main-layout title="Project Management">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible">
                @php
                    $timesheetsItems = [
                        [
                            'url' => route('time.my-timesheets'),
                            'label' => 'My Timesheets',
                            'active' => request()->routeIs('time.my-timesheets') || request()->routeIs('time.my-timesheets.edit')
                        ],
                        [
                            'url' => route('time'),
                            'label' => 'Employee Timesheets',
                            'active' => request()->routeIs('time')
                        ]
                    ];
                    $timesheetsHasActive = collect($timesheetsItems)->contains('active', true);
                    
                    $attendanceItems = [
                        [
                            'url' => route('time.attendance.my-records'),
                            'label' => 'My Records',
                            'active' => request()->routeIs('time.attendance.my-records')
                        ],
                        [
                            'url' => route('time.attendance.punch-in-out'),
                            'label' => 'Punch In/Out',
                            'active' => request()->routeIs('time.attendance.punch-in-out')
                        ],
                        [
                            'url' => route('time.attendance.employee-records'),
                            'label' => 'Employee Records',
                            'active' => request()->routeIs('time.attendance.employee-records')
                        ],
                        [
                            'url' => route('time.attendance.configuration'),
                            'label' => 'Configuration',
                            'active' => request()->routeIs('time.attendance.configuration'),
                            'hidden' => true
                        ],
                    ];
                    $attendanceHasActive = collect($attendanceItems)->contains('active', true);
                    
                    $reportsItems = [
                        [
                            'url' => route('time.reports.project-reports'),
                            'label' => 'Project Reports',
                            'active' => request()->routeIs('time.reports.project-reports')
                        ],
                        [
                            'url' => route('time.reports.employee-reports'),
                            'label' => 'Employee Reports',
                            'active' => request()->routeIs('time.reports.employee-reports')
                        ],
                        [
                            'url' => route('time.reports.attendance-summary'),
                            'label' => 'Attendance Summary',
                            'active' => request()->routeIs('time.reports.attendance-summary')
                        ],
                    ];
                    $reportsHasActive = collect($reportsItems)->contains('active', true);
                    
                    $projectInfoItems = [
                        [
                            'url' => route('time.project-info.customers'),
                            'label' => 'Customers',
                            'active' => request()->routeIs('time.project-info.customers')
                        ],
                        [
                            'url' => route('time.project-info.projects'),
                            'label' => 'Projects',
                            'active' => request()->routeIs('time.project-info.projects')
                        ],
                    ];
                    $projectInfoHasActive = collect($projectInfoItems)->contains('active', true);
                @endphp
                {{-- <x-dropdown-menu 
                    :items="$timesheetsItems"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Timesheets</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu> --}}
                <a href="{{ route('time.project-info.customers') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.customers') ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.customers') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Customers</span>
                </a>
                <a href="{{ route('time.project-info.projects') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.projects') ? 'border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)]' : 'hover:bg-[var(--color-primary-light)]' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.projects') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Projects</span>
                </a>
            </div>
        </div>

        <!-- Customers List Section -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <!-- Header with Title and Add Button -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Customers</span>
                </h2>
                <div class="flex items-center gap-3">
                    <button
                        id="customers-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openCustomerBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button onClick="openCustomerAddModal()" />
                </div>
            </div>

            @if(isset($customers) && count($customers) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($customers)" />
            @endif

            <!-- Table -->
            <div id="customers-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="customers-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Name
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

                    <!-- Rows -->
                    <div class="border border-t-0 rounded-b-lg"
                         style="border-color: var(--border-default);">
                        @forelse($customers as $customer)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="customer-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-customer-id="{{ $customer->id }}"
                                         data-customer-name="{{ $customer->name }}"
                                         data-customer-description="{{ $customer->description ?? '' }}"
                                    >
                                        {{ $customer->name }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">
                                {{ $customer->description ?: '-' }}
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
                                No customers found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Customer Modal -->
        <x-admin.modal
            id="customer-add-modal"
            title="Add Customer"
            icon="fas fa-users"
            maxWidth="md"
            backdropOnClick="closeCustomerAddModal(true)"
        >
            <form method="POST" action="{{ route('time.project-info.customers.store') }}">
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
                        maxlength="255"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="500"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomerAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Customer Modal -->
        <x-admin.modal
            id="customer-edit-modal"
            title="Edit Customer"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeCustomerEditModal(true)"
        >
            <form method="POST" id="customer-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="customer-edit-name"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="255"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <textarea
                        name="description"
                        id="customer-edit-description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="500"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomerEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Customer Modal -->
        <x-admin.modal
            id="customer-delete-modal"
            title="Delete Customer"
            maxWidth="xs"
            backdropOnClick="closeCustomerDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this customer?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomerDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmCustomerDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Customers Modal -->
        <x-admin.modal
            id="customer-bulk-delete-modal"
            title="Delete Selected Customers"
            maxWidth="xs"
            backdropOnClick="closeCustomerBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected customers?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeCustomerBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmCustomerBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="customer-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="customer-bulk-delete-form" method="POST" action="{{ route('time.project-info.customers.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="customer-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var customerEditUrlBase = "{{ route('time.project-info.customers.update', ['id' => 0]) }}";
                var customerDeleteUrlBase = "{{ route('time.project-info.customers.delete', ['id' => 0]) }}";
                var customerEditUrlTemplate = customerEditUrlBase.replace('/0', '/__ID__');
                var customerDeleteUrlTemplate = customerDeleteUrlBase.replace('/0', '/__ID__');

                var pendingCustomerDeleteId = null;

                function openCustomerAddModal() {
                    var m = document.getElementById('customer-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openCustomerAddModal = openCustomerAddModal;

                function closeCustomerAddModal(reset) {
                    var m = document.getElementById('customer-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeCustomerAddModal = closeCustomerAddModal;

                function openCustomerEditModalFromRow(row) {
                    var info = row.querySelector('[data-customer-id]');
                    if (!info) return;

                    var id = info.dataset.customerId;
                    var name = info.dataset.customerName || '';
                    var description = info.dataset.customerDescription || '';

                    var m = document.getElementById('customer-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('customer-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('customer-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var form = document.getElementById('customer-edit-form');
                    if (form) {
                        form.action = customerEditUrlTemplate.replace('__ID__', id);
                    }
                    
                    m.classList.remove('hidden');
                }

                function closeCustomerEditModal(reset) {
                    var m = document.getElementById('customer-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeCustomerEditModal = closeCustomerEditModal;

                function openCustomerDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-customer-id]');
                    if (!info) return;

                    var id = info.dataset.customerId;
                    pendingCustomerDeleteId = id;

                    var m = document.getElementById('customer-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeCustomerDeleteModal() {
                    var m = document.getElementById('customer-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingCustomerDeleteId = null;
                }
                window.closeCustomerDeleteModal = closeCustomerDeleteModal;

                function confirmCustomerDelete() {
                    if (!pendingCustomerDeleteId) return;

                    var form = document.getElementById('customer-delete-form');
                    if (form) {
                        form.action = customerDeleteUrlTemplate.replace('__ID__', pendingCustomerDeleteId);
                        form.submit();
                    }
                }
                window.confirmCustomerDelete = confirmCustomerDelete;

                function openCustomerBulkDeleteModal() {
                    var m = document.getElementById('customer-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openCustomerBulkDeleteModal = openCustomerBulkDeleteModal;

                function closeCustomerBulkDeleteModal() {
                    var m = document.getElementById('customer-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeCustomerBulkDeleteModal = closeCustomerBulkDeleteModal;

                function confirmCustomerBulkDelete() {
                    var selectedIds = getSelectedCustomerIds();
                    if (selectedIds.length === 0) return;

                    var form = document.getElementById('customer-bulk-delete-form');
                    var idsInput = document.getElementById('customer-bulk-delete-ids');
                    if (form && idsInput) {
                        idsInput.value = selectedIds.join(',');
                        form.submit();
                    }
                }
                window.confirmCustomerBulkDelete = confirmCustomerBulkDelete;

                function getSelectedCustomerIds() {
                    var checkboxes = document.querySelectorAll('.customer-row-checkbox:checked');
                    var ids = [];
                    checkboxes.forEach(function (cb) {
                        var row = cb.closest('.hr-table-row');
                        if (row) {
                            var info = row.querySelector('[data-customer-id]');
                            if (info && info.dataset.customerId) {
                                ids.push(info.dataset.customerId);
                            }
                        }
                    });
                    return ids;
                }

                function refreshCustomerSelectionState() {
                    var selectedIds = getSelectedCustomerIds();
                    var deleteBtn = document.getElementById('customers-delete-selected');
                    var masterCheckbox = document.getElementById('customers-master-checkbox');
                    var allCheckboxes = document.querySelectorAll('.customer-row-checkbox');
                    var checkedCount = document.querySelectorAll('.customer-row-checkbox:checked').length;

                    if (deleteBtn) {
                        if (selectedIds.length > 0) {
                            deleteBtn.classList.remove('hidden');
                        } else {
                            deleteBtn.classList.add('hidden');
                                }
                            }

                    if (masterCheckbox && allCheckboxes.length > 0) {
                        if (checkedCount === allCheckboxes.length) {
                            masterCheckbox.checked = true;
                            masterCheckbox.indeterminate = false;
                        } else {
                            masterCheckbox.checked = false;
                            masterCheckbox.indeterminate = false;
                        }
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var table = document.getElementById('customers-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('customers-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.customer-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshCustomerSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#customers-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.customer-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openCustomerEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openCustomerDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshCustomerSelectionState();
                        }
                    });

                    refreshCustomerSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
