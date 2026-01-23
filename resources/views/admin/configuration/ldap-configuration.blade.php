@extends('layouts.app')

@section('title', 'Admin - LDAP Configuration')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-ldap" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2">
                    <i class="fas fa-server text-purple-500"></i> <span class="mt-0.5">LDAP Configuration</span>
                </h2>
                <div class="relative">
                    <input type="checkbox" class="sr-only" id="ldap-enable-toggle">
                    <label for="ldap-enable-toggle" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer flex items-center">
                        <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5"></div>
                    </label>
                </div>
            </div>

            <form class="space-y-6">
                <!-- Server Settings -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--text-primary);">Server Settings</h3>
                    
                    <x-admin.form-field 
                        label="Host" 
                        name="host" 
                        value="localhost"
                        :required="true" />
                    
                    <x-admin.form-field 
                        label="Port" 
                        name="port" 
                        value="389"
                        :required="true" />
                    
                    <p class="text-xs" style="color: var(--text-muted);">
                        LDAP Server IP or Hostname without the protocol (without ldap:// or ldaps://)
                    </p>
                    <p class="text-xs" style="color: var(--text-muted);">
                        If SSL use port 636 by default
                    </p>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Encryption
                        </label>
                        <select name="encryption" class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <option value="">-- Select --</option>
                            <option value="none">None</option>
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            LDAP Implementation
                        </label>
                        <select name="ldap_implementation" class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <option value="openldap" selected>Open LDAP v3</option>
                            <option value="activedirectory">Active Directory</option>
                        </select>
                    </div>
                </div>

                <!-- Bind Settings -->
                <div class="space-y-4 pt-4" style="border-top: 1px solid var(--border-default);">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--text-primary);">Bind Settings</h3>
                    
                    <div class="mb-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <span class="text-sm font-medium" style="color: var(--text-secondary);">Bind Anonymously</span>
                            <div class="relative">
                                <input type="checkbox" class="sr-only" id="bind-anonymous-toggle">
                                <label for="bind-anonymous-toggle" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer flex items-center">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5"></div>
                                </label>
                            </div>
                        </label>
                    </div>
                    
                    <x-admin.form-field 
                        label="Distinguished Name" 
                        name="distinguished_name" 
                        value=""
                        :required="true" />
                    
                    <x-admin.form-field 
                        label="Password" 
                        name="password" 
                        type="password"
                        value=""
                        :required="true" />
                </div>

                <!-- User Lookup Settings -->
                <div class="space-y-4 pt-4" style="border-top: 1px solid var(--border-default);">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--text-primary);">User Lookup Settings</h3>
                    
                    <x-admin.form-field 
                        label="Base Distinguished Name" 
                        name="base_dn" 
                        value=""
                        :required="true" />
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                            Search Scope
                        </label>
                        <select name="search_scope" class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            <option value="subtree" selected>Subtree</option>
                            <option value="onelevel">One Level</option>
                        </select>
                        <p class="text-xs mt-1" style="color: var(--text-muted);">
                            Subtree option will allow searching base directory and sub directories. One level will only search within the base directory.
                        </p>
                    </div>
                    
                    <x-admin.form-field 
                        label="User Name Attribute" 
                        name="username_attribute" 
                        value="cn"
                        :required="true" />
                    <p class="text-xs -mt-3" style="color: var(--text-muted);">
                        Attribute field to use when loading the username. Ex: cn, SMA account name
                    </p>
                    
                    <x-admin.form-field 
                        label="User Search Filter" 
                        name="user_search_filter" 
                        value="objectClass=person"
                        :required="true" />
                    <p class="text-xs -mt-3" style="color: var(--text-muted);">
                        Attribute field to use when searching user objects. Ex: objectClass=person
                    </p>
                    
                    <x-admin.form-field 
                        label="User Unique ID Attribute" 
                        name="user_unique_id_attribute" 
                        value="" />
                    <p class="text-xs -mt-3" style="color: var(--text-muted);">
                        Attribute field to use as a unique immutable identifier for user objects. This is used to track username changes. Ex: entryUUID, objectGUID
                    </p>
                </div>

                <!-- Data Mapping -->
                <div class="space-y-4 pt-4" style="border-top: 1px solid var(--border-default);">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--text-primary);">Data Mapping</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" value="givenName" class="w-full px-3 py-2 border rounded-md text-sm" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            </div>
                            <div class="flex-shrink-0 pt-6">
                                <i class="fas fa-arrow-left text-gray-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Field in LDAP Directory
                                </label>
                                <input type="text" value="givenName" readonly class="w-full px-3 py-2 border rounded-md text-sm bg-gray-50" style="border-color: var(--border-default); color: var(--text-muted);">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Middle Name
                                </label>
                                <input type="text" name="middle_name" value="" class="w-full px-3 py-2 border rounded-md text-sm" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            </div>
                            <div class="flex-shrink-0 pt-6">
                                <i class="fas fa-arrow-left text-gray-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Field in LDAP Directory
                                </label>
                                <input type="text" value="" readonly class="w-full px-3 py-2 border rounded-md text-sm bg-gray-50" style="border-color: var(--border-default); color: var(--text-muted);">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" value="sn" class="w-full px-3 py-2 border rounded-md text-sm" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            </div>
                            <div class="flex-shrink-0 pt-6">
                                <i class="fas fa-arrow-left text-gray-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Field in LDAP Directory
                                </label>
                                <input type="text" value="sn" readonly class="w-full px-3 py-2 border rounded-md text-sm bg-gray-50" style="border-color: var(--border-default); color: var(--text-muted);">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    User Status
                                </label>
                                <input type="text" name="user_status" value="" class="w-full px-3 py-2 border rounded-md text-sm" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            </div>
                            <div class="flex-shrink-0 pt-6">
                                <i class="fas fa-arrow-left text-gray-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Field in LDAP Directory
                                </label>
                                <input type="text" value="" readonly class="w-full px-3 py-2 border rounded-md text-sm bg-gray-50" style="border-color: var(--border-default); color: var(--text-muted);">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Work Email
                                </label>
                                <input type="text" name="work_email" value="" class="w-full px-3 py-2 border rounded-md text-sm" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            </div>
                            <div class="flex-shrink-0 pt-6">
                                <i class="fas fa-arrow-left text-gray-400"></i>
                            </div>
                            <div class="flex-1 flex items-center gap-2">
                                <input type="text" value="" readonly class="flex-1 px-3 py-2 border rounded-md text-sm bg-gray-50" style="border-color: var(--border-default); color: var(--text-muted);">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only" id="work-email-toggle">
                                    <label for="work-email-toggle" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer flex items-center">
                                        <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                                    Employee Id
                                </label>
                                <input type="text" name="employee_id" value="" class="w-full px-3 py-2 border rounded-md text-sm" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                            </div>
                            <div class="flex-shrink-0 pt-6">
                                <i class="fas fa-arrow-left text-gray-400"></i>
                            </div>
                            <div class="flex-1 flex items-center gap-2">
                                <input type="text" value="" readonly class="flex-1 px-3 py-2 border rounded-md text-sm bg-gray-50" style="border-color: var(--border-default); color: var(--text-muted);">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only" id="employee-id-toggle">
                                    <label for="employee-id-toggle" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer flex items-center">
                                        <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-xs mt-2" style="color: var(--text-muted);">
                            Use this field as the employee / user mapping field
                        </p>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="space-y-4 pt-4" style="border-top: 1px solid var(--border-default);">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--text-primary);">Additional Settings</h3>
                    
                    <div class="mb-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <span class="text-sm font-medium" style="color: var(--text-secondary);">Merge LDAP Users With Existing System Users</span>
                            <div class="relative">
                                <input type="checkbox" class="sr-only" id="merge-users-toggle">
                                <label for="merge-users-toggle" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer flex items-center">
                                    <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5"></div>
                                </label>
                            </div>
                        </label>
                    </div>
                    
                    <x-admin.form-field 
                        label="Sync Interval (in Hours)" 
                        name="sync_interval" 
                        value="1"
                        :required="true" />
                </div>

                <!-- Warning Message -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                    <p class="text-sm text-yellow-800">
                        Before activating the LDAP service, make sure that all LDAP settings are functioning properly since incorrect configuration may result in corrupted data. As a precaution, we recommend you to create a backup of your database before continuing.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="button" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                        Test Connection
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium">
                        Save
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>

    <script>
        // LDAP Enable toggle
        document.addEventListener('DOMContentLoaded', function() {
            const enableToggle = document.getElementById('ldap-enable-toggle');
            if (enableToggle) {
                enableToggle.addEventListener('change', function() {
                    const label = this.nextElementSibling;
                    const circle = label.querySelector('div');
                    if (this.checked) {
                        label.style.background = 'var(--color-hr-primary)';
                        circle.classList.add('translate-x-5');
                        circle.classList.remove('translate-x-0.5');
                    } else {
                        label.style.background = 'var(--bg-hover)';
                        circle.classList.remove('translate-x-5');
                        circle.classList.add('translate-x-0.5');
                    }
                });
            }

            // Other toggles
            const toggles = ['bind-anonymous-toggle', 'work-email-toggle', 'employee-id-toggle', 'merge-users-toggle'];
            toggles.forEach(toggleId => {
                const toggle = document.getElementById(toggleId);
                if (toggle) {
                    toggle.addEventListener('change', function() {
                        const label = this.nextElementSibling;
                        const circle = label.querySelector('div');
                        if (this.checked) {
                            label.style.background = 'var(--color-hr-primary)';
                            circle.classList.add('translate-x-5');
                            circle.classList.remove('translate-x-0.5');
                        } else {
                            label.style.background = 'var(--bg-hover)';
                            circle.classList.remove('translate-x-5');
                            circle.classList.add('translate-x-0.5');
                        }
                    });
                }
            });
        });
    </script>
@endsection

