@extends('layouts.app')

@section('title', 'Claim - Employee Claims')

@section('body')
    <x-main-layout title="Claim">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-y-visible">
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Configuration</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Submit Claim</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">My Claims</span>
                </div>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Employee Claims</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Assign Claim</span>
                </div>
            </div>
        </div>

        <!-- Employee Claims Section -->
        <div>
            <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
                <h2 class="text-sm font-bold text-slate-800 mb-3">Employee Claims</h2>

                <!-- Filter Form -->
                <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Reference Id</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Event Name</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option>-- Select --</option>
                                <option>Travel Allowance</option>
                                <option>Medical Reimbursement</option>
                                <option>Accommodation</option>
                                <option>Meal Allowance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option>-- Select --</option>
                                <option>Initiated</option>
                                <option>Submitted</option>
                                <option>Approved</option>
                                <option>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">From Date</label>
                            <input type="date" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">To Date</label>
                            <input type="date" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Include</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option>Current Employees Only</option>
                                <option>Past Employees Only</option>
                                <option>All Employees</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium text-green-600 border border-green-300 rounded-lg hover:bg-green-50 transition-all whitespace-nowrap">
                                Reset
                            </button>
                            <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-green-600 to-green-700 rounded-lg hover:shadow-md transition-all shadow-sm whitespace-nowrap">
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Assign Claim Button -->
                <div class="mb-3">
                    <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-lg hover:shadow-lg hover:shadow-green-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                        <i class="fas fa-plus"></i> Assign Claim
                    </button>
                </div>

                <!-- Records Count -->
                <div class="mb-3 text-xs text-slate-600 font-medium">
                    ({{ count($claims) }}) Records Found
                </div>

                <!-- Table Wrapper -->
                <div class="hr-table-wrapper">
                    <!-- Table Header -->
                    <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Reference Id
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Employee Name
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Event Name
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Description</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Currency
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Submitted Date
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Status
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words flex items-center gap-1">
                                Amount
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 100px;">
                            <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                        </div>
                    </div>

                    <!-- Claims List -->
                    <div class="border border-gray-200 border-t-0 rounded-b-lg">
                        @foreach($claims as $claim)
                        <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
                            <!-- Reference Id -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-medium text-gray-900 break-words">{{ $claim['reference_id'] }}</div>
                            </div>
                            
                            <!-- Employee Name -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['employee_name'] }}</div>
                            </div>
                            
                            <!-- Event Name -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['event_name'] }}</div>
                            </div>
                            
                            <!-- Description -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['description'] ?: '-' }}</div>
                            </div>
                            
                            <!-- Currency -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['currency'] }}</div>
                            </div>
                            
                            <!-- Submitted Date -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['submitted_date'] }}</div>
                            </div>
                            
                            <!-- Status -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['status'] }}</div>
                            </div>
                            
                            <!-- Amount -->
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs text-gray-700 break-words">{{ $claim['amount'] }}</div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex-shrink-0" style="width: 100px;">
                                <div class="flex items-center justify-center">
                                    <button class="px-2 py-1 text-xs font-medium text-green-600 border border-green-300 rounded-lg hover:bg-green-50 transition-all">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection

