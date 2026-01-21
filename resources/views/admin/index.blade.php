@extends('layouts.app')

@section('title', 'Admin - User Management')

@section('body')
    <x-main-layout title="Admin / User Management">
                    <!-- Top Navigation Tabs -->
                    <div class="hr-sticky-tabs">
                        <div class="flex items-center border-b border-purple-100 overflow-x-auto">
                            <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                                <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">User Management</span>
                                <span class="text-purple-400 ml-1">▼</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Job</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Organization</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Qualifications</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Nationalities</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Corporate Branding</span>
                            </div>
                            <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                                <span class="text-sm font-medium text-slate-700">Configuration</span>
                                <span class="text-purple-400 ml-1">▼</span>
                            </div>
                        </div>
                    </div>

                    <!-- System Users Section -->
                    <div>
                        <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
                        <h2 class="text-sm font-bold text-slate-800 mb-3">System Users</h2>

                        <!-- Filter Form -->
                        <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Username</label>
                                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Enter username">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">User Role</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Admin</option>
                                        <option>ESS</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                    <input type="text" class="w-full px-3 py-2 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                                    <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                        <option>-- Select --</option>
                                        <option>Enabled</option>
                                        <option>Disabled</option>
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
                        </div>

                        <!-- Add Button -->
                        <div class="mb-3">
                            <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                                <span class="text-sm font-bold">+</span> Add
                            </button>
                        </div>

                        <!-- Records Count -->
                        <div class="mb-3 text-xs text-slate-600 font-medium">
                            ({{ count($users) }}) Records Found
                        </div>

                        <!-- Table Wrapper -->
                        <div class="hr-table-wrapper">
                            <!-- Table Header -->
                            <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Username</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">User Role</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Employee Name</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words">Status</div>
                                </div>
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide leading-tight break-words text-center">Actions</div>
                                </div>
                            </div>

                            <!-- User Cards List -->
                            <div class="border border-gray-200 border-t-0 rounded-b-lg">
                            @foreach($users as $user)
                            <div class="bg-white border-b border-gray-200 last:border-b-0 px-2 py-1.5 hover:bg-gray-50 transition-colors flex items-center gap-1">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                                </div>
                                
                                <!-- Username -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium text-gray-900 break-words">{{ $user['username'] }}</div>
                                </div>
                                
                                <!-- User Role -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $user['role'] }}</div>
                                </div>
                                
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $user['employee_name'] }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs text-gray-700 break-words">{{ $user['status'] }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="flex items-center justify-center gap-1">
                                        <button class="p-0.5 rounded text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all flex-shrink-0" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
    </x-main-layout>
@endsection

