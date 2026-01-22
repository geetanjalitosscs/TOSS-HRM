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
                                <div class="relative">
                                    <input type="checkbox" class="sr-only toggle-switch" id="show-deprecated" checked>
                                    <label for="show-deprecated" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer block border" style="background: var(--color-hr-primary); border-color: var(--border-strong);">
                                        <div class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5" style="background: white; margin-top: 2px;"></div>
                                    </label>
                                </div>
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
                                <div class="relative">
                                    <input type="checkbox" class="sr-only toggle-switch" id="show-ssn" checked>
                                    <label for="show-ssn" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer block border" style="background: var(--color-hr-primary); border-color: var(--border-strong);">
                                        <div class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-5" style="background: white; margin-top: 2px;"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Show SIN Row -->
                        <div class="flex items-center justify-between py-3">
                            <div class="flex-1">
                                <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show SIN field in Personal Details</label>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only toggle-switch" id="show-sin">
                                    <label for="show-sin" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer block border" style="background: #E5E7EB; border-color: #D1D5DB;">
                                        <div class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" style="background: white; margin-top: 2px;"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Show US Tax Exemptions Row -->
                        <div class="flex items-center justify-between py-3">
                            <div class="flex-1">
                                <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show US Tax Exemptions menu</label>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only toggle-switch" id="show-tax">
                                    <label for="show-tax" class="w-11 h-6 rounded-full transition-colors duration-200 cursor-pointer block border" style="background: #E5E7EB; border-color: #D1D5DB;">
                                        <div class="w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" style="background: white; margin-top: 2px;"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action Button -->
                    <div class="flex justify-end pt-6 mt-6" style="border-top: 1px solid var(--border-default);">
                        <button type="submit" class="px-6 py-2.5 rounded-full text-sm font-medium text-white transition-all shadow-md hover:shadow-lg" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'" onmouseout="this.style.background='var(--color-hr-primary)'">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle-switch');
            toggles.forEach(toggle => {
                // Set initial state
                const label = toggle.nextElementSibling;
                const circle = label.querySelector('div');
                if (toggle.checked) {
                    label.style.background = 'var(--color-hr-primary)';
                    label.style.borderColor = 'var(--border-strong)';
                    circle.classList.add('translate-x-5');
                    circle.classList.remove('translate-x-0.5');
                } else {
                    label.style.background = '#E5E7EB';
                    label.style.borderColor = '#D1D5DB';
                    circle.classList.remove('translate-x-5');
                    circle.classList.add('translate-x-0.5');
                }

                // Handle changes
                toggle.addEventListener('change', function() {
                    if (this.checked) {
                        label.style.background = 'var(--color-hr-primary)';
                        label.style.borderColor = 'var(--border-strong)';
                        circle.classList.add('translate-x-5');
                        circle.classList.remove('translate-x-0.5');
                    } else {
                        label.style.background = '#E5E7EB';
                        label.style.borderColor = '#D1D5DB';
                        circle.classList.remove('translate-x-5');
                        circle.classList.add('translate-x-0.5');
                    }
                });
            });
        });
    </script>
@endsection
