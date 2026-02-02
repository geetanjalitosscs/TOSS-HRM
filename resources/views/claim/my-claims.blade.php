@extends('layouts.app')

@section('title', 'Claim - My Claims')

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
                        <a href="{{ route('claim.configuration.events') }}" class="block px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
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
                <div class="px-6 py-3 border-b-2 flex items-center flex-shrink-0 whitespace-nowrap" style="border-bottom-color: var(--color-hr-primary); background-color: var(--color-hr-primary-light);">
                    <span class="text-sm font-semibold" style="color: var(--color-hr-primary-dark);">My Claims</span>
                </div>
                <a href="{{ route('claim') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Employee Claims</span>
                </a>
                <a href="{{ route('claim.assign') }}" class="px-6 py-3 cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap" style="background-color: transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">Assign Claim</span>
                </a>
            </div>
        </div>

        <!-- My Claims Section -->
        <div>
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                    <i class="fas fa-file-invoice-dollar" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">My Claims</span>
                </h2>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('claim.my-claims') }}" id="my-claims-search-form">
                    <div class="rounded-lg p-4 mb-4 border" style="background-color: var(--color-hr-primary-light); border-color: var(--border-default);">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Reference Id</label>
                                <input type="text" name="reference_id" value="{{ request('reference_id') }}" class="hr-input w-full px-3 py-2 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);" placeholder="Type for hints...">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Event Name</label>
                                <div class="relative">
                                    <select
                                        name="event_name"
                                        class="hr-select w-full px-3 py-2 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                                        style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                    >
                                        <option value="">-- Select --</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event }}" {{ request('event_name') == $event ? 'selected' : '' }}>{{ $event }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Status</label>
                                <div class="relative">
                                    <select
                                        name="status"
                                        class="hr-select w-full px-3 py-2 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]"
                                        style="border-color: var(--border-strong);background-color: var(--bg-input);color: var(--text-primary);"
                                    >
                                        <option value="">-- Select --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                            <div>
                                <x-date-picker 
                                    name="from_date"
                                    label="From Date"
                                    class="text-xs"
                                    value="{{ request('from_date') }}"
                                />
                            </div>
                            <div>
                                <x-date-picker 
                                    name="to_date"
                                    label="To Date"
                                    class="text-xs"
                                    value="{{ request('to_date') }}"
                                />
                            </div>
                            <div></div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" class="hr-btn-secondary px-8 py-2 text-xs font-medium rounded-full transition-all whitespace-nowrap">
                                Reset
                            </button>
                            <button type="submit" class="hr-btn-primary px-8 py-2 text-xs font-medium rounded-full transition-all whitespace-nowrap">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Records Count -->
                <x-records-found :count="count($claims)" />

                <!-- Table Section Header -->
                <div class="flex items-center justify-between mb-5 mt-2" style="overflow: visible;">
                    <div></div>
                    <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                        <button
                            id="my-claims-delete-selected"
                            type="button"
                            class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                            onclick="openMyClaimBulkDeleteModal()"
                        >
                            Delete Selected
                        </button>
                        <a
                            href="{{ route('claim.submit') }}"
                            class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform"
                            style="transform-origin: center; position: relative; z-index: 10;"
                        >
                            <i class="fas fa-plus"></i> Submit Claim
                        </a>
                    </div>
                </div>

                <!-- Table Wrapper -->
                <div id="my-claims-table-section" class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                    <!-- Table Header -->
                    <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" id="my-claims-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Reference Id
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Employee Name
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Event Name
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Submitted Date
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Status
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words flex items-center gap-1" style="color: var(--text-primary);">
                                Amount
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-arrow-down text-[10px]" style="color: var(--text-muted);"></i>
                                        <i class="fas fa-arrow-up text-[10px]" style="color: var(--text-muted);"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 200px;">
                            <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                        </div>
                    </div>

                    <!-- Claims List -->
                    <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                        @foreach($claims as $claim)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="my-claim-row-checkbox rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                
                                <!-- Reference Id -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" 
                                         style="color: var(--text-primary);"
                                         data-claim-id="{{ $claim->id }}"
                                         data-claim-reference-id="{{ $claim->reference_id }}"
                                         data-claim-employee-name="{{ $claim->employee_name }}"
                                         data-claim-event-name="{{ $claim->event_name }}"
                                         data-claim-description="{{ $claim->description ?? '' }}"
                                         data-claim-currency="{{ $claim->currency }}"
                                         data-claim-submitted-date="{{ $claim->submitted_date }}"
                                         data-claim-status="{{ $claim->status }}"
                                         data-claim-amount="{{ number_format($claim->amount, 2) }}"
                                    >
                                        {{ $claim->reference_id }}
                                    </div>
                                </div>
                                
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim->employee_name }}</div>
                                </div>
                                
                                <!-- Event Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim->event_name }}</div>
                                </div>
                                
                                <!-- Submitted Date -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim->submitted_date }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $claim->status }}</div>
                                </div>
                                
                                <!-- Amount -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">
                                        {{ number_format($claim->amount, 2) }}
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 200px;">
                                    <div class="flex items-center justify-center gap-1">
                                        <button 
                                            type="button"
                                            class="p-1 text-xs font-medium border rounded transition-all my-claim-view-btn" 
                                            style="color: #a78bfa; border-color: #a78bfa; background-color: transparent;" 
                                            onmouseover="this.style.backgroundColor='#ede9fe'; this.style.color='#7c3aed'; this.title='View';" 
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#a78bfa'; this.title='';"
                                            title="View"
                                        >
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <form method="POST" action="{{ route('claim.cancel', $claim->id) }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="redirect_to" value="my-claims">
                                            <button type="submit" class="p-1 text-xs font-medium border rounded transition-all" style="color: #2563eb; border-color: #2563eb; background-color: transparent;" onmouseover="this.style.backgroundColor='#dbeafe'; this.style.color='#1e40af'; this.title='Cancel';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb'; this.title='';" title="Cancel">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('claim.reject', $claim->id) }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="redirect_to" value="my-claims">
                                            <button type="submit" class="p-1 text-xs font-medium border rounded transition-all" style="color: #dc2626; border-color: #dc2626; background-color: transparent;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#991b1b'; this.title='Reject';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626'; this.title='';" title="Reject">
                                                <i class="fas fa-times-circle text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('claim.approve', $claim->id) }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="redirect_to" value="my-claims">
                                            <button type="submit" class="p-1 text-xs font-medium border rounded transition-all" style="color: #16a34a; border-color: #16a34a; background-color: transparent;" onmouseover="this.style.backgroundColor='#dcfce7'; this.style.color='#15803d'; this.title='Approve';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#16a34a'; this.title='';" title="Approve">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </section>
        </div>

        <!-- View Claim Details Modal -->
        <x-admin.modal
            id="my-claim-view-modal"
            title="Claim Details"
            icon="fas fa-eye"
            maxWidth="md"
            backdropOnClick="closeMyClaimViewModal()"
        >
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Reference Id</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-reference-id">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-employee-name">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Event Name</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-event-name">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Description</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-description">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Currency</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-currency">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Submitted Date</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-submitted-date">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Status</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-status">-</div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Amount</label>
                    <div class="text-xs" style="color: var(--text-muted);" id="my-view-amount">-</div>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button
                    type="button"
                    class="hr-btn-secondary px-4 py-1.5 text-xs"
                    onclick="closeMyClaimViewModal()"
                >
                    Close
                </button>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Claims Modal -->
        <x-admin.modal
            id="my-claim-bulk-delete-modal"
            title="Delete Selected Claims"
            maxWidth="xs"
            backdropOnClick="closeMyClaimBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected claims?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeMyClaimBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmMyClaimBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Hidden form for bulk delete -->
        <form id="my-claim-bulk-delete-form" method="POST" action="{{ route('claim.bulk-delete') }}">
            @csrf
            <input type="hidden" name="redirect_to" value="my-claims">
            <input type="hidden" name="ids" id="my-claim-bulk-delete-ids" value="">
        </form>
    </x-main-layout>

    <script>
        (function () {
            function refreshMyClaimSelectionState() {
                var table = document.getElementById('my-claims-table-section');
                if (!table) return;

                var headerCheckbox = document.getElementById('my-claims-master-checkbox');
                var rowCheckboxes = table.querySelectorAll('.my-claim-row-checkbox');
                var deleteSelectedBtn = document.getElementById('my-claims-delete-selected');

                var checkedCount = 0;
                rowCheckboxes.forEach(function (cb) {
                    if (cb.checked) checkedCount++;
                });

                // Show "Delete Selected" button only when at least 1 row is checked
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

            function openMyClaimViewModal(row) {
                var info = row.querySelector('[data-claim-id]');
                if (!info) return;

                document.getElementById('my-view-reference-id').textContent = info.dataset.claimReferenceId || '-';
                document.getElementById('my-view-employee-name').textContent = info.dataset.claimEmployeeName || '-';
                document.getElementById('my-view-event-name').textContent = info.dataset.claimEventName || '-';
                document.getElementById('my-view-description').textContent = info.dataset.claimDescription || '-';
                document.getElementById('my-view-currency').textContent = info.dataset.claimCurrency || '-';
                document.getElementById('my-view-submitted-date').textContent = info.dataset.claimSubmittedDate || '-';
                document.getElementById('my-view-status').textContent = info.dataset.claimStatus || '-';
                document.getElementById('my-view-amount').textContent = info.dataset.claimAmount || '-';

                var modal = document.getElementById('my-claim-view-modal');
                if (modal) modal.classList.remove('hidden');
            }
            window.openMyClaimViewModal = openMyClaimViewModal;

            function closeMyClaimViewModal() {
                var modal = document.getElementById('my-claim-view-modal');
                if (modal) modal.classList.add('hidden');
            }
            window.closeMyClaimViewModal = closeMyClaimViewModal;

            function openMyClaimBulkDeleteModal() {
                var m = document.getElementById('my-claim-bulk-delete-modal');
                if (m) m.classList.remove('hidden');
            }
            window.openMyClaimBulkDeleteModal = openMyClaimBulkDeleteModal;

            function closeMyClaimBulkDeleteModal() {
                var m = document.getElementById('my-claim-bulk-delete-modal');
                if (m) m.classList.add('hidden');
            }
            window.closeMyClaimBulkDeleteModal = closeMyClaimBulkDeleteModal;

            function confirmMyClaimBulkDelete() {
                var table = document.getElementById('my-claims-table-section');
                if (!table) {
                    closeMyClaimBulkDeleteModal();
                    return;
                }
                var checked = table.querySelectorAll('.my-claim-row-checkbox:checked');
                var ids = [];
                checked.forEach(function (cb) {
                    var row = cb.closest('.hr-table-row');
                    if (!row) return;
                    var info = row.querySelector('[data-claim-id]');
                    if (info && info.dataset.claimId) {
                        ids.push(info.dataset.claimId);
                    }
                });

                if (!ids.length) {
                    closeMyClaimBulkDeleteModal();
                    return;
                }

                var form = document.getElementById('my-claim-bulk-delete-form');
                var input = document.getElementById('my-claim-bulk-delete-ids');
                if (!form || !input) {
                    closeMyClaimBulkDeleteModal();
                    return;
                }

                input.value = ids.join(',');
                closeMyClaimBulkDeleteModal();
                form.submit();
            }
            window.confirmMyClaimBulkDelete = confirmMyClaimBulkDelete;

            document.addEventListener('DOMContentLoaded', function () {
                var table = document.getElementById('my-claims-table-section');
                if (!table) return;

                var headerCheckbox = document.getElementById('my-claims-master-checkbox');
                if (headerCheckbox) {
                    headerCheckbox.addEventListener('change', function () {
                        var rowCheckboxes = table.querySelectorAll('.my-claim-row-checkbox');
                        rowCheckboxes.forEach(function (cb) {
                            cb.checked = headerCheckbox.checked;
                        });
                        refreshMyClaimSelectionState();
                    });
                }

                table.addEventListener('click', function (e) {
                    var headerCheckboxClick = e.target.closest('#my-claims-master-checkbox');
                    if (headerCheckboxClick) {
                        return;
                    }

                    var viewBtn = e.target.closest('.my-claim-view-btn');
                    var rowCheckbox = e.target.closest('.my-claim-row-checkbox');

                    if (viewBtn) {
                        var row = e.target.closest('.hr-table-row');
                        if (row) openMyClaimViewModal(row);
                        return;
                    }

                    if (rowCheckbox) {
                        refreshMyClaimSelectionState();
                    }
                });

                refreshMyClaimSelectionState();

                // Reset button handler
                var searchForm = document.getElementById('my-claims-search-form');
                if (searchForm) {
                    var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                                if (el.tagName === 'SELECT') {
                                    el.value = '';
                                } else if (el.type === 'date') {
                                    el.value = '';
                                } else {
                                    el.value = '';
                                }
                            });
                            window.location.href = '{{ route("claim.my-claims") }}';
                        });
                    }

                    // Search form submit handler
                    searchForm.addEventListener('submit', function(e) {
                        var formAction = searchForm.getAttribute('action') || window.location.pathname;
                        var url = new URL(formAction, window.location.origin);
                        
                        var formData = new FormData(searchForm);
                        for (var [key, value] of formData.entries()) {
                            if (value) {
                                url.searchParams.set(key, value);
                            }
                        }
                        
                        url.hash = 'my-claims-table-section';
                        window.location.href = url.toString();
                        e.preventDefault();
                    });
                }

                // Scroll to table section if hash exists or if search parameters are present
                if (window.location.hash === '#my-claims-table-section' || 
                    (window.location.search && (window.location.search.includes('reference_id=') || 
                     window.location.search.includes('event_name=') || 
                     window.location.search.includes('status=') ||
                     window.location.search.includes('from_date=') ||
                     window.location.search.includes('to_date=')))) {
                    var tableSection = document.getElementById('my-claims-table-section');
                    if (tableSection) {
                        setTimeout(function() {
                            tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 300);
                    }
                }
            });
        })();
    </script>
@endsection

