@extends('layouts.app')

@section('title', 'Recruitment - Candidates')

@section('body')
    <x-main-layout title="Recruitment">
        <x-recruitment.tabs activeTab="candidates" />

        <!-- Candidate Search/Filter Section -->
        <div>
            <div class="rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4 mb-3" style="background-color: var(--bg-card);">
            <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Candidate Search</h2>

            <!-- Filter Form -->
            <div class="rounded-lg p-3 mb-3 border border-purple-100" style="background-color: var(--bg-hover);">
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
                <div class="rounded-t-lg border border-b-0 px-2 py-1.5 mb-0" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex items-center gap-1">
                        <div class="flex-shrink-0" style="width: 24px;">
                            <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" onfocus="this.style.outline='2px solid var(--color-hr-primary)'" onblur="this.style.outline='none'">
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Vacancy</span>
                                <span class="flex-shrink-0 text-xs" style="color: var(--color-hr-primary);">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Candidate</span>
                                <span class="flex-shrink-0 text-xs" style="color: var(--color-hr-primary);">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Hiring Manager</span>
                                <span class="flex-shrink-0 text-xs" style="color: var(--color-hr-primary);">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Date of Application</span>
                                <span class="flex-shrink-0 text-xs" style="color: var(--color-hr-primary);">⇅</span>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="flex items-center gap-1">
                                <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</span>
                                <span class="flex-shrink-0 text-xs" style="color: var(--color-hr-primary);">⇅</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 70px;">
                            <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</span>
                        </div>
                    </div>
                </div>

                <!-- Candidate Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($candidates as $index => $candidate)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex items-center gap-1">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" onfocus="this.style.outline='2px solid var(--color-hr-primary)'" onblur="this.style.outline='none'">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate['vacancy'] ?: '-' }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate['candidate'] }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate['hiring_manager'] }}</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $candidate['date'] }}</div>
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
                                    <button class="p-0.5 rounded hr-action-edit flex-shrink-0" title="View">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </button>
                                    <button class="p-0.5 rounded hr-action-delete flex-shrink-0" title="Delete">
                                        <i class="fas fa-trash-alt w-4 h-4"></i>
                                    </button>
                                    <button class="p-0.5 rounded hr-action-edit flex-shrink-0" title="Download">
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

