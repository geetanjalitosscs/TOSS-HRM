@extends('layouts.app')

@section('title', 'Performance - Manage Reviews')

@section('body')
    <x-main-layout title="Performance / Manage Reviews">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b border-purple-100 overflow-x-auto">
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Configure</span>
                            </div>
                            <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                                <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Manage Reviews</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">My Trackers</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Reviews Section -->
                    <div>
                        <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
                        <h2 class="text-sm font-bold text-slate-800 mb-3">Employee Reviews</h2>

                        <!-- Filter Form -->
                        <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Software Engineer</option>
                                        <option>QA Engineer</option>
                                        <option>HR Manager</option>
                                        <option>Business Analyst</option>
                                        <option>Project Manager</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Sub Unit</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Engineering</option>
                                        <option>Human Resources</option>
                                        <option>Quality Assurance</option>
                                        <option>Business Development</option>
                                        <option>Management</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Include</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>Current Employees Only</option>
                                        <option>Past Employees Only</option>
                                        <option>All Employees</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Review Status</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Pending</option>
                                        <option>In Progress</option>
                                        <option>Completed</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">From Date</label>
                                    <div class="relative">
                                        <input type="date" value="2026-01-01" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white pr-8">
                                        <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-purple-400 text-sm pointer-events-none">📅</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">To Date</label>
                                    <div class="relative">
                                        <input type="date" value="2026-12-31" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white pr-8">
                                        <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-purple-400 text-sm pointer-events-none">📅</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium text-purple-600 border border-purple-300 rounded-lg hover:bg-purple-50 transition-all">
                                    Reset
                                </button>
                                <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-md transition-all shadow-sm">
                                    Search
                                </button>
                            </div>
                        </div>

                        <!-- No Records Found Message -->
                        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                            <div class="mb-3 text-xs text-slate-600 font-medium">
                                No Records Found
                            </div>

                            <!-- Table Wrapper -->
                            <div class="hr-table-wrapper">
                                <!-- Table Header -->
                                <div class="bg-gray-50 rounded-t-lg border border-gray-200 border-b-0 px-2 py-1.5 mb-0">
                                    <div class="flex items-center gap-1">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Employee</span>
                                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Job Title</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Sub Unit</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Review Period</span>
                                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Due Date</span>
                                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Review Status</span>
                                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0" style="width: 70px;">
                                            <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center block">Actions</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </x-main-layout>
@endsection

