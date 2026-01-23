@extends('layouts.app')

@section('title', 'PIM - Add Employee')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="add-employee" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-user-plus text-purple-500"></i> <span class="mt-0.5">Add Employee</span>
            </h2>

            <div class="flex gap-6">
                <!-- Left: Employee Photo -->
                <div class="flex-shrink-0">
                    <div class="relative w-32 h-32 rounded-full flex items-center justify-center overflow-hidden" style="background: var(--bg-hover); border: 2px solid var(--border-default);">
                        <i class="fas fa-user text-4xl" style="color: var(--text-muted);"></i>
                        <button class="absolute bottom-0 right-0 w-8 h-8 rounded-full flex items-center justify-center text-white transition-all shadow-md hover:shadow-lg" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='var(--color-hr-primary)'; this.style.transform='scale(1)'">
                            <i class="fas fa-camera text-xs"></i>
                        </button>
                    </div>
                    <p class="text-xs mt-2 max-w-32" style="color: var(--text-muted);">Accepts jpg, .png, .gif up to 1MB. Recommended dimensions: 200px X 200px</p>
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
                            <x-admin.toggle-switch id="create-login-toggle" :checked="false" />
                        </div>
                    </div>

                    <!-- Required Note -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500"><span class="text-red-500">*</span> Required</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2">
                        <button type="button" class="hr-btn-secondary px-4 py-2 text-xs font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="hr-btn-primary px-4 py-2 text-xs font-medium">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </x-main-layout>

@endsection

