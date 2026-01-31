@extends('layouts.app')

@section('title', 'Claim - Configuration - Events')

@section('body')
    <x-main-layout title="Claim">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible flex-nowrap" style="border-color: var(--border-default);">
                <div class="relative group" onclick="toggleDropdown(event)" style="overflow: visible;">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center justify-between gap-2" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <span class="text-sm font-medium" style="color: var(--text-primary);">Configuration</span>
                        <x-dropdown-arrow color="#a78bfa" class="flex-shrink-0" />
                    </div>
                    <div class="hr-dropdown-menu absolute top-full left-0 mt-0 w-48" style="z-index: 9999; display: none; background-color: var(--bg-card); border: 1px solid var(--border-default); border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding: 0.5rem 0;">
                        <a href="{{ route('claim.configuration.events') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary); background-color: var(--bg-hover);">
                            Events
                        </a>
                        <a href="{{ route('claim.configuration.expenses-types') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
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
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- Events Configuration Section -->
        <div>
            <section class="hr-card p-6 mb-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-alt" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Events</span>
                </h2>

                <!-- Search/Filter Section -->
                <form method="GET" action="{{ route('claim.configuration.events') }}" id="events-search-form">
                    <x-admin.search-panel title="" :collapsed="false" :collapsible="false">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Event Name</label>
                                <input 
                                    type="text" 
                                    name="event_name"
                                    value="{{ request('event_name') }}"
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

            <!-- Events Table Section -->
            <section id="events-table-section" class="hr-card p-6">
                @if(session('status'))
                    <div class="mb-4 px-3 py-2 rounded border text-xs" style="background-color: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.3); color: rgb(22, 163, 74);">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-purple-500"></i> Events
                    </h2>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="events-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openEventBulkDeleteModal()"
                        >
                            Delete Selected
                        </button>
                        <x-admin.add-button class="mb-0" onClick="openEventAddModal()" />
                    </div>
                </div>

                @if(isset($events) && count($events) > 0)
                <!-- Records Count -->
                <x-records-found :count="count($events)" />
                @endif

                <!-- Table Wrapper -->
                <div id="events-table">
                <div class="hr-table-wrapper">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" id="events-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                                Event Name
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                                    Description
                                </div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">
                                    Max Amount
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

                    <!-- Events List -->
                    <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                            @forelse($events as $event)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                            <!-- Checkbox -->
                            <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="event-row-checkbox rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                            </div>
                            
                            <!-- Event Name -->
                            <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" 
                                         style="color: var(--text-primary);"
                                         data-event-id="{{ $event->id }}"
                                         data-event-name="{{ $event->name }}"
                                         data-event-description="{{ $event->description ?? '' }}"
                                         data-event-max-amount="{{ $event->max_amount ?? '' }}"
                                         data-event-status="{{ $event->status }}"
                                    >
                                        {{ $event->name }}
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $event->description ?: '-' }}</div>
                                </div>
                                
                                <!-- Max Amount -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        @if($event->max_amount)
                                            {{ $event->max_amount == floor($event->max_amount) ? number_format($event->max_amount, 0) : number_format($event->max_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $event->status }}</div>
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
                                    No events found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Add Event Modal -->
        <x-admin.modal
            id="event-add-modal"
            title="Add Event"
            icon="fas fa-calendar-plus"
            maxWidth="md"
            backdropOnClick="closeEventAddModal(true)"
        >
            <form method="POST" action="{{ route('claim.configuration.events.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Event Name <span class="text-red-500">*</span>
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
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Max Amount
                    </label>
                    <input
                        type="number"
                        name="max_amount"
                        step="1"
                        min="0"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        placeholder="0"
                        onkeydown="return event.key !== '.' && event.key !== ',' && (event.key === 'Backspace' || event.key === 'Delete' || event.key === 'Tab' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || /[0-9]/.test(event.key));"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
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
                        onclick="closeEventAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit Event Modal -->
        <x-admin.modal
            id="event-edit-modal"
            title="Edit Event"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeEventEditModal(true)"
        >
            <form method="POST" id="event-edit-form" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Event Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="event-edit-name"
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
                        id="event-edit-description"
                        rows="3"
                        class="hr-input px-3 py-1.5 text-xs resize-y"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        maxlength="255"
                    ></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Max Amount
                    </label>
                    <input
                        type="number"
                        name="max_amount"
                        id="event-edit-max-amount"
                        step="1"
                        min="0"
                        class="hr-input px-3 py-1.5 text-xs"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        placeholder="0"
                        onkeydown="return event.key !== '.' && event.key !== ',' && (event.key === 'Backspace' || event.key === 'Delete' || event.key === 'Tab' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || /[0-9]/.test(event.key));"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
                </div>
                <div class="mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="event-edit-is-active"
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
                        onclick="closeEventEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Event Modal -->
        <x-admin.modal
            id="event-delete-modal"
            title="Delete Event"
            maxWidth="xs"
            backdropOnClick="closeEventDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this event?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEventDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmEventDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Events Modal -->
        <x-admin.modal
            id="event-bulk-delete-modal"
            title="Delete Selected Events"
            maxWidth="xs"
            backdropOnClick="closeEventBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected events?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEventBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmEventBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden forms for deletes -->
        <form id="event-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="event-bulk-delete-form" method="POST" action="{{ route('claim.configuration.events.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="event-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var eventEditUrlTemplate = "{{ route('claim.configuration.events.update', ['id' => '__ID__']) }}";
                var eventDeleteUrlTemplate = "{{ route('claim.configuration.events.delete', ['id' => '__ID__']) }}";

                var pendingEventDeleteId = null;

                function openEventAddModal() {
                    var m = document.getElementById('event-add-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEventAddModal = openEventAddModal;

                function closeEventAddModal(reset) {
                    var m = document.getElementById('event-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeEventAddModal = closeEventAddModal;

                function openEventEditModalFromRow(row) {
                    var info = row.querySelector('[data-event-id]');
                    if (!info) return;

                    var id = info.dataset.eventId;
                    var name = info.dataset.eventName || '';
                    var description = info.dataset.eventDescription || '';
                    var maxAmount = info.dataset.eventMaxAmount || '';
                    var status = info.dataset.eventStatus || 'Active';

                    var m = document.getElementById('event-edit-modal');
                    if (!m) return;

                    var nameInput = document.getElementById('event-edit-name');
                    if (nameInput) nameInput.value = name;

                    var descriptionInput = document.getElementById('event-edit-description');
                    if (descriptionInput) descriptionInput.value = description;

                    var maxAmountInput = document.getElementById('event-edit-max-amount');
                    if (maxAmountInput && maxAmount) {
                        var amount = parseInt(maxAmount);
                        maxAmountInput.value = isNaN(amount) ? '' : amount;
                    } else if (maxAmountInput) {
                        maxAmountInput.value = '';
                    }

                    var isActiveCheckbox = document.getElementById('event-edit-is-active');
                    if (isActiveCheckbox) isActiveCheckbox.checked = status === 'Active';

                    var form = document.getElementById('event-edit-form');
                    if (form) {
                        form.action = eventEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openEventEditModalFromRow = openEventEditModalFromRow;

                function closeEventEditModal(reset) {
                    var m = document.getElementById('event-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeEventEditModal = closeEventEditModal;

                function openEventDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-event-id]');
                    if (!info) return;
                    pendingEventDeleteId = info.dataset.eventId || null;
                    var m = document.getElementById('event-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEventDeleteModalFromRow = openEventDeleteModalFromRow;

                function closeEventDeleteModal() {
                    var m = document.getElementById('event-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingEventDeleteId = null;
                }
                window.closeEventDeleteModal = closeEventDeleteModal;

                function confirmEventDelete() {
                    if (!pendingEventDeleteId) {
                        closeEventDeleteModal();
                        return;
                    }
                    var form = document.getElementById('event-delete-form');
                    if (!form) {
                        closeEventDeleteModal();
                        return;
                    }
                    form.action = eventDeleteUrlTemplate.replace('__ID__', pendingEventDeleteId);
                    closeEventDeleteModal();
                    form.submit();
                }
                window.confirmEventDelete = confirmEventDelete;

                function openEventBulkDeleteModal() {
                    var m = document.getElementById('event-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openEventBulkDeleteModal = openEventBulkDeleteModal;

                function closeEventBulkDeleteModal() {
                    var m = document.getElementById('event-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeEventBulkDeleteModal = closeEventBulkDeleteModal;

                function confirmEventBulkDelete() {
                    var table = document.getElementById('events-table');
                    if (!table) {
                        closeEventBulkDeleteModal();
                        return;
                    }
                    var checked = table.querySelectorAll('.event-row-checkbox:checked');
                    var ids = [];
                    checked.forEach(function (cb) {
                        var row = cb.closest('.hr-table-row');
                        if (!row) return;
                        var info = row.querySelector('[data-event-id]');
                        if (info && info.dataset.eventId) {
                            ids.push(info.dataset.eventId);
                        }
                    });

                    if (!ids.length) {
                        closeEventBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('event-bulk-delete-form');
                    var input = document.getElementById('event-bulk-delete-ids');
                    if (!form || !input) {
                        closeEventBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeEventBulkDeleteModal();
                    form.submit();
                }
                window.confirmEventBulkDelete = confirmEventBulkDelete;

                function refreshEventSelectionState() {
                    var table = document.getElementById('events-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('events-master-checkbox');
                    var rowCheckboxes = table.querySelectorAll('.event-row-checkbox');
                    var deleteSelectedBtn = document.getElementById('events-delete-selected');

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
                    var table = document.getElementById('events-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('events-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var rowCheckboxes = table.querySelectorAll('.event-row-checkbox');
                            rowCheckboxes.forEach(function (cb) {
                                cb.checked = headerCheckbox.checked;
                            });
                            refreshEventSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#events-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.event-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openEventEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            var rowDel = e.target.closest('.hr-table-row');
                            if (rowDel) openEventDeleteModalFromRow(rowDel);
                            return;
                        }

                        if (rowCheckbox) {
                            refreshEventSelectionState();
                        }
                    });

                    refreshEventSelectionState();

                    // Reset button handler
                    var resetBtn = document.querySelector('#events-search-form button[type="button"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var form = document.getElementById('events-search-form');
                            if (form) {
                                form.querySelector('input[name="event_name"]').value = '';
                                form.querySelector('select[name="status"]').value = '';
                                window.location.href = '{{ route("claim.configuration.events") }}';
                            }
                        });
                    }

                    // Scroll to table section if status message exists
                    @if(session('status'))
                        var tableSection = document.getElementById('events-table-section');
                        if (tableSection) {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    @endif

                    // Scroll to table section on search form submit
                    var searchForm = document.getElementById('events-search-form');
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
                            
                            url.hash = 'events-table-section';
                            window.location.href = url.toString();
                            e.preventDefault();
                        });
                    }

                    // Scroll to table section if hash exists or if search parameters are present
                    if (window.location.hash === '#events-table-section' || 
                        (window.location.search && (window.location.search.includes('event_name=') || 
                         window.location.search.includes('status=')))) {
                        var tableSection = document.getElementById('events-table-section');
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

