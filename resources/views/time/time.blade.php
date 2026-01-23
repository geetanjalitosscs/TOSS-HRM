@extends('layouts.app')

@section('title', 'Time - Timesheets')

@section('body')
    <x-main-layout title="Time / Timesheets">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b border-purple-100 overflow-x-auto">
                            <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                                <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Timesheets</span>
                                <span class="text-purple-400 ml-1">▼</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Attendance</span>
                                <span class="text-purple-400 ml-1">▼</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Reports</span>
                                <span class="text-purple-400 ml-1">▼</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Project Info</span>
                                <span class="text-purple-400 ml-1">▼</span>
                            </div>
                        </div>
                    </div>

                    <!-- Select Employee Section -->
                    <section class="hr-card p-6 mb-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                            <i class="fas fa-user-check text-purple-500"></i> <span class="mt-0.5">Select Employee</span>
                        </h2>
                        <div class="bg-purple-50/30 rounded-lg p-4 border border-purple-100">
                            <div class="flex items-end gap-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name <span class="text-red-500">*</span></label>
                                    <input type="text" class="w-full px-3 py-2.5 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                    <div class="text-xs text-gray-500 mt-1">* Required</div>
                                </div>
                                <div>
                                    <button class="hr-btn-primary px-4 py-2.5 text-sm font-medium">
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Timesheets Pending Action Section -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                            <i class="fas fa-clock text-purple-500"></i> <span class="mt-0.5">Timesheets Pending Action</span>
                        </h2>
                        
                        <!-- Records Count -->
                        <div class="mb-4 text-sm text-slate-600 font-medium">
                            ({{ count($timesheets) }}) Records Found
                        </div>

                        <!-- Table Header -->
                        <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Employee Name</div>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Timesheet Period</div>
                            </div>
                            <div class="flex-shrink-0" style="width: 70px;">
                                <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                            </div>
                        </div>

                        <!-- Timesheet Cards List -->
                        <div class="border border-gray-200 border-t-0 rounded-b-lg">
                            @foreach($timesheets as $timesheet)
                            <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium text-gray-900 break-words">{{ $timesheet['employee_name'] }}</div>
                                </div>
                                
                                <!-- Timesheet Period -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $timesheet['timesheet_period'] }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="flex items-center justify-center">
                                        <button class="hr-btn-primary px-2 py-1 text-xs font-medium">
                                            View
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
    </x-main-layout>
@endsection

