@extends('layouts.app')

@section('title', 'Admin - LDAP Configuration')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-ldap" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold" style="color: var(--text-primary);">LDAP Configuration</h2>
                <label class="flex items-center gap-3 cursor-pointer">
                    <span class="text-sm font-medium" style="color: var(--text-secondary);">Enable</span>
                    <div class="relative">
                        <input type="checkbox" class="sr-only" id="ldap-enable-toggle">
                        <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200" id="ldap-enable-toggle-bg">
                            <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="ldap-enable-toggle-circle" style="margin-top: 2px;"></div>
                        </div>
                    </div>
                </label>
            </div>

            <form class="space-y-6">
                <!-- Server Settings -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold mb-4" style="color: var(--text-primary);">Server Settings</h3>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Host <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="host" 
                            value="localhost" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">LDAP Server IP or Hostname without the protocol (without ldap:// or ldaps://)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Port <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="port" 
                            value="389" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">If SSL use port 636 by default</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Encryption
                        </label>
                        <select 
                            name="encryption" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <option value="">-- Select --</option>
                            <option value="none">None</option>
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            LDAP Implementation
                        </label>
                        <select 
                            name="ldap_implementation" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <option value="openldap" selected>Open LDAP v3</option>
                            <option value="activedirectory">Active Directory</option>
                        </select>
                    </div>
                </div>

                <!-- Bind Settings -->
                <div class="space-y-4 pt-4 border-t" style="border-color: var(--border-default);">
                    <h3 class="text-md font-semibold mb-4" style="color: var(--text-primary);">Bind Settings</h3>
                    
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <span class="text-sm font-medium" style="color: var(--text-secondary);">Bind Anonymously</span>
                            <div class="relative">
                                <input type="checkbox" class="sr-only" id="bind-anonymously-toggle">
                                <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200" id="bind-anonymously-toggle-bg">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="bind-anonymously-toggle-circle" style="margin-top: 2px;"></div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Distinguished Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="distinguished_name" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                    </div>
                </div>

                <!-- User Lookup Settings -->
                <div class="space-y-4 pt-4 border-t" style="border-color: var(--border-default);">
                    <h3 class="text-md font-semibold mb-4" style="color: var(--text-primary);">User Lookup Settings</h3>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Base Distinguished Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="base_dn" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Search Scope
                        </label>
                        <select 
                            name="search_scope" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <option value="subtree" selected>Subtree</option>
                            <option value="onelevel">One Level</option>
                        </select>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Subtree option will allow searching base directory and sub directories. One level will only search within the base directory</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            User Name Attribute <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="username_attribute" 
                            value="cn" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Attribute field to use when loading the username. Ex: cn, SAM account name</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            User Search Filter <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="user_search_filter" 
                            value="objectClass=person" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Attribute field to use when searching user objects. Ex: objectClass=person</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            User Unique ID Attribute
                        </label>
                        <input 
                            type="text" 
                            name="user_unique_id_attribute" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                        <p class="mt-1 text-xs" style="color: var(--text-muted);">Attribute field to use as a unique immutable identifier for user objects. This is used to track username changes. Ex: entryUUID, objectGUID</p>
                    </div>
                </div>

                <!-- Data Mapping -->
                <div class="space-y-4 pt-4 border-t" style="border-color: var(--border-default);">
                    <h3 class="text-md font-semibold mb-4" style="color: var(--text-primary);">Data Mapping</h3>
                    
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm font-medium" style="color: var(--text-secondary);">Field in TOAI HR</div>
                        <div></div>
                        <div class="text-sm font-medium" style="color: var(--text-secondary);">Field in LDAP Directory</div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm" style="color: var(--text-primary);">First Name <span class="text-red-500">*</span></div>
                        <div class="text-center">
                            <i class="fas fa-arrow-left" style="color: var(--text-muted);"></i>
                        </div>
                        <div>
                            <input 
                                type="text" 
                                name="first_name_attribute" 
                                value="givenName" 
                                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm" style="color: var(--text-primary);">Middle Name</div>
                        <div class="text-center">
                            <i class="fas fa-arrow-left" style="color: var(--text-muted);"></i>
                        </div>
                        <div>
                            <input 
                                type="text" 
                                name="middle_name_attribute" 
                                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm" style="color: var(--text-primary);">Last Name <span class="text-red-500">*</span></div>
                        <div class="text-center">
                            <i class="fas fa-arrow-left" style="color: var(--text-muted);"></i>
                        </div>
                        <div>
                            <input 
                                type="text" 
                                name="last_name_attribute" 
                                value="sn" 
                                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm" style="color: var(--text-primary);">User Status</div>
                        <div class="text-center">
                            <i class="fas fa-arrow-left" style="color: var(--text-muted);"></i>
                        </div>
                        <div>
                            <input 
                                type="text" 
                                name="user_status_attribute" 
                                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm" style="color: var(--text-primary);">Work Email</div>
                        <div class="text-center">
                            <i class="fas fa-arrow-left" style="color: var(--text-muted);"></i>
                        </div>
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                name="work_email_attribute" 
                                class="flex-1 px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only" id="work-email-mapping-toggle">
                                <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200" id="work-email-mapping-toggle-bg">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="work-email-mapping-toggle-circle" style="margin-top: 2px;"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <div class="text-sm" style="color: var(--text-primary);">Employee Id</div>
                        <div class="text-center">
                            <i class="fas fa-arrow-left" style="color: var(--text-muted);"></i>
                        </div>
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                name="employee_id_attribute" 
                                class="flex-1 px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                                style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only" id="employee-id-mapping-toggle">
                                <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200" id="employee-id-mapping-toggle-bg">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="employee-id-mapping-toggle-circle" style="margin-top: 2px;"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <p class="text-xs mt-2" style="color: var(--text-muted);">Use this field as the employee / user mapping field</p>
                </div>

                <!-- Additional Settings -->
                <div class="space-y-4 pt-4 border-t" style="border-color: var(--border-default);">
                    <h3 class="text-md font-semibold mb-4" style="color: var(--text-primary);">Additional Settings</h3>
                    
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <span class="text-sm font-medium" style="color: var(--text-secondary);">Merge LDAP Users With Existing System Users</span>
                            <div class="relative">
                                <input type="checkbox" class="sr-only" id="merge-users-toggle">
                                <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200" id="merge-users-toggle-bg">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="merge-users-toggle-circle" style="margin-top: 2px;"></div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Sync Interval (in Hours) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="sync_interval" 
                            value="1" 
                            class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                            style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                            required>
                    </div>
                </div>

                <!-- Warning Message -->
                <div class="p-4 rounded-md border-l-4" style="background: rgba(251, 191, 36, 0.1); border-color: #FBBF24;">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle mt-0.5" style="color: #FBBF24;"></i>
                        <p class="text-sm" style="color: var(--text-primary);">
                            Before activating the LDAP service, make sure that all LDAP settings are functioning properly since incorrect configuration may result in corrupted data. As a precaution, we recommend you to create a backup of your database before continuing.
                        </p>
                    </div>
                </div>

                <!-- Required Field Note -->
                <div class="mt-4">
                    <p class="text-xs" style="color: var(--text-muted);">* Required</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="button" class="px-4 py-2 rounded-md text-sm font-medium transition-colors" style="border: 1px solid var(--color-hr-primary); color: var(--color-hr-primary); background: var(--bg-card);" onmouseover="this.style.background='var(--bg-hover)'" onmouseout="this.style.background='var(--bg-card)'">
                        Test Connection
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white transition-colors" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'" onmouseout="this.style.background='var(--color-hr-primary)'">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </x-main-layout>

    <script>
        // LDAP Enable toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = [
                { id: 'ldap-enable-toggle', bg: 'ldap-enable-toggle-bg', circle: 'ldap-enable-toggle-circle' },
                { id: 'bind-anonymously-toggle', bg: 'bind-anonymously-toggle-bg', circle: 'bind-anonymously-toggle-circle' },
                { id: 'work-email-mapping-toggle', bg: 'work-email-mapping-toggle-bg', circle: 'work-email-mapping-toggle-circle' },
                { id: 'employee-id-mapping-toggle', bg: 'employee-id-mapping-toggle-bg', circle: 'employee-id-mapping-toggle-circle' },
                { id: 'merge-users-toggle', bg: 'merge-users-toggle-bg', circle: 'merge-users-toggle-circle' }
            ];

            toggles.forEach(({ id, bg, circle }) => {
                const toggle = document.getElementById(id);
                if (toggle) {
                    toggle.addEventListener('change', function() {
                        const bgEl = document.getElementById(bg);
                        const circleEl = document.getElementById(circle);
                        if (this.checked) {
                            bgEl.classList.add('bg-[var(--color-hr-primary)]');
                            bgEl.classList.remove('bg-gray-200');
                            circleEl.classList.add('translate-x-5');
                            circleEl.classList.remove('translate-x-0.5');
                        } else {
                            bgEl.classList.remove('bg-[var(--color-hr-primary)]');
                            bgEl.classList.add('bg-gray-200');
                            circleEl.classList.remove('translate-x-5');
                            circleEl.classList.add('translate-x-0.5');
                        }
                    });
                }
            });
        });
    </script>
@endsection

