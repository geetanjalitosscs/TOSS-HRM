@extends('layouts.app')

@section('title', 'Admin - User Management')

@section('body')
    <x-main-layout title="Admin / User Management">
                    <!-- Top Navigation Tabs -->
                    <x-admin.tabs activeTab="user-management" />

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
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" onfocus="this.style.outline='2px solid var(--color-hr-primary)'" onblur="this.style.outline='none'">
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Username</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">User Role</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee Name</div>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</div>
                                </div>
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                                </div>
                            </div>

                            <!-- User Cards List -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                            @foreach($users as $user)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);" onfocus="this.style.outline='2px solid var(--color-hr-primary)'" onblur="this.style.outline='none'">
                                </div>
                                
                                <!-- Username -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $user['username'] }}</div>
                                </div>
                                
                                <!-- User Role -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $user['role'] }}</div>
                                </div>
                                
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $user['employee_name'] }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $user['status'] }}</div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0" style="width: 70px;">
                                    <div class="flex items-center justify-center gap-1">
                                        <button class="p-0.5 rounded hr-action-delete flex-shrink-0" title="Delete">
                                            <i class="fas fa-trash-alt w-4 h-4"></i>
                                        </button>
                                        <button class="p-0.5 rounded hr-action-edit flex-shrink-0" title="Edit">
                                            <i class="fas fa-edit w-4 h-4"></i>
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

