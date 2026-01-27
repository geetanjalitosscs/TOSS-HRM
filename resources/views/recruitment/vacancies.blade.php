@extends('layouts.app')

@section('title', 'Recruitment - Vacancies')

@section('body')
    <x-main-layout title="Recruitment">
        <x-recruitment.tabs activeTab="vacancies" />

        <div class="space-y-6">
            <!-- Vacancies Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-purple-500"></i> Vacancies
                </h2>
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
                <x-admin.action-buttons />
            </section>

            <!-- Vacancies List Card -->
            <section class="hr-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-briefcase text-purple-500"></i> Vacancies List
                    </h2>
                    <x-admin.add-button />
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
                        <div class="text-xs font-medium text-gray-700">{{ $vacancy->vacancy }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $vacancy->job_title }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $vacancy->hiring_manager }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <span class="px-1.5 py-0.5 text-xs rounded-full bg-green-100 text-green-700">
                            {{ $vacancy->status }}
                        </span>
                    </x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
            </section>
        </div>
    </x-main-layout>
@endsection

