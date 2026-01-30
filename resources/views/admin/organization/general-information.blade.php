@extends('layouts.app')

@section('title', 'Admin - General Information')

@section('body')
    <x-main-layout title="Admin / Organization">
        <x-admin.tabs activeTab="organization-general" />

        <form method="POST" action="{{ route('admin.organization.general-information.update') }}" id="organization-general-form">
            @csrf
            <x-admin.form-section 
                title="General Information" 
                :editMode="false"
                :showEditToggle="true">
                <x-admin.form-field 
                    label="Organization Name" 
                    name="organization_name" 
                    value="{{ $organization->name ?? '' }}" 
                    :required="true"
                    :readonly="true" />
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary);">
                        Number of Employees
                    </label>
                    <input 
                        type="text" 
                        value="{{ $employeeCount ?? 0 }}" 
                        readonly
                        class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-transparent"
                        style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-hover);"
                    >
                </div>
                
                <x-admin.form-field 
                    label="Registration Number" 
                    name="registration_number" 
                    value="{{ $organization->registration_number ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Tax ID" 
                    name="tax_id" 
                    value="{{ $organization->tax_id ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Phone" 
                    name="phone" 
                    value="{{ $organization->phone ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Fax" 
                    name="fax" 
                    value="{{ $organization->fax ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Email" 
                    name="email" 
                    type="email"
                    value="{{ $organization->email ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Address Street 1" 
                    name="address_street_1" 
                    value="{{ $organization->address_line1 ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Address Street 2" 
                    name="address_street_2" 
                    value="{{ $organization->address_line2 ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="City" 
                    name="city" 
                    value="{{ $organization->city ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="State/Province" 
                    name="state_province" 
                    value="{{ $organization->state ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Zip/Postal Code" 
                    name="zip_postal_code" 
                    value="{{ $organization->zip_postal_code ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Country" 
                    name="country" 
                    value="{{ $organization->country ?? '' }}" 
                    :readonly="true" />
                
                <x-admin.form-field 
                    label="Notes" 
                    name="notes" 
                    type="textarea"
                    value="{{ $organization->notes ?? '' }}" 
                    :readonly="true"
                    class="md:col-span-2" />
                
                <x-slot name="footer">
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-500">* Required</p>
                        <button 
                            type="submit" 
                            id="save-organization-btn"
                            class="hr-btn-primary px-4 py-1.5 text-xs hidden"
                        >
                            Save
                        </button>
                    </div>
                </x-slot>
            </x-admin.form-section>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('organization-general-form');
                var saveBtn = document.getElementById('save-organization-btn');
                var editToggle = document.querySelector('input[type="checkbox"][id^="edit-toggle-"]');
                
                if (editToggle && saveBtn) {
                    // Show/hide save button based on edit toggle
                    editToggle.addEventListener('change', function() {
                        if (this.checked) {
                            saveBtn.classList.remove('hidden');
                        } else {
                            saveBtn.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </x-main-layout>
@endsection

