@extends('layouts.app')

@section('title', ($mode ?? 'create') === 'edit' ? 'PIM - Edit Employee' : 'PIM - Add Employee')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="add-employee" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="{{ ($mode ?? 'create') === 'edit' ? 'fas fa-user-edit' : 'fas fa-user-plus' }} text-[var(--color-primary)]"></i>
                <span class="mt-0.5">{{ ($mode ?? 'create') === 'edit' ? 'Edit Employee' : 'Add Employee' }}</span>
            </h2>

            <form
                method="POST"
                action="{{ ($mode ?? 'create') === 'edit' && isset($employee->id) ? route('pim.employee-list.update', $employee->id) : route('pim.employee-list.store') }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="flex gap-6">
                <!-- Left: Employee Photo -->
                <div class="flex-shrink-0">
                    <div
                        class="relative w-32 h-32 rounded-full flex items-center justify-center overflow-visible employee-photo-wrapper"
                        style="background: var(--bg-hover); border: 2px solid var(--border-default); cursor: pointer;"
                        data-initial-photo="{{ $photoUrl ?? '' }}"
                    >
                        @if(!empty($photoUrl))
                            <img src="{{ $photoUrl }}?t={{ time() }}" alt="Employee Photo"
                                 class="absolute inset-0 w-full h-full object-contain rounded-full employee-photo-preview"
                                 style="background-color: var(--bg-surface);"
                                 onerror="this.onerror=null; this.style.display='none'; const icon = this.parentElement.querySelector('.employee-photo-icon'); if(icon) icon.style.display='block';">
                        @endif
                        <i class="fas fa-user text-4xl employee-photo-icon" style="color: var(--text-muted); {{ !empty($photoUrl) ? 'display: none;' : '' }}"></i>

                        <input type="file" name="photo" id="employee-photo-input" accept=".jpg,.jpeg,.png,.gif,.webp" class="hidden">
                        <button type="button" class="absolute bottom-0 right-0 w-8 h-8 rounded-full flex items-center justify-center text-white transition-all duration-200 hover:scale-105" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 16px rgba(228, 87, 69, 0.08); overflow: visible;" onclick="document.getElementById('employee-photo-input')?.click()">
                            <i class="fas fa-camera text-xs"></i>
                        </button>
                    </div>
                    <p class="text-xs mt-2 max-w-32" style="color: var(--text-muted);">Accepts jpg, .png, .gif up to 1MB. Recommended dimensions: 200px X 200px</p>
                </div>

                <!-- Right: Form Fields -->
                <div class="flex-1">
                    <!-- Employee Full Name -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-slate-700 mb-1">
                            Employee Full Name <span class="text-red-500">*</span>
                            <span class="text-[11px] text-gray-500 ml-1">(First name and Last name are compulsory)</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <input
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name', $employee->first_name ?? '') }}"
                                    required
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    placeholder="First Name"
                                >
                            </div>
                            <div>
                                <input
                                    type="text"
                                    name="middle_name"
                                    value="{{ old('middle_name') }}"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    placeholder="Middle Name"
                                >
                            </div>
                            <div>
                                <input
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name', $employee->last_name ?? '') }}"
                                    required
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                                    placeholder="Last Name"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Employee ID -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="employee_number"
                            value="{{ old('employee_number', $employee->employee_number ?? ($suggestedEmployeeNumber ?? '')) }}"
                            required
                            class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                            placeholder="Auto-generated or enter manually"
                        >
                    </div>

                    <!-- Job Title & Employment Status -->
                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                            <select
                                name="job_title_id"
                                class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                            >
                                <option value="">-- Select --</option>
                                @foreach($jobTitles ?? [] as $title)
                                    <option
                                        value="{{ $title->id }}"
                                        @selected(old('job_title_id', $employee->job_title_id ?? null) == $title->id)
                                    >
                                        {{ $title->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employment Status</label>
                            <select
                                name="employment_status_id"
                                class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white"
                            >
                                <option value="">-- Select --</option>
                                @foreach($employmentStatuses ?? [] as $status)
                                    <option
                                        value="{{ $status->id }}"
                                        @selected(old('employment_status_id', $employee->employment_status_id ?? null) == $status->id)
                                    >
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Create Login Details Hidden-->
                    {{-- <div class="mb-4 flex items-center gap-3">
                        <x-admin.toggle-switch id="create-login-toggle" :checked="false" />
                        <label for="create-login-toggle" class="text-xs font-medium cursor-pointer" style="color: var(--text-primary);">Create Login Details</label>
                    </div> --}}

                    <!-- Required Note -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500"><span class="text-red-500">*</span> Required</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('pim.employee-list') }}" class="hr-btn-secondary px-4 py-2 text-xs font-medium inline-flex items-center justify-center">
                            Cancel
                        </a>
                        <button type="submit" class="hr-btn-primary px-4 py-2 text-xs font-medium">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </section>
    </x-main-layout>

    <!-- Photo Preview Modal -->
    <div id="employee-photo-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('employee-photo-modal').classList.add('hidden')"></div>
        <div class="relative w-full max-w-md mx-4 rounded-2xl border shadow-xl"
             style="background-color: var(--bg-card); border-color: var(--border-strong);">
            <div class="px-5 py-3 border-b flex items-center justify-between"
                 style="border-color: var(--border-default);">
                <h3 class="text-xs font-bold" style="color: var(--text-primary);">
                    Profile Photo
                </h3>
                <button type="button"
                        class="hr-btn-secondary px-3 py-1 text-[11px]"
                        onclick="document.getElementById('employee-photo-modal').classList.add('hidden')">
                    Close
                </button>
            </div>
            <div class="px-6 py-6 flex items-center justify-center">
                <img
                    id="employee-photo-modal-img"
                    src=""
                    alt="Profile Photo Preview"
                    class="rounded-full"
                    style="
                        width: 220px;
                        height: 220px;
                        object-fit: contain;
                        background-color: var(--bg-surface);
                        border: 2px solid var(--border-default);
                    "
                >
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('employee-photo-input');
            var wrapper = document.querySelector('.employee-photo-wrapper');
            var modal = document.getElementById('employee-photo-modal');
            var modalImg = document.getElementById('employee-photo-modal-img');

            if (!wrapper || !modal || !modalImg) return;

            // If page loaded with an existing photo (edit mode), wire it to modal
            var initialPhoto = wrapper.getAttribute('data-initial-photo');
            if (initialPhoto) {
                modalImg.src = initialPhoto;
            }

            // Click on circle → open modal if any image is available
            wrapper.addEventListener('click', function () {
                var previewImg = wrapper.querySelector('.employee-photo-preview');
                var src = (previewImg && previewImg.src) || initialPhoto;
                if (!src) return;
                modalImg.src = src;
                modal.classList.remove('hidden');
            });

            // File input change → update circle preview + modal source
            if (input) {
                input.addEventListener('change', function (e) {
                    var file = e.target.files && e.target.files[0];
                    if (!file) return;

                    var previewImg = wrapper.querySelector('.employee-photo-preview');
                    var icon = wrapper.querySelector('.employee-photo-icon');

                    if (!previewImg) {
                        previewImg = document.createElement('img');
                        previewImg.className = 'absolute inset-0 w-full h-full object-contain rounded-full employee-photo-preview';
                        previewImg.style.backgroundColor = 'var(--bg-surface)';
                        wrapper.insertBefore(previewImg, wrapper.firstChild);
                    }

                    var objectUrl = URL.createObjectURL(file);
                    previewImg.src = objectUrl;
                    previewImg.style.display = 'block';
                    previewImg.onerror = null; // Clear any previous error handlers

                    if (icon) {
                        icon.style.display = 'none';
                    }
                    
                    // Ensure image loads properly
                    previewImg.onload = function() {
                        this.style.display = 'block';
                        if (icon) icon.style.display = 'none';
                    };

                    // Also update modal image so popup shows latest selection
                    modalImg.src = objectUrl;
                });
            }
        });
    </script>

@endsection

