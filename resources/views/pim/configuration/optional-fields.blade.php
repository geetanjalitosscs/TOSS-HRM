@extends('layouts.app')

@section('title', 'PIM - Optional Fields')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-optional-fields" />

        <!-- Main Card - Attached to Tabs -->
        <form method="POST" action="{{ route('pim.configuration.optional-fields.save') }}">
            @csrf
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
                        <input type="hidden" name="show_deprecated" id="show-deprecated-input" value="{{ $showDeprecated ? 1 : 0 }}">
                        <x-admin.toggle-switch
                            id="show-deprecated"
                            :checked="$showDeprecated"
                            onChange="pimOptionalToggleChanged(this, 'show-deprecated-input')"
                        />
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
                        <input type="hidden" name="show_ssn" id="show-ssn-input" value="{{ $showSSN ? 1 : 0 }}">
                        <x-admin.toggle-switch
                            id="show-ssn"
                            :checked="$showSSN"
                            onChange="pimOptionalToggleChanged(this, 'show-ssn-input')"
                        />
                    </div>
                </div>

                <!-- Show SIN Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex-1">
                        <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show SIN field in Personal Details</label>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <input type="hidden" name="show_sin" id="show-sin-input" value="{{ $showSIN ? 1 : 0 }}">
                        <x-admin.toggle-switch
                            id="show-sin"
                            :checked="$showSIN"
                            onChange="pimOptionalToggleChanged(this, 'show-sin-input')"
                        />
                    </div>
                </div>

                <!-- Show US Tax Exemptions Row -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex-1">
                        <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">Show US Tax Exemptions menu</label>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <input type="hidden" name="show_tax" id="show-tax-input" value="{{ $showTax ? 1 : 0 }}">
                        <x-admin.toggle-switch
                            id="show-tax"
                            :checked="$showTax"
                            onChange="pimOptionalToggleChanged(this, 'show-tax-input')"
                        />
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
        </form>
    </x-main-layout>

    <script>
        function pimOptionalToggleChanged(inputEl, hiddenId) {
            // Update hidden field for form submit
            var hidden = document.getElementById(hiddenId);
            if (hidden) {
                hidden.value = inputEl.checked ? 1 : 0;
            }

            // Update visual toggle track + circle (same logic as default component)
            var label = inputEl.nextElementSibling;
            if (!label) return;
            var circle = label.querySelector('div');
            if (!circle) return;

            if (inputEl.checked) {
                label.style.background = 'var(--color-hr-primary)';
                label.style.borderColor = 'var(--border-strong)';
                circle.classList.add('translate-x-5');
                circle.classList.remove('translate-x-0.5');
            } else {
                label.style.background = 'var(--bg-input)';
                label.style.borderColor = 'var(--border-default)';
                circle.classList.remove('translate-x-5');
                circle.classList.add('translate-x-0.5');
            }
        }
    </script>

@endsection
