@extends('layouts.app')

@section('title', 'Leave - Leave List')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="leave-list" />
        
        <div class="space-y-6">
        <!-- Leave List Search Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-list-alt text-[var(--color-primary)]"></i> <span class="mt-0.5">Leave List</span>
            </h2>
            <form method="GET" action="{{ route('leave.leave-list') }}" id="leave-search-form">
                <x-admin.search-panel title="" :collapsed="false">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <x-date-picker 
                                name="from_date"
                                :value="request('from_date', '2026-01-01')"
                                label="From Date"
                            />
                        </div>
                        <div>
                            <x-date-picker 
                                name="to_date"
                                :value="request('to_date', '2026-12-31')"
                                label="To Date"
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Show Leave with Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                                <option value="">-- Select --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Leave Type</label>
                            <select name="leave_type_id" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                                <option value="">-- Select --</option>
                                @foreach($leaveTypes ?? [] as $type)
                                    <option value="{{ $type->id }}" {{ request('leave_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Name</label>
                            <input type="text" name="employee_name" value="{{ request('employee_name') }}" class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="Type for hints...">
                        </div>
                    </div>
                    {{-- <div class="mb-4">
                        <div class="flex items-center gap-3">
                            <x-admin.toggle-switch id="include-past-employees" />
                            <label for="include-past-employees" class="text-xs font-medium cursor-pointer" style="color: var(--text-primary);">Include Past Employees</label>
                        </div>
                    </div> --}}
                    <x-admin.action-buttons resetType="button" searchType="submit" />
                </x-admin.search-panel>
            </form>
        </section>

        <!-- Leave List Table Section -->
        <section id="leave-table-section" class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-list-alt text-[var(--color-primary)]"></i> Leave Records
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <button
                        id="leave-delete-selected"
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                        onclick="openLeaveBulkDeleteModal()"
                    >
                        Delete Selected
                    </button>
                    <x-admin.add-button label="+ Assign" onClick="window.location.href='{{ route('leave.assign-leave') }}'" />
                </div>
            </div>

            <!-- Records Count -->
            <x-records-found :count="count($leaves ?? [])" />
            
            @if(count($leaves) === 0)
            <!-- No Records Found -->
            <div class="text-center py-12 rounded-lg border" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="text-sm font-medium" style="color: var(--text-muted);">No Records Found</div>
            </div>
            @else
            <!-- Leave Table -->
            <div class="hr-table-wrapper mt-4" style="max-height: 22rem; overflow-y: auto;" id="leave-table">
                <!-- Table Header -->
                <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" id="leave-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Date</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Employee Name</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Leave Type</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Leave Balance (Days)</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Leave Taken</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Status</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Comments</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 120px;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                    </div>
                </div>
                <!-- Table Rows -->
                <div class="border border-t-0 border-gray-200 rounded-b-lg">
                    @foreach($leaves as $leave)
                    <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
                        <!-- Checkbox -->
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" class="leave-row-checkbox rounded w-3.5 h-3.5" data-leave-id="{{ $leave->id }}" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                        </div>
                        
                        <!-- Date -->
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">
                                @if($leave->start_date_formatted && $leave->end_date_formatted)
                                    {{ $leave->start_date_formatted }} - {{ $leave->end_date_formatted }}
                                @elseif($leave->start_date_formatted)
                                    {{ $leave->start_date_formatted }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">{{ $leave->employee_name ?? '-' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">{{ $leave->leave_type ?? '-' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">
                                @if($leave->leave_balance !== null && $leave->leave_balance !== '-')
                                    {{ $leave->leave_balance }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">
                                @if($leave->number_of_days !== null)
                                    {{ number_format((float)$leave->number_of_days, 0, '.', '') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">{{ ucfirst($leave->status ?? '-') }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs text-gray-700 break-words">{{ $leave->comments ?? '-' }}</div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex-shrink-0" style="width: 120px;">
                            <div class="flex items-center justify-center gap-1">
                                <form method="POST" action="{{ route('leave.cancel', $leave->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="p-1 text-xs font-medium border rounded transition-all" style="color: #2563eb; border-color: #2563eb; background-color: transparent;" onmouseover="this.style.backgroundColor='#dbeafe'; this.style.color='#1e40af'; this.title='Cancel';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb'; this.title='';" title="Cancel">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leave.reject', $leave->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="p-1 text-xs font-medium border rounded transition-all" style="color: #dc2626; border-color: #dc2626; background-color: transparent;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#991b1b'; this.title='Reject';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626'; this.title='';" title="Reject">
                                        <i class="fas fa-times-circle text-xs"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('leave.approve', $leave->id) }}" style="display: inline;">
                                    @csrf
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
            @endif
        </section>
        </div>
    </x-main-layout>

    <script>
        // Checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const masterCheckbox = document.getElementById('leave-master-checkbox');
            const rowCheckboxes = document.querySelectorAll('.leave-row-checkbox');
            
            // Master checkbox functionality
            if (masterCheckbox) {
                masterCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateDeleteButtonVisibility();
                });
            }
            
            // Individual checkbox functionality
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateMasterCheckboxState();
                    updateDeleteButtonVisibility();
                });
            });
            
            function updateMasterCheckboxState() {
                const checkedCount = document.querySelectorAll('.leave-row-checkbox:checked').length;
                const totalCount = rowCheckboxes.length;
                
                if (masterCheckbox) {
                    if (checkedCount === 0) {
                        masterCheckbox.checked = false;
                        masterCheckbox.indeterminate = false;
                    } else if (checkedCount === totalCount) {
                        masterCheckbox.checked = true;
                        masterCheckbox.indeterminate = false;
                    } else {
                        // Partial selection - uncheck the master but don't use indeterminate
                        masterCheckbox.checked = false;
                        masterCheckbox.indeterminate = false;
                    }
                }
            }
            
            function updateDeleteButtonVisibility() {
                const checkedCount = document.querySelectorAll('.leave-row-checkbox:checked').length;
                const deleteButton = document.getElementById('leave-delete-selected');
                
                if (deleteButton) {
                    if (checkedCount > 0) {
                        deleteButton.classList.remove('hidden');
                    } else {
                        deleteButton.classList.add('hidden');
                    }
                }
            }
            
            // Initial state
            updateMasterCheckboxState();
            updateDeleteButtonVisibility();
            
            // Scroll to table section if status message exists (after edit/delete)
            @if(session('status'))
                var tableSection = document.getElementById('leave-table-section');
                if (tableSection) {
                    setTimeout(function() {
                        tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            @endif
            
            // Scroll to table section on search form submit
            var searchForm = document.getElementById('leave-search-form');
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
                    url.hash = 'leave-table-section';
                    
                    // Navigate to the URL with hash
                    window.location.href = url.toString();
                });
            }
            
            // Scroll to table section if hash exists or if search parameters are present
            if (window.location.hash === '#leave-table-section' || 
                (window.location.search && (window.location.search.includes('from_date=') || 
                 window.location.search.includes('to_date=') || 
                 window.location.search.includes('status=') || 
                 window.location.search.includes('leave_type_id=') || 
                 window.location.search.includes('employee_name=')))) {
                var tableSection = document.getElementById('leave-table-section');
                if (tableSection) {
                    setTimeout(function() {
                        tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            }
            
            // Reset button: clear all filters and reload base leave list
            var searchForm = document.getElementById('leave-search-form');
            if (searchForm) {
                // Find reset button by class (hr-btn-secondary) to avoid selecting date picker buttons
                var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        // Clear input/select values - same pattern as employee-list
                        searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                            if (el.tagName === 'SELECT') {
                                el.value = '';
                            } else if (el.type === 'date') {
                                // Reset date fields to default values
                                if (el.name === 'from_date') {
                                    el.value = '2026-01-01';
                                } else if (el.name === 'to_date') {
                                    el.value = '2026-12-31';
                                }
                            } else {
                                el.value = '';
                            }
                        });
                        // Navigate to base route (no query) so URL is clean
                        window.location.href = "{{ route('leave.leave-list') }}";
                    });
                }
            }
            
            function openLeaveBulkDeleteModal() {
                var m = document.getElementById('leave-bulk-delete-modal');
                if (m) m.classList.remove('hidden');
            }
            
            function closeLeaveBulkDeleteModal() {
                var m = document.getElementById('leave-bulk-delete-modal');
                if (m) m.classList.add('hidden');
            }
            
            function confirmLeaveBulkDelete() {
                var table = document.getElementById('leave-table');
                if (!table) {
                    console.error('Table not found: leave-table');
                    closeLeaveBulkDeleteModal();
                    return;
                }
                var checked = table.querySelectorAll('.leave-row-checkbox:checked');
                console.log('Found checked checkboxes:', checked.length);
                var ids = [];
                checked.forEach(function (cb) {
                    var id = cb.getAttribute('data-leave-id');
                    if (id) ids.push(id);
                });
                console.log('Collected IDs:', ids);

                if (!ids.length) {
                    console.log('No IDs found, closing modal');
                    closeLeaveBulkDeleteModal();
                    return;
                }

                var form = document.getElementById('leave-bulk-delete-form');
                var input = document.getElementById('leave-bulk-delete-ids');
                if (!form || !input) {
                    console.error('Form or input not found');
                    closeLeaveBulkDeleteModal();
                    return;
                }

                console.log('Setting form action:', form.action);
                console.log('Setting input value:', ids.join(','));
                input.value = ids.join(',');
                closeLeaveBulkDeleteModal();
                console.log('Submitting form...');
                form.submit();
            }
            
            // Expose functions globally
            window.openLeaveBulkDeleteModal = openLeaveBulkDeleteModal;
            window.closeLeaveBulkDeleteModal = closeLeaveBulkDeleteModal;
            window.confirmLeaveBulkDelete = confirmLeaveBulkDelete;
        });
    </script>

    <!-- Bulk Delete Modal -->
    <x-admin.modal
        id="leave-bulk-delete-modal"
        title="Delete Selected Leave Applications"
        maxWidth="xs"
        backdropOnClick="closeLeaveBulkDeleteModal()"
    >
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">
                Are you sure you want to delete all selected leave applications?
            </p>
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="hr-btn-secondary px-4 py-1.5 text-xs"
                    onclick="closeLeaveBulkDeleteModal()"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    class="hr-btn-primary px-4 py-1.5 text-xs"
                    onclick="confirmLeaveBulkDelete()"
                >
                    Delete Selected
                </button>
            </div>
        </div>
    </x-admin.modal>

    <!-- Hidden form for bulk delete -->
    <form id="leave-bulk-delete-form" method="POST" action="{{ route('leave.bulk-delete') }}">
        @csrf
        <input type="hidden" name="leave_ids" id="leave-bulk-delete-ids" value="">
    </form>
@endsection
