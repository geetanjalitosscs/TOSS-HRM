@extends('layouts.app')

@section('title', 'Admin - General Information')

@section('body')
    <x-main-layout title="Admin / Organization">
        <x-admin.tabs activeTab="organization-general" />

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
            
            <x-admin.form-field 
                label="Number of Employees" 
                name="num_employees" 
                value="{{ $employeeCount ?? 0 }}" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Registration Number" 
                name="registration_number" 
                value="{{ $organization->registration_number ?? '' }}" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Tax ID" 
                name="tax_id" 
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Phone" 
                name="phone" 
                value="{{ $organization->phone ?? '' }}" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Fax" 
                name="fax" 
                value="" 
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
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Address Street 2" 
                name="address_street_2" 
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="City" 
                name="city" 
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="State/Province" 
                name="state_province" 
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Zip/Postal Code" 
                name="zip_postal_code" 
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Country" 
                name="country" 
                value="" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Notes" 
                name="notes" 
                type="textarea"
                value="" 
                :readonly="true"
                class="md:col-span-2" />
            
            <x-slot name="footer">
                <p class="text-xs text-gray-500">* Required</p>
            </x-slot>
        </x-admin.form-section>
    </x-main-layout>
@endsection

