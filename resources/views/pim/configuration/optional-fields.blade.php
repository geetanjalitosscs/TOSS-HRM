@extends('layouts.app')

@section('title', 'PIM - Optional Fields')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-optional-fields" />

        <!-- Page Background with Card Container -->
        <div class="p-4" style="background: var(--bg-main); min-height: calc(100vh - 200px);">
            <div class="max-w-4xl mx-auto">
                <!-- Main Card Container -->
                <div class="rounded-xl shadow-lg p-6" style="background: var(--bg-card); border: 1px solid var(--border-default);">
                    <!-- Page Title -->
                    <h2 class="text-lg font-bold mb-2" style="color: var(--text-primary);">Optional Fields</h2>
                    <p class="text-sm mb-6" style="color: var(--text-secondary);">Select the fields that should be displayed in the "Add Employee" and "Employee List" screens.</p>
                    
                    <!-- Section 1: Optional Fields -->
                    <div class="mb-8">
                        <h3 class="text-base font-semibold mb-4" style="color: var(--text-primary);">Optional Fields</h3>
                        <div class="border-b mb-4" style="border-color: var(--border-default);"></div>
                        
                        <!-- Show Deprecated Fields Row -->
                        <div class="flex items-center justify-between py-3">
                            <div class="flex-1">
                                <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show Deprecated Fields</label>
                                <p class="text-xs mt-1" style="color: var(--text-muted);">Show Nick Name, Smoker and Military Service in Personal Details</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <x-admin.toggle-switch id="show-deprecated" :checked="true" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Country Specific Information -->
                    <div class="mb-8">
                        <h3 class="text-base font-semibold mb-4" style="color: var(--text-primary);">Country Specific Information</h3>
                        <div class="border-b mb-4" style="border-color: var(--border-default);"></div>
                        
                        <!-- Show SSN Row -->
                        <div class="flex items-center justify-between py-3">
                            <div class="flex-1">
                                <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show SSN field in Personal Details</label>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <x-admin.toggle-switch id="show-ssn" :checked="true" />
                            </div>
                        </div>

                        <!-- Show SIN Row -->
                        <div class="flex items-center justify-between py-3">
                            <div class="flex-1">
                                <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show SIN field in Personal Details</label>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <x-admin.toggle-switch id="show-sin" :checked="false" />
                            </div>
                        </div>

                        <!-- Show US Tax Exemptions Row -->
                        <div class="flex items-center justify-between py-3">
                            <div class="flex-1">
                                <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show US Tax Exemptions menu</label>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <x-admin.toggle-switch id="show-tax" :checked="false" />
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action Button -->
                    <div class="flex justify-end pt-6 mt-6" style="border-top: 1px solid var(--border-default);">
                        <button type="submit" class="hr-btn-primary px-6 py-2.5 text-sm font-medium">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>

@endsection
