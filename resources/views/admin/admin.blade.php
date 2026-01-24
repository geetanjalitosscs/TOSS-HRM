@extends('layouts.app')

@section('title', 'Admin - User Management')

@section('body')
    <x-main-layout title="Admin / User Management">
                    <!-- Top Navigation Tabs -->
                    <x-admin.tabs activeTab="user-management" />

                    <!-- System Users Section -->
                    <div class="space-y-6">
                        <!-- User Search Panel Card -->
                        <section class="hr-card p-6">
                            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                                <i class="fas fa-search text-purple-500"></i> System Users
                            </h2>

                            <!-- Filter Form -->
                            <div class="rounded-lg p-3 mb-3 border border-purple-100" style="background-color: var(--bg-hover);">
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
                            <x-admin.action-buttons />
                        </div>
                        </section>

                        <!-- User List Card -->
                        <section class="hr-card p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-users text-purple-500"></i> User List
                                </h2>
                                <x-admin.add-button label="+ Add" />
                            </div>

                            <!-- Records Count -->
                            <x-records-found :count="count($users)" />

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
                        </section>
                    </div>
    </x-main-layout>
@endsection

