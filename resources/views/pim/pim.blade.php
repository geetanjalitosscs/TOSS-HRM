@extends('layouts.app')

@section('title', 'PIM - Employee List')

@section('body')
    <x-main-layout title="PIM">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b border-purple-100 overflow-x-auto">
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Configuration</span>
                            </div>
                            <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                                <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Employee List</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Add Employee</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Reports</span>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Information Section -->
                    <div class="space-y-6">
                        <!-- Employee Information Search Panel Card -->
                        <section class="hr-card p-6">
                            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                                <i class="fas fa-search text-purple-500"></i> Employee Information
                            </h2>

                            <!-- Filter Form -->
                            <div class="rounded-lg p-3 mb-3 border" style="background-color: var(--color-hr-primary-light); border-color: var(--border-default);">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                                    <input type="text" class="w-full px-3 py-2 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Enter employee ID">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employment Status</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Full-Time Permanent</option>
                                        <option>Full-Time Contract</option>
                                        <option>Part-Time Contract</option>
                                        <option>Intern</option>
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
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Supervisor Name</label>
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
                            </div>
                            <div class="flex justify-end gap-2">
                                <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium text-purple-600 border border-purple-300 rounded-lg hover:bg-purple-50 transition-all">
                                    Reset
                                </button>
                                <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-md transition-all shadow-sm">
                                    Search
                                </button>
                            </div>
                            <x-admin.action-buttons />
                        </div>
                        </section>

                        <!-- Employee List Card -->
                        <section class="hr-card p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-users text-purple-500"></i> Employee List
                                </h2>
                                <x-admin.add-button label="+ Add" />
                            </div>

                            <!-- Records Count -->
                            <x-records-found :count="count($employees)" />

                            <!-- Table Wrapper -->
                            <div class="hr-table-wrapper">
                            <!-- Table Header -->
                            <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">ID</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">First (& Middle) Name</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Last Name</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Job Title</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Employment Status</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Sub Unit</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Supervisor</div>
                                </div>
                                <div class="flex-shrink-0" style="width: 90px;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                                </div>
                            </div>

                            <!-- Employee Cards List -->
                            <div class="border border-gray-200 border-t-0 rounded-b-lg">
                            @foreach($employees as $employee)
                            <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                                </div>
                                
                                <!-- ID -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium text-gray-900 break-words">{{ $employee['id'] }}</div>
                                </div>
                                
                                <!-- First Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $employee['first_name'] }}</div>
                                </div>
                                
                                <!-- Last Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $employee['last_name'] }}</div>
                                </div>
                                
                                <!-- Job Title -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $employee['job_title'] ?: '-' }}</div>
                                </div>
                                
                                <!-- Employment Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $employee['employment_status'] ?: '-' }}</div>
                                </div>
                                
                                <!-- Sub Unit -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $employee['sub_unit'] ?: '-' }}</div>
                                </div>
                                
                                <!-- Supervisor -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $employee['supervisor'] ?: '-' }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 90px;">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="hr-action-delete flex-shrink-0" title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                        <button class="hr-action-edit flex-shrink-0" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex justify-end items-center gap-2">
                            <button class="px-3 py-1.5 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">1</button>
                            <button class="px-3 py-1.5 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">2</button>
                            <button class="px-3 py-1.5 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">3</button>
                            <button class="px-3 py-1.5 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">4</button>
                            <button class="px-3 py-1.5 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">></button>
                        </div>
                        </section>
                    </div>
    </x-main-layout>
@endsection

