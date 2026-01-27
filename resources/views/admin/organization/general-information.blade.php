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
                value="TOAIHRM" 
                :required="true"
                :readonly="true" />
            
            <x-admin.form-field 
                label="Number of Employees" 
                name="num_employees" 
                value="104" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Registration Number" 
                name="registration_number" 
                value="1234" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Tax ID" 
                name="tax_id" 
                value="5678" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Phone" 
                name="phone" 
                value="0123456789" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Fax" 
                name="fax" 
                value="9101" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Email" 
                name="email" 
                type="email"
                value="info@toaihrm.com" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Address Street 1" 
                name="address_street_1" 
                value="538 Teal Plaza" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Address Street 2" 
                name="address_street_2" 
                value="Mysore" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="City" 
                name="city" 
                value="Secaucus" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="State/Province" 
                name="state_province" 
                value="NJ" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Zip/Postal Code" 
                name="zip_postal_code" 
                value="51217" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Country" 
                name="country" 
                value="United States" 
                :readonly="true" />
            
            <x-admin.form-field 
                label="Notes" 
                name="notes" 
                type="textarea"
                value="HRM Software" 
                :readonly="true"
                class="md:col-span-2" />
            
            <x-slot name="footer">
                <p class="text-xs text-gray-500">* Required</p>
            </x-slot>
        </x-admin.form-section>
    </x-main-layout>
@endsection

