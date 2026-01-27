@extends('layouts.app')

@section('title', 'PIM - Optional Fields')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-optional-fields" />

        <!-- Main Card - Attached to Tabs -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <!-- Page Title with Icon -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-sliders-h" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Optional Fields</span>
                </h2>
            </div>
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
        </section>
    </x-main-layout>

@endsection
