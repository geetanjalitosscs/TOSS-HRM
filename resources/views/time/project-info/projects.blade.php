@extends('layouts.app')

@section('title', 'Time - Project Info - Projects')

@section('body')
    <x-main-layout title="Project Management">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible">
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
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Timesheets</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu> --}}
                <a href="{{ route('time.project-info.customers') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.customers') ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.customers') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Customers</span>
                </a>
                <a href="{{ route('time.project-info.projects') }}" class="px-6 py-3 transition-all flex items-center {{ request()->routeIs('time.project-info.projects') ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                    <span class="text-sm {{ request()->routeIs('time.project-info.projects') ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Projects</span>
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Projects Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-purple-500"></i> Projects
                </h2>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('time.project-info.projects') }}" id="project-search-form">
                    <div class="rounded-lg p-3 mb-3 border border-purple-100" style="background-color: var(--bg-hover);">
                        <div class="flex gap-4 mb-3">
                            <!-- Customer Name -->
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Customer Name</label>
                                <input 
                                    type="text" 
                                    name="customer_name" 
                                    value="{{ request('customer_name') }}"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                    placeholder="Type for hints..."
                                >
                            </div>

                            <!-- Project -->
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Project</label>
                                <input 
                                    type="text" 
                                    name="project" 
                                    value="{{ request('project') }}"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                    placeholder="Type for hints..."
                                >
                            </div>

                            <!-- Project Admin -->
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Project Admin</label>
                                <input 
                                    type="text" 
                                    name="project_admin" 
                                    value="{{ request('project_admin') }}"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                    placeholder="Type for hints..."
                                >
                            </div>
                        </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" resetOnClick="resetProjectFilters()" />
                    </div>
                </form>
            </section>

            <!-- Projects List Card -->
            <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-project-diagram text-purple-500"></i> Projects
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="projects-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openProjectBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button label="+ Add" onClick="openProjectAddModal()" />
                </div>
            </div>

            @if(isset($projects) && count($projects) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($projects)" />
            @endif

            <!-- Table -->
            <div id="projects-table">
                <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b"
                         style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox"
                                   id="projects-master-checkbox"
                                   class="rounded w-3.5 h-3.5"
                                   style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Customer Name
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Project
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 100px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                 style="color: var(--text-primary);">
                                Project Admins
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
                        @forelse($projects as $project)
                            <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3 hr-table-row"
                                 style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                           class="project-row-checkbox rounded w-3.5 h-3.5"
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs font-medium break-words"
                                         style="color: var(--text-primary);"
                                         data-project-id="{{ $project->id }}"
                                         data-project-customer-id="{{ $project->customer_id ?? '' }}"
                                         data-project-name="{{ $project->project_name }}"
                                         data-project-description="{{ $project->description ?? '' }}"
                                    >
                                        {{ $project->customer_name ?: '-' }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $project->project_name }}
                                    </div>
                                </div>
                                <div class="flex-1" style="min-width: 100px;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ $project->admins ?: '-' }}
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
                                No projects found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
        </div>

        <!-- Add Project Modal -->
        <x-admin.modal
            id="project-add-modal"
            title="Add Project"
            icon="fas fa-project-diagram"
            maxWidth="md"
            backdropOnClick="closeProjectAddModal(true)"
        >
            <form method="POST" action="{{ route('time.project-info.projects.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Customer <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="customer_id"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Customer --</option>
                        @foreach($customers ?? [] as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Project Name <span class="text-red-500">*</span>
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
                        onclick="closeProjectAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Project Modal -->
        <x-admin.modal
            id="project-edit-modal"
            title="Edit Project"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeProjectEditModal(true)"
        >
            <form method="POST" id="project-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Customer <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="customer_id"
                        id="project-edit-customer-id"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select Customer --</option>
                        @foreach($customers ?? [] as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Project Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="project-edit-name"
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
                        id="project-edit-description"
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
                        onclick="closeProjectEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Project Modal -->
        <x-admin.modal
            id="project-delete-modal"
            title="Delete Project"
            maxWidth="xs"
            backdropOnClick="closeProjectDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this project?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeProjectDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmProjectDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Projects Modal -->
        <x-admin.modal
            id="project-bulk-delete-modal"
            title="Delete Selected Projects"
            maxWidth="xs"
            backdropOnClick="closeProjectBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected projects?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeProjectBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmProjectBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="project-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="project-bulk-delete-form" method="POST" action="{{ route('time.project-info.projects.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="project-bulk-delete-ids" value="">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle tab hover and open states
                const tabTriggers = document.querySelectorAll('.tab-trigger');
                
                tabTriggers.forEach(trigger => {
                    const group = trigger.closest('.group');
                    const dropdown = group?.querySelector('.hr-dropdown-menu');
                    const isActive = trigger.classList.contains('border-b-2');
                    
                    if (isActive) {
                        trigger.dataset.hasActive = 'true';
                    }
                    
                    // Hover effect - add border on hover
                    trigger.addEventListener('mouseenter', function() {
                        if (!this.dataset.hasActive) {
                            this.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                            this.classList.remove('hover:bg-purple-50/30');
                            const span = this.querySelector('span:first-of-type');
                            if (span) {
                                span.classList.remove('font-medium', 'text-slate-700');
                                span.classList.add('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                            }
                        }
                    });
                    
                    // Remove border on mouse leave only if not active and not open
                    trigger.addEventListener('mouseleave', function() {
                        if (!this.dataset.hasActive) {
                            const isOpen = dropdown?.classList.contains('show');
                            if (!isOpen) {
                                this.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                this.classList.add('hover:bg-purple-50/30');
                                const span = this.querySelector('span:first-of-type');
                                if (span) {
                                    span.classList.remove('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                    span.classList.add('font-medium', 'text-slate-700');
                                }
                            }
                        }
                    });
                });
                
                // Keep border when dropdown is open
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            const dropdown = mutation.target;
                            if (dropdown.classList.contains('hr-dropdown-menu')) {
                                const trigger = dropdown.closest('.group')?.querySelector('.tab-trigger');
                                if (trigger) {
                                    if (dropdown.classList.contains('show')) {
                                        // Dropdown opened - add border
                                        trigger.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.remove('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                            span.classList.remove('font-medium', 'text-slate-700');
                                            span.classList.add('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                        }
                                    } else if (!trigger.dataset.hasActive) {
                                        // Dropdown closed - remove border only if not active
                                        trigger.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.add('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                            span.classList.remove('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                            span.classList.add('font-medium', 'text-slate-700');
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
                
                document.querySelectorAll('.hr-dropdown-menu').forEach(menu => {
                    observer.observe(menu, { attributes: true, attributeFilter: ['class'] });
                });
            });
        </script>

        <script>
            (function () {
                var projectEditUrlBase = "{{ route('time.project-info.projects.update', ['id' => 0]) }}";
                var projectDeleteUrlBase = "{{ route('time.project-info.projects.delete', ['id' => 0]) }}";
                var projectEditUrlTemplate = projectEditUrlBase.replace('/0', '/__ID__');
                var projectDeleteUrlTemplate = projectDeleteUrlBase.replace('/0', '/__ID__');

                var pendingProjectDeleteId = null;

                function openProjectAddModal() {
                    var m = document.getElementById('project-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openProjectAddModal = openProjectAddModal;

                function closeProjectAddModal(reset) {
                    var m = document.getElementById('project-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeProjectAddModal = closeProjectAddModal;

                function openProjectEditModalFromRow(row) {
                    var info = row.querySelector('[data-project-id]');
                    if (!info) return;

                    var id = info.dataset.projectId;
                    var customerId = info.dataset.projectCustomerId || '';
                    var name = info.dataset.projectName || '';
                    var description = info.dataset.projectDescription || '';

                    var m = document.getElementById('project-edit-modal');
                    if (!m) return;

                    var customerSelect = document.getElementById('project-edit-customer-id');
                    if (customerSelect) customerSelect.value = customerId;

                    var nameInput = document.getElementById('project-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('project-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var form = document.getElementById('project-edit-form');
                    if (form) {
                        form.action = projectEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }

                function closeProjectEditModal(reset) {
                    var m = document.getElementById('project-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeProjectEditModal = closeProjectEditModal;

                function openProjectDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-project-id]');
                    if (!info) return;

                    var id = info.dataset.projectId;
                    pendingProjectDeleteId = id;

                    var m = document.getElementById('project-delete-modal');
                    if (m) m.classList.remove('hidden');
                }

                function closeProjectDeleteModal() {
                    var m = document.getElementById('project-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingProjectDeleteId = null;
                }
                window.closeProjectDeleteModal = closeProjectDeleteModal;

                function confirmProjectDelete() {
                    if (!pendingProjectDeleteId) return;

                    var form = document.getElementById('project-delete-form');
                    if (form) {
                        form.action = projectDeleteUrlTemplate.replace('__ID__', pendingProjectDeleteId);
                        form.submit();
                    }
                }
                window.confirmProjectDelete = confirmProjectDelete;

                function openProjectBulkDeleteModal() {
                    var m = document.getElementById('project-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openProjectBulkDeleteModal = openProjectBulkDeleteModal;

                function closeProjectBulkDeleteModal() {
                    var m = document.getElementById('project-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeProjectBulkDeleteModal = closeProjectBulkDeleteModal;

                function confirmProjectBulkDelete() {
                    var selectedIds = getSelectedProjectIds();
                    if (selectedIds.length === 0) return;

                    var form = document.getElementById('project-bulk-delete-form');
                    var idsInput = document.getElementById('project-bulk-delete-ids');
                    if (form && idsInput) {
                        idsInput.value = selectedIds.join(',');
                        form.submit();
                    }
                }
                window.confirmProjectBulkDelete = confirmProjectBulkDelete;

                function getSelectedProjectIds() {
                    var checkboxes = document.querySelectorAll('.project-row-checkbox:checked');
                    var ids = [];
                    checkboxes.forEach(function (cb) {
                        var row = cb.closest('.hr-table-row');
                        if (row) {
                            var info = row.querySelector('[data-project-id]');
                            if (info && info.dataset.projectId) {
                                ids.push(info.dataset.projectId);
                            }
                        }
                    });
                    return ids;
                }

                function refreshProjectSelectionState() {
                    var selectedIds = getSelectedProjectIds();
                    var deleteBtn = document.getElementById('projects-delete-selected');
                    var masterCheckbox = document.getElementById('projects-master-checkbox');
                    var allCheckboxes = document.querySelectorAll('.project-row-checkbox');
                    var checkedCount = document.querySelectorAll('.project-row-checkbox:checked').length;

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

                function resetProjectFilters() {
                    var searchForm = document.getElementById('project-search-form');
                    if (searchForm) {
                        var inputs = searchForm.querySelectorAll('input[name], select[name]');
                        inputs.forEach(function (input) {
                            input.value = '';
                        });
                        window.location.href = "{{ route('time.project-info.projects') }}";
                    }
                }
                window.resetProjectFilters = resetProjectFilters;

                document.addEventListener('DOMContentLoaded', function () {
                    var table = document.getElementById('projects-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('projects-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.project-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshProjectSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#projects-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.project-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openProjectEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openProjectDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshProjectSelectionState();
                        }
                    });

                    refreshProjectSelectionState();
                });
            })();
        </script>
    </x-main-layout>
@endsection
