@extends('layouts.app')

@section('title', 'Recruitment - Vacancies')

@section('body')
    <x-main-layout title="Recruitment">
        <x-recruitment.tabs activeTab="vacancies" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <!-- Vacancies Search Panel -->
            <x-admin.search-panel title="Vacancies" :collapsed="false">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                            <option>-- Select --</option>
                            <option>Account Assistant</option>
                            <option>Payroll Administrator</option>
                            <option>Sales Representative</option>
                            <option>QA Lead</option>
                            <option>Support Specialist</option>
                            <option>Software Engineer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Vacancy</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                            <option>-- Select --</option>
                            <option>Junior Account Assistant</option>
                            <option>Payroll Administrator</option>
                            <option>Sales Representative</option>
                            <option>Senior QA Lead</option>
                            <option>Senior Support Specialist</option>
                            <option>Software Engineer</option>
                            <option>test</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Hiring Manager</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                            <option>-- Select --</option>
                            <option>Jason Miller</option>
                            <option>(Deleted)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                        <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                            <option>-- Select --</option>
                            <option>Active</option>
                            <option>Inactive</option>
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
            </x-admin.search-panel>

            <!-- Add Button -->
            <div class="mb-3">
                <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                    + Add
                </button>
            </div>

            <!-- Records Count -->
            <div class="mb-3 text-xs text-slate-600 font-medium">
                ({{ count($vacancies) }}) Records Found
            </div>

            <!-- Table -->
            <x-admin.data-table 
                title="" 
                :records="$vacancies"
                :columns="[
                    ['label' => 'Vacancy', 'sortable' => true],
                    ['label' => 'Job Title', 'sortable' => true],
                    ['label' => 'Hiring Manager', 'sortable' => true],
                    ['label' => 'Status', 'sortable' => true]
                ]"
                :addButton="false">
                @foreach($vacancies as $vacancy)
                <x-admin.table-row>
                    <x-admin.table-cell>
                        <div class="text-xs font-medium text-gray-700">{{ $vacancy['vacancy'] }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $vacancy['job_title'] }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $vacancy['hiring_manager'] }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <span class="px-1.5 py-0.5 text-xs rounded-full bg-green-100 text-green-700">
                            {{ $vacancy['status'] }}
                        </span>
                    </x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </div>
    </x-main-layout>
@endsection

