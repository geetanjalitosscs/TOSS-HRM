@extends('layouts.app')

@section('title', 'Recruitment - Candidates')

@section('body')
    <x-main-layout title="Recruitment">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto">
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Candidates</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Vacancies</span>
                </div>
            </div>
        </div>

        <!-- Candidate Search/Filter Section -->
        <div>
            <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4 mb-3">
            <h2 class="text-sm font-bold text-slate-800 mb-3">Candidate Search</h2>

            <!-- Filter Form -->
            <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                        <select class="hr-select">
                            <option>-- Select --</option>
                            <option>Senior QA Lead</option>
                            <option>Payroll Administrator</option>
                            <option>Software Engineer</option>
                            <option>HR Manager</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Vacancy</label>
                        <select class="hr-select">
                            <option>-- Select --</option>
                            <option>Senior QA Lead</option>
                            <option>Payroll Administrator</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Hiring Manager</label>
                        <select class="hr-select">
                            <option>-- Select --</option>
                            <option>manda akhil user</option>
                            <option>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                        <select class="hr-select">
                            <option>-- Select --</option>
                            <option>Application Initiated</option>
                            <option>Shortlisted</option>
                            <option>Rejected</option>
                            <option>Hired</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Candidate Name</label>
                        <input type="text" class="hr-input" placeholder="Type for hints...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Keywords</label>
                        <input type="text" class="hr-input" placeholder="Enter comma separated words...">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Date of Application</label>
                        <div class="flex gap-2">
                            <input type="date" class="hr-input flex-1" placeholder="From">
                            <input type="date" class="hr-input flex-1" placeholder="To">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Method of Application</label>
                        <select class="hr-select">
                            <option>-- Select --</option>
                            <option>Online</option>
                            <option>Email</option>
                            <option>Walk-in</option>
                            <option>Referral</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button class="hr-btn-secondary">Reset</button>
                    <button class="hr-btn-primary">Search</button>
                </div>
            </div>
        </div>

        <!-- Candidate List Section -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-sm font-bold text-slate-800">({{ count($candidates) }}) Records Found</h2>
            </div>

            <!-- Table Wrapper -->
            <div class="hr-table-wrapper">
                <!-- Table Header -->
                <div class="bg-gray-50 rounded-t-lg border border-gray-200 border-b-0 px-2 py-1.5 mb-0">
                    <div class="flex items-center gap-1">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Vacancy</span>
                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Candidate</span>
                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Hiring Manager</span>
                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Date of Application</span>
                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Status</span>
                                <span class="text-purple-400 flex-shrink-0 text-xs">⇅</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 70px;">
                            <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                        </div>
                    </div>
                </div>

                <!-- Candidate Rows -->
                <div class="border border-gray-200 border-t-0 rounded-b-lg">
                @foreach($candidates as $index => $candidate)
                    <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-1">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" class="rounded border-purple-300 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $candidate['vacancy'] ?: '-' }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $candidate['candidate'] }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $candidate['hiring_manager'] }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $candidate['date'] }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="px-1.5 py-0.5 text-xs rounded-full 
                                    @if($candidate['status'] == 'Shortlisted') bg-green-100 text-green-700
                                    @elseif($candidate['status'] == 'Rejected') bg-red-100 text-red-700
                                    @else bg-blue-100 text-blue-700
                                    @endif">
                                    {{ $candidate['status'] }}
                                </span>
                            </div>
                            <div class="flex-shrink-0" style="width: 70px;">
                                <div class="flex items-center justify-center gap-1">
                                    <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="View">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>
                                    <button class="p-0.5 rounded text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all flex-shrink-0" title="Delete">
                                        <i class="fas fa-trash-alt w-4 h-4"></i>
                                    </button>
                                    <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="Download">
                                        <i class="fas fa-download w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-end items-center gap-2 mt-4">
                <button class="px-3 py-1.5 text-sm border border-purple-200 rounded-lg hover:bg-purple-50 transition-colors text-slate-700">1</button>
                <button class="px-3 py-1.5 text-sm border border-purple-200 rounded-lg hover:bg-purple-50 transition-colors text-slate-700">2</button>
                <button class="px-3 py-1.5 text-sm border border-purple-200 rounded-lg hover:bg-purple-50 transition-colors text-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
        </div>
    </x-main-layout>
@endsection

