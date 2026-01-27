@extends('layouts.app')

@section('title', 'Leave - Leave List')

@section('body')
    <x-main-layout title="Leave">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b border-purple-100 overflow-x-auto">
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Apply</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">My Leave</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Entitlements</span>
                                <x-dropdown-arrow color="#a78bfa" />
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Reports</span>
                                <x-dropdown-arrow color="#a78bfa" />
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Configure</span>
                                <x-dropdown-arrow color="#a78bfa" />
                            </div>
                            <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                                <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Leave List</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Assign Leave</span>
                            </div>
                        </div>
                    </div>

                    <!-- Leave List Section -->
                    <div>
                        <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
                        <h2 class="text-sm font-bold text-slate-800 mb-3">Leave List</h2>

                        <!-- Filter Form -->
                        <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                <div>
                                    <x-date-picker 
                                        name="from_date"
                                        value="2026-01-16"
                                        label="From Date"
                                        class="text-xs"
                                    />
                                </div>
                                <div>
                                    <x-date-picker 
                                        name="to_date"
                                        value="2026-12-31"
                                        label="To Date"
                                    />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Show Leave with Status*</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Pending Approval</option>
                                        <option>Approved</option>
                                        <option>Rejected</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Leave Type</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Annual Leave</option>
                                        <option>Sick Leave</option>
                                        <option>Casual Leave</option>
                                        <option>Personal Leave</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name <span class="text-red-500">*</span></label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                    <div class="text-xs text-gray-500 mt-1">* Required</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Sub Unit</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Engineering</option>
                                        <option>Human Resources</option>
                                        <option>Quality Assurance</option>
                                        <option>Business Development</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="flex items-center gap-3">
                                    <x-admin.toggle-switch id="include-past-employees" />
                                    <label for="include-past-employees" class="text-xs font-medium cursor-pointer" style="color: var(--text-primary);">Include Past Employees</label>
                                </div>
                            </div>
                            <x-admin.action-buttons />
                        </div>

                        <!-- Records Count -->
                        @if(count($leaves) > 0)
                        <x-records-found :count="count($leaves)" />
                        @endif

                        <!-- Table Wrapper -->
                        <div class="hr-table-wrapper">
                            <!-- Table Header - Always Visible -->
                            <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
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
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Number of Days</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Status</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Comments</div>
                                </div>
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                                </div>
                            </div>

                            <!-- Leave Cards List or No Records -->
                            @if(count($leaves) === 0)
                            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="text-gray-500 text-lg font-medium">No Records Found</div>
                            </div>
                            @else
                            <div class="border border-gray-200 border-t-0 rounded-b-lg">
                            @foreach($leaves as $leave)
                            <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                                </div>
                                
                                <!-- Date -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['date'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['employee_name'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Leave Type -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['leave_type'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Leave Balance -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['leave_balance'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Number of Days -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['number_of_days'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['status'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Comments -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $leave['comments'] ?? '-' }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="flex items-center justify-center gap-1">
                                        <button class="p-0.5 rounded text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all flex-shrink-0" title="Delete">
                                            <i class="fas fa-trash-alt w-4 h-4"></i>
                                        </button>
                                        <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="Edit">
                                            <i class="fas fa-edit w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        @endif
                    </div>
                    </div>
    </x-main-layout>
@endsection

