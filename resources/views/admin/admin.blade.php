@extends('layouts.app')

@section('title', 'Admin - User Management')

@section('body')
    <x-main-layout title="Admin">
        <!-- Top Navigation Tabs -->
        <x-admin.tabs activeTab="user-management" />

        <!-- System Users Section -->
        <div class="space-y-6">
            <!-- User Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-[var(--color-primary)]"></i> System Users
                </h2>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin') }}" id="user-search-form">
                    <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Username</label>
                                <input 
                                    type="text" 
                                    name="username"
                                    value="{{ request('username') }}"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                    placeholder="Enter username">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">User Role</label>
                                <select 
                                    name="user_role"
                                    class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    @foreach($roles ?? [] as $role)
                                        <option value="{{ $role->id }}" {{ request('user_role') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                <input 
                                    type="text" 
                                    name="employee_name"
                                    value="{{ request('employee_name') }}"
                                    class="w-full px-3 py-2 text-sm border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                    placeholder="Type for hints...">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                                <select 
                                    name="status"
                                    class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    <option value="Enabled" {{ request('status') == 'Enabled' ? 'selected' : '' }}>Enabled</option>
                                    <option value="Disabled" {{ request('status') == 'Disabled' ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" />
                    </div>
                </form>
            </section>

            <!-- User List Card -->
            <section id="users-table-section" class="hr-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-[var(--color-primary)]"></i> User List
                    </h2>
                    @if(!empty($isMainUserCurrent) && $isMainUserCurrent)
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="users-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openUserBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button label="+ Add" onClick="openUserAddModal()" />
                        </div>
                    @endif
                </div>

                @if(session('status'))
                    <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10B981;">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif

                <!-- Records Count -->
                <x-records-found :count="count($users)" />

                <!-- Table Wrapper -->
                <div id="users-table">
                    <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                        <!-- Table Header -->
                        <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" id="users-master-checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
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
                            @if(!empty($isMainUserCurrent) && $isMainUserCurrent)
                                <div class="flex-shrink-0" style="width: 90px;">
                                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                                </div>
                            @endif
                        </div>

                        <!-- User Rows -->
                        <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                            @forelse($users as $user)
                            <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row" 
                                 style="background-color: var(--bg-card); border-color: var(--border-default);" 
                                 onmouseover="this.style.backgroundColor='var(--bg-hover)'" 
                                 onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox" 
                                           class="user-row-checkbox rounded w-3.5 h-3.5" 
                                           style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                                           data-user-checkbox-id="{{ $user->id }}"
                                           {{ $user->is_main_user == 1 ? 'disabled' : '' }}>
                                </div>
                                
                                <!-- Username -->
                                @php
                                    $pagePermRaw = $user->page_permissions ?? null;
                                    $pagePermArray = [];
                                    if (is_string($pagePermRaw) && $pagePermRaw !== '') {
                                        $decoded = json_decode($pagePermRaw, true);
                                        if (is_array($decoded)) {
                                            $pagePermArray = $decoded;
                                        }
                                    } elseif (is_array($pagePermRaw)) {
                                        $pagePermArray = $pagePermRaw;
                                    }
                                    $pagePermCsv = implode(',', $pagePermArray);
                                @endphp
                                <div class="flex-1" style="min-width: 0;"
                                     data-user-id="{{ $user->id }}"
                                     data-user-username="{{ $user->username }}"
                                     data-user-email="{{ $user->email ?? '' }}"
                                     data-user-role-id="{{ $user->role_id ?? '' }}"
                                     data-user-employee-id="{{ $user->employee_id ?? '' }}"
                                     data-user-is-active="{{ $user->is_active ?? 1 }}"
                                     data-user-is-main-user="{{ $user->is_main_user ?? 0 }}"
                                     data-user-page-permissions="{{ e($pagePermCsv) }}"
                                >
                                    <div class="text-xs font-medium break-words" style="color: var(--text-primary);">
                                        {{ $user->username }}
                                        @if($user->is_main_user == 1)
                                            <span class="text-[10px] ml-1" style="color: var(--text-muted);">(Main User)</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- User Role -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $user->role }}</div>
                                </div>
                                
                                <!-- Employee Name -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $user->employee_name ?: '-' }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="flex-1" style="min-width: 0;">
                                    <div class="text-xs break-words" style="color: var(--text-primary);">{{ $user->status }}</div>
                                </div>
                                
                                <!-- Actions -->
                                @if(!empty($isMainUserCurrent) && $isMainUserCurrent)
                                    <div class="flex-shrink-0" style="width: 90px;">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="hr-action-delete flex-shrink-0" title="Delete" type="button">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                            <button class="hr-action-edit flex-shrink-0" title="Edit" type="button">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @empty
                                <div class="px-4 py-10 text-center text-xs" style="color: var(--text-muted);">
                                    No users found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Add User Modal -->
        <x-admin.modal
            id="user-add-modal"
            title="Add User"
            icon="fas fa-user-plus"
            maxWidth="md"
            backdropOnClick="closeUserAddModal(true)"
        >
            <form method="POST" action="{{ route('admin.users.store') }}" style="max-height: 65vh; overflow-y: auto; overflow-x: hidden;">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="username"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        minlength="6"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        User Role <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="role_id"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select --</option>
                        @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee
                    </label>
                    <select
                        name="employee_id"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="">-- Select --</option>
                        @foreach($employees ?? [] as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            checked
                            class="rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                        >
                        <span class="text-xs" style="color: var(--text-primary);">Active</span>
                    </label>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="is_main_user" value="0">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_main_user"
                            value="1"
                            class="rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                        >
                        <span class="text-xs" style="color: var(--text-primary);">Main User</span>
                    </label>
                </div>

                @if(!empty($isMainUserCurrent) && $isMainUserCurrent)
                    @php
                        // High-level sections for page access control
                        $pagePermissionOptions = [
                            'dashboard'   => 'Dashboard',
                            'my-info'     => 'My Info',
                            'pim'         => 'PIM (Personnel Information Management)',
                            'leave'       => 'Leave',
                            'time'        => 'Time',
                            'recruitment' => 'Recruitment',
                            'performance' => 'Performance',
                            'claim'       => 'Claim',
                            'directory'   => 'Directory',
                            'buzz'        => 'Buzz',
                            'admin'       => 'Admin',
                        ];
                    @endphp
                    <div class="mb-4" id="user-add-page-access-section">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Page Access (only main user can change)
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 rounded border px-3 py-2" style="border-color: var(--border-default); background-color: var(--bg-input); max-height: 9rem; overflow-y: auto;">
                            @foreach($pagePermissionOptions as $key => $label)
                                <label class="flex items-center gap-2 text-[11px]" style="color: var(--text-primary);">
                                    <input
                                        type="checkbox"
                                        name="page_permissions[]"
                                        value="{{ $key }}"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                                    >
                                    <span class="truncate">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[10px] mt-1" style="color: var(--text-muted);">These permissions control which pages and tabs this user can access.</p>
                    </div>
                @endif

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeUserAddModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Edit User Modal -->
        <x-admin.modal
            id="user-edit-modal"
            title="Edit User"
            icon="fas fa-edit"
            maxWidth="md"
            backdropOnClick="closeUserEditModal(true)"
        >
            <form method="POST" id="user-edit-form" action="#" style="max-height: 65vh; overflow-y: auto; overflow-x: hidden;">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="username"
                        id="user-edit-username"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="100"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="user-edit-email"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                        maxlength="191"
                    >
                </div>

                @if(!empty($isMainUserCurrent) && $isMainUserCurrent)
                    @php
                        // High-level sections for page access control
                        $pagePermissionOptions = [
                            'dashboard'   => 'Dashboard',
                            'my-info'     => 'My Info',
                            'pim'         => 'PIM (Personnel Information Management)',
                            'leave'       => 'Leave',
                            'time'        => 'Time',
                            'recruitment' => 'Recruitment',
                            'performance' => 'Performance',
                            'claim'       => 'Claim',
                            'directory'   => 'Directory',
                            'buzz'        => 'Buzz',
                            'admin'       => 'Admin',
                        ];
                    @endphp
                    <div class="mb-4" id="user-edit-page-access-section">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Page Access (only main user can change)
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 rounded border px-3 py-2" style="border-color: var(--border-default); background-color: var(--bg-input); max-height: 9rem; overflow-y: auto;">
                            @foreach($pagePermissionOptions as $key => $label)
                                <label class="flex items-center gap-2 text-[11px]" style="color: var(--text-primary);">
                                    <input
                                        type="checkbox"
                                        name="page_permissions[]"
                                        value="{{ $key }}"
                                        class="rounded w-3.5 h-3.5 user-edit-page-permission"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                                    >
                                    <span class="truncate">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[10px] mt-1" style="color: var(--text-muted);">These permissions control which pages and tabs this user can access.</p>
                    </div>
                @endif
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Password (leave blank to keep current)
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="user-edit-password"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        minlength="6"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        User Role <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="role_id"
                        id="user-edit-role-id"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                        required
                    >
                        <option value="">-- Select --</option>
                        @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Employee
                    </label>
                    <select
                        name="employee_id"
                        id="user-edit-employee-id"
                        class="hr-input px-3 py-1.5 text-xs w-full"
                        style="background-color: var(--bg-input); color: var(--text-primary);"
                    >
                        <option value="">-- Select --</option>
                        @foreach($employees ?? [] as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="user-edit-is-active"
                            value="1"
                            class="rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                        >
                        <span class="text-xs" style="color: var(--text-primary);">Active</span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_main_user"
                            id="user-edit-is-main-user"
                            value="1"
                            class="rounded w-3.5 h-3.5"
                            style="border-color: var(--border-default); accent-color: var(--color-hr-primary);"
                        >
                        <span class="text-xs" style="color: var(--text-primary);">Main User</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-1">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeUserEditModal(true)"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                        Save
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete User Modal -->
        <x-admin.modal
            id="user-delete-modal"
            title="Delete User"
            maxWidth="xs"
            backdropOnClick="closeUserDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete this user?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeUserDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmUserDelete()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Bulk Delete Users Modal -->
        <x-admin.modal
            id="user-bulk-delete-modal"
            title="Delete Selected Users"
            maxWidth="xs"
            backdropOnClick="closeUserBulkDeleteModal()"
        >
            <div>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Are you sure you want to delete all selected users?
                </p>
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeUserBulkDeleteModal()"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                        onclick="confirmUserBulkDelete()"
                    >
                        Delete Selected
                    </button>
                </div>
            </div>
        </x-admin.modal>

        <!-- Error/Warning Modal -->
        <div 
            id="user-error-modal" 
            class="hidden fixed inset-0 z-50 flex items-center justify-center"
        >
            <div 
                class="absolute inset-0 bg-black/40"
                onclick="closeUserErrorModal()"
            ></div>

            <div 
                class="relative w-full max-w-xs mx-4 rounded-2xl border shadow-xl"
                style="background-color: var(--bg-card); border-color: var(--border-strong); z-index: 51; pointer-events: auto;"
            >
                <div class="px-5 py-4 border-b" style="border-color: var(--border-default);">
                    <h3 class="text-sm font-bold flex items-center gap-2" style="color: var(--text-primary);">
                        <i class="fas fa-exclamation-triangle text-[var(--color-primary)]"></i>
                        <span id="user-error-title">Warning</span>
                    </h3>
                </div>

                <div class="px-5 py-4">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center" style="background: rgba(239, 68, 68, 0.1);">
                            <i class="fas fa-exclamation-triangle text-lg" style="color: #DC2626;"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs leading-relaxed" style="color: var(--text-muted);" id="user-error-message">This action cannot be performed.</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            class="hr-btn-primary px-4 py-1.5 text-xs"
                            onclick="closeUserErrorModal()"
                        >
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden forms for deletes -->
        <form id="user-delete-form" method="POST" action="#">
            @csrf
        </form>
        <form id="user-bulk-delete-form" method="POST" action="{{ route('admin.users.bulk-delete') }}">
            @csrf
            <input type="hidden" name="ids" id="user-bulk-delete-ids" value="">
        </form>

        <script>
            (function () {
                var userEditUrlTemplate = "{{ route('admin.users.update', ['id' => '__ID__']) }}";
                var userDeleteUrlTemplate = "{{ route('admin.users.delete', ['id' => '__ID__']) }}";

                var pendingUserDeleteId = null;

                function openUserAddModal() {
                    var m = document.getElementById('user-add-modal');
                    if (m) {
                        m.classList.remove('hidden');
                        // Hide page access section initially if "Main User" is checked
                        var mainUserCheckbox = m.querySelector('input[name="is_main_user"][type="checkbox"]');
                        var pageSection = document.getElementById('user-add-page-access-section');
                        if (mainUserCheckbox && pageSection) {
                            pageSection.style.display = mainUserCheckbox.checked ? 'none' : '';
                            mainUserCheckbox.addEventListener('change', function () {
                                pageSection.style.display = this.checked ? 'none' : '';
                            });
                        }
                    }
                }
                window.openUserAddModal = openUserAddModal;

                function closeUserAddModal(reset) {
                    var m = document.getElementById('user-add-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                    }
                }
                window.closeUserAddModal = closeUserAddModal;

                function openUserEditModalFromRow(row) {
                    var info = row.querySelector('[data-user-id]');
                    if (!info) return;

                    var id = info.dataset.userId;
                    var username = info.dataset.userUsername || '';
                    var email = info.dataset.userEmail || '';
                    var roleId = info.dataset.userRoleId || '';
                    var employeeId = info.dataset.userEmployeeId || '';
                    var isActive = info.dataset.userIsActive || '1';
                    var isMainUser = info.dataset.userIsMainUser || '0';
                    var pagePermJson = info.dataset.userPagePermissions || null;

                    var m = document.getElementById('user-edit-modal');
                    if (!m) return;

                    var usernameInput = document.getElementById('user-edit-username');
                    if (usernameInput) usernameInput.value = username;

                    var emailInput = document.getElementById('user-edit-email');
                    if (emailInput) emailInput.value = email;

                    var passwordInput = document.getElementById('user-edit-password');
                    if (passwordInput) passwordInput.value = '';

                    var roleSelect = document.getElementById('user-edit-role-id');
                    if (roleSelect) roleSelect.value = roleId;

                    var employeeSelect = document.getElementById('user-edit-employee-id');
                    if (employeeSelect) employeeSelect.value = employeeId;

                    var isActiveCheckbox = document.getElementById('user-edit-is-active');
                    if (isActiveCheckbox) {
                        isActiveCheckbox.checked = isActive == '1';
                        // Disable if main user
                        if (isMainUser == '1') {
                            isActiveCheckbox.disabled = true;
                        } else {
                            isActiveCheckbox.disabled = false;
                        }
                    }

                    var isMainUserCheckbox = document.getElementById('user-edit-is-main-user');
                    if (isMainUserCheckbox) {
                        isMainUserCheckbox.checked = isMainUser == '1';
                        // Always disable main user checkbox (cannot be changed)
                        if (isMainUser == '1') {
                            isMainUserCheckbox.disabled = true;
                        } else {
                            isMainUserCheckbox.disabled = false;
                        }
                    }

                    // Show/hide page access section based on main user flag
                    var editPageSection = document.getElementById('user-edit-page-access-section');
                    if (editPageSection) {
                        editPageSection.style.display = (isMainUser == '1') ? 'none' : '';
                    }

                    if (isMainUserCheckbox && editPageSection) {
                        isMainUserCheckbox.addEventListener('change', function () {
                            editPageSection.style.display = this.checked ? 'none' : '';
                        });
                    }

                    // Pre-select page access checkboxes for this user (only visible for main user)
                    // Pre-select page access checkboxes for this user (only visible for main user)
                    (function () {
                        var pagePerms = [];
                        if (pagePermJson && pagePermJson.trim() !== '') {
                            var trimmed = pagePermJson.trim();
                            pagePerms = trimmed.split(',').map(function (s) {
                                return s.trim();
                            }).filter(function (s) { return s.length > 0; });
                        }
                        var pageCheckboxes = m.querySelectorAll('input.user-edit-page-permission[name="page_permissions[]"]');
                        pageCheckboxes.forEach(function(cb) {
                            cb.checked = pagePerms.indexOf(cb.value) !== -1;
                        });
                    })();

                    var form = document.getElementById('user-edit-form');
                    if (form) {
                        form.action = userEditUrlTemplate.replace('__ID__', id);
                    }

                    m.classList.remove('hidden');
                }
                window.openUserEditModalFromRow = openUserEditModalFromRow;

                function closeUserEditModal(reset) {
                    var m = document.getElementById('user-edit-modal');
                    if (m) m.classList.add('hidden');
                    if (reset) {
                        var form = m ? m.querySelector('form') : null;
                        if (form) form.reset();
                        // Reset disabled state of checkboxes
                        var isActiveCheckbox = document.getElementById('user-edit-is-active');
                        if (isActiveCheckbox) isActiveCheckbox.disabled = false;
                        var isMainUserCheckbox = document.getElementById('user-edit-is-main-user');
                        if (isMainUserCheckbox) isMainUserCheckbox.disabled = false;
                    }
                }
                window.closeUserEditModal = closeUserEditModal;

                function openUserDeleteModalFromRow(row) {
                    var info = row.querySelector('[data-user-id]');
                    if (!info) return;
                    
                    var isMainUser = info.dataset.userIsMainUser == '1';
                    if (isMainUser) {
                        showUserError('Cannot Delete Main User', 'Main users cannot be deleted. This user account is protected and required for system administration.');
                        return;
                    }
                    
                    pendingUserDeleteId = info.dataset.userId || null;
                    var m = document.getElementById('user-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openUserDeleteModalFromRow = openUserDeleteModalFromRow;

                function closeUserDeleteModal() {
                    var m = document.getElementById('user-delete-modal');
                    if (m) m.classList.add('hidden');
                    pendingUserDeleteId = null;
                }
                window.closeUserDeleteModal = closeUserDeleteModal;

                function confirmUserDelete() {
                    if (!pendingUserDeleteId) {
                        closeUserDeleteModal();
                        return;
                    }
                    var form = document.getElementById('user-delete-form');
                    if (!form) {
                        closeUserDeleteModal();
                        return;
                    }
                    form.action = userDeleteUrlTemplate.replace('__ID__', pendingUserDeleteId);
                    closeUserDeleteModal();
                    form.submit();
                }
                window.confirmUserDelete = confirmUserDelete;

                function openUserBulkDeleteModal() {
                    var m = document.getElementById('user-bulk-delete-modal');
                    if (m) m.classList.remove('hidden');
                }
                window.openUserBulkDeleteModal = openUserBulkDeleteModal;

                function closeUserBulkDeleteModal() {
                    var m = document.getElementById('user-bulk-delete-modal');
                    if (m) m.classList.add('hidden');
                }
                window.closeUserBulkDeleteModal = closeUserBulkDeleteModal;

                function confirmUserBulkDelete() {
                    var table = document.getElementById('users-table');
                    if (!table) {
                        closeUserBulkDeleteModal();
                        return;
                    }
                    var allChecked = table.querySelectorAll('.user-row-checkbox:checked');
                    var ids = [];
                    var hasMainUser = false;
                    
                    allChecked.forEach(function (cb) {
                        if (cb.disabled) {
                            hasMainUser = true;
                            return;
                        }
                        var row = cb.closest('.hr-table-row');
                        if (!row) return;
                        var info = row.querySelector('[data-user-id]');
                        if (info && info.dataset.userId) {
                            if (info.dataset.userIsMainUser == '1') {
                                hasMainUser = true;
                            } else {
                            ids.push(info.dataset.userId);
                        }
                        }
                    });

                    if (hasMainUser && ids.length === 0) {
                        showUserError('Cannot Delete Main Users', 'Main users cannot be deleted. These user accounts are protected and required for system administration.');
                        closeUserBulkDeleteModal();
                        return;
                    }

                    if (!ids.length) {
                        closeUserBulkDeleteModal();
                        return;
                    }

                    var form = document.getElementById('user-bulk-delete-form');
                    var input = document.getElementById('user-bulk-delete-ids');
                    if (!form || !input) {
                        closeUserBulkDeleteModal();
                        return;
                    }

                    input.value = ids.join(',');
                    closeUserBulkDeleteModal();
                    form.submit();
                }
                window.confirmUserBulkDelete = confirmUserBulkDelete;

                function showUserError(title, message) {
                    var modal = document.getElementById('user-error-modal');
                    var titleEl = document.getElementById('user-error-title');
                    var messageEl = document.getElementById('user-error-message');
                    if (modal && titleEl && messageEl) {
                        titleEl.textContent = title;
                        messageEl.textContent = message;
                        modal.classList.remove('hidden');
                    }
                }
                window.showUserError = showUserError;

                function closeUserErrorModal() {
                    var modal = document.getElementById('user-error-modal');
                    if (modal) modal.classList.add('hidden');
                }
                window.closeUserErrorModal = closeUserErrorModal;

                function refreshUserSelectionState() {
                    var table = document.getElementById('users-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('users-master-checkbox');
                    var allRowCheckboxes = table.querySelectorAll('.user-row-checkbox');
                    var rowCheckboxes = Array.from(allRowCheckboxes).filter(function(cb) {
                        return !cb.disabled;
                    });
                    var deleteSelectedBtn = document.getElementById('users-delete-selected');

                    var checkedCount = 0;
                    rowCheckboxes.forEach(function (cb) {
                        if (cb.checked) checkedCount++;
                    });

                    if (deleteSelectedBtn) {
                        deleteSelectedBtn.classList.toggle('hidden', checkedCount === 0);
                    }

                    if (headerCheckbox) {
                        if (rowCheckboxes.length === 0) {
                            headerCheckbox.checked = false;
                        } else if (checkedCount === rowCheckboxes.length && checkedCount > 0) {
                            headerCheckbox.checked = true;
                        } else {
                            headerCheckbox.checked = false;
                        }
                        headerCheckbox.indeterminate = (checkedCount > 0 && checkedCount < rowCheckboxes.length);
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var table = document.getElementById('users-table');
                    if (!table) return;

                    var headerCheckbox = document.getElementById('users-master-checkbox');
                    if (headerCheckbox) {
                        headerCheckbox.addEventListener('change', function () {
                            var allRowCheckboxes = table.querySelectorAll('.user-row-checkbox');
                            allRowCheckboxes.forEach(function (cb) {
                                if (!cb.disabled) {
                                cb.checked = headerCheckbox.checked;
                                }
                            });
                            refreshUserSelectionState();
                        });
                    }

                    table.addEventListener('click', function (e) {
                        var headerCheckboxClick = e.target.closest('#users-master-checkbox');
                        if (headerCheckboxClick) {
                            return;
                        }

                        var editBtn = e.target.closest('.hr-action-edit');
                        var deleteBtn = e.target.closest('.hr-action-delete');
                        var rowCheckbox = e.target.closest('.user-row-checkbox');

                        if (editBtn) {
                            var row = e.target.closest('.hr-table-row');
                            if (row) openUserEditModalFromRow(row);
                            return;
                        }

                        if (deleteBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            var rowDel = deleteBtn.closest('.hr-table-row');
                            if (rowDel) {
                                var info = rowDel.querySelector('[data-user-id]');
                                if (info && info.dataset.userIsMainUser == '1') {
                                    showUserError('Cannot Delete Main User', 'Main users cannot be deleted. This user account is protected and required for system administration.');
                                    return;
                                }
                                openUserDeleteModalFromRow(rowDel);
                            }
                            return;
                        }

                        if (rowCheckbox) {
                            refreshUserSelectionState();
                        }
                    });

                    refreshUserSelectionState();

                    // Reset button handler
                    var resetBtn = document.querySelector('#user-search-form button[type="button"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var form = document.getElementById('user-search-form');
                            if (form) {
                                form.querySelector('input[name="username"]').value = '';
                                form.querySelector('select[name="user_role"]').value = '';
                                form.querySelector('input[name="employee_name"]').value = '';
                                form.querySelector('select[name="status"]').value = '';
                                window.location.href = '{{ route("admin") }}';
                            }
                        });
                    }

                    // Scroll to table section if status message exists (after add/edit/delete)
                    @if(session('status'))
                        var tableSection = document.getElementById('users-table-section');
                        if (tableSection) {
                            setTimeout(function() {
                                tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 100);
                        }
                    @endif

                    // Scroll to table section on search form submit
                    var searchForm = document.getElementById('user-search-form');
                    if (searchForm) {
                        searchForm.addEventListener('submit', function(e) {
                            // Add hash to URL for scrolling after page reload
                            var formAction = searchForm.getAttribute('action') || window.location.pathname;
                            var url = new URL(formAction, window.location.origin);
                            
                            // Get all form inputs
                            var formData = new FormData(searchForm);
                            for (var [key, value] of formData.entries()) {
                                if (value) {
                                    url.searchParams.set(key, value);
                                }
                            }
                            
                            // Add hash for scrolling
                            url.hash = 'users-table-section';
                            
                            // Navigate to the URL with hash
                            window.location.href = url.toString();
                            e.preventDefault();
                        });
                    }

                    // Scroll to table section if hash exists or if search parameters are present
                    if (window.location.hash === '#users-table-section' || 
                        (window.location.search && (window.location.search.includes('username=') || 
                         window.location.search.includes('user_role=') || 
                         window.location.search.includes('employee_name=') || 
                         window.location.search.includes('status=')))) {
                        var tableSection = document.getElementById('users-table-section');
                        if (tableSection) {
                            setTimeout(function() {
                                tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 300);
                        }
                    }
                });
            })();
        </script>
    </x-main-layout>
@endsection
