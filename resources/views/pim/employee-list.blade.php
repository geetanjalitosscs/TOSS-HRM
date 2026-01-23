@extends('layouts.app')

@section('title', 'PIM - Employee List')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="employee-list" />

        <div class="space-y-6">
            <!-- Employee Information Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-purple-500"></i> Employee Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                        <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                        <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="">
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
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
                <x-admin.action-buttons />
            </section>

            <!-- Employee List Card -->
            <section class="hr-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-purple-500"></i> Employee List
                    </h2>
                    <x-admin.add-button />
                </div>

                <!-- Records Count -->
                <div class="mb-4 text-xs text-slate-600 font-medium">
                    ({{ count($employees) }}) Records Found
                </div>

                <!-- Table -->
                <x-admin.data-table 
                    title="" 
                    :records="$employees"
                    :columns="[
                        ['label' => 'ID', 'sortable' => false],
                        ['label' => 'First (& Middle) Name', 'sortable' => false],
                        ['label' => 'Last Name', 'sortable' => false],
                        ['label' => 'Job Title', 'sortable' => false],
                        ['label' => 'Employment Status', 'sortable' => false],
                        ['label' => 'Sub Unit', 'sortable' => false],
                        ['label' => 'Supervisor', 'sortable' => false]
                    ]"
                    :addButton="false">
                    @foreach($employees as $employee)
                    <x-admin.table-row>
                        <x-admin.table-cell>
                            <div class="text-xs font-medium text-gray-900">{{ $employee['id'] }}</div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs text-gray-700">{{ $employee['first_name'] }}</div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs text-gray-700">{{ $employee['last_name'] }}</div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs text-gray-700">{{ $employee['job_title'] ?: '-' }}</div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs text-gray-700">{{ $employee['employment_status'] ?: '-' }}</div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs text-gray-700">{{ $employee['sub_unit'] ?: '-' }}</div>
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <div class="text-xs text-gray-700">{{ $employee['supervisor'] ?: '-' }}</div>
                        </x-admin.table-cell>
                    </x-admin.table-row>
                    @endforeach
                </x-admin.data-table>
            </section>
        </div>
    </x-main-layout>
@endsection

