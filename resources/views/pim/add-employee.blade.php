@extends('layouts.app')

@section('title', 'PIM - Add Employee')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="add-employee" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Add Employee</h2>

            <div class="flex gap-6">
                <!-- Left: Employee Photo -->
                <div class="flex-shrink-0">
                    <div class="relative w-32 h-32 rounded-full bg-gray-100 border-2 border-gray-300 flex items-center justify-center overflow-hidden">
                        <i class="fas fa-user text-4xl text-gray-400"></i>
                        <button class="absolute bottom-0 right-0 w-8 h-8 bg-[var(--color-hr-primary)] rounded-full flex items-center justify-center text-white hover:bg-[var(--color-hr-primary-dark)] transition-colors">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 max-w-32">Accepts jpg, .png, .gif up to 1MB. Recommended dimensions: 200px X 200px</p>
                </div>

                <!-- Right: Form Fields -->
                <div class="flex-1">
                    <!-- Employee Full Name -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Full Name <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="First Name">
                            </div>
                            <div>
                                <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Middle Name">
                            </div>
                            <div>
                                <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Last Name">
                            </div>
                        </div>
                    </div>

                    <!-- Employee ID -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                        <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" value="0386">
                    </div>

                    <!-- Create Login Details -->
                    <div class="mb-4 flex items-center gap-2">
                        <label class="text-xs font-medium text-slate-700">Create Login Details</label>
                        <div class="relative">
                            <input type="checkbox" class="sr-only toggle-switch" id="create-login-toggle">
                            <label for="create-login-toggle" class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 cursor-pointer block">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" style="margin-top: 2px;"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Required Note -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500"><span class="text-red-500">*</span> Required</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2">
                        <button class="px-4 py-2 text-xs font-medium text-purple-600 border border-purple-300 rounded-lg hover:bg-purple-50 transition-all">
                            Cancel
                        </button>
                        <button class="px-4 py-2 text-xs font-medium text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-md transition-all shadow-sm">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('create-login-toggle');
            const label = toggle.nextElementSibling;
            const circle = label.querySelector('div');
            
            toggle.addEventListener('change', function() {
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
        });
    </script>
@endsection

