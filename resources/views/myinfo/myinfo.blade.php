@extends('layouts.app')

@section('title', 'My Info - Personal Details')

@section('body')
    <x-main-layout title="PIM">
        <div class="flex items-stretch">
            <!-- Left Sidebar - Sub Navigation -->
            <aside class="w-64 flex-shrink-0 mr-6 flex flex-col">
                <!-- User Profile Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-2">
                        {{ $employee ? ($employee->display_name ?: trim($employee->first_name . ' ' . ($employee->middle_name ?? '') . ' ' . $employee->last_name)) : 'Employee' }}
                    </h2>
                    <div class="flex justify-center mb-3">
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ $employee ? strtoupper(substr($employee->first_name, 0, 1)) : 'E' }}
                        </div>
                    </div>
                </div>

                <!-- Sub Navigation Tabs -->
                <div class="rounded-lg shadow-sm border border-purple-100 overflow-hidden flex-1" style="background-color: var(--bg-card);">
                    <a href="#" class="block px-4 py-3 border-l-4 border-[var(--color-hr-primary)] text-sm font-semibold transition-colors" style="background-color: var(--bg-hover); color: var(--color-hr-primary-dark);">
                        Personal Details
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Contact Details
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Emergency Contacts
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Dependents
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Immigration
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Job
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Salary
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Report-to
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Qualifications
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium transition-colors" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        Memberships
                    </a>
                </div>
            </aside>

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Personal Details Form -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Personal Details</h2>

                    <div class="space-y-3">
                        <!-- Employee Full Name -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Full Name*</label>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" class="hr-input" value="{{ $employee ? $employee->first_name : '' }}" placeholder="First Name">
                                <input type="text" class="hr-input" value="{{ $employee ? ($employee->middle_name ?? '') : '' }}" placeholder="Middle Name">
                                <input type="text" class="hr-input" value="{{ $employee ? $employee->last_name : '' }}" placeholder="Last Name">
                            </div>
                        </div>

                        <!-- Employee Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                            <input type="text" class="hr-input" value="{{ $employee ? $employee->employee_number : '' }}">
                        </div>

                        <!-- Other Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Other Id</label>
                            <input type="text" class="hr-input" value="{{ $personalDetails->other_id ?? '' }}">
                        </div>

                        <!-- Driver's License Number -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Driver's License Number</label>
                            <input type="text" class="hr-input" value="{{ $personalDetails->drivers_license ?? '' }}">
                        </div>

                        <!-- License Expiry Date -->
                        <div>
                            <x-date-picker 
                                id="license-expiry-date"
                                value="{{ $personalDetails->license_expiry ?? '' }}"
                                label="License Expiry Date"
                            />
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Nationality</label>
                            <select class="hr-select">
                                <option value="">Select Nationality</option>
                                @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality->id }}" {{ $personalDetails && $personalDetails->nationality_id == $nationality->id ? 'selected' : '' }}>
                                        {{ $nationality->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Marital Status</label>
                            <select class="hr-select">
                                <option value="">Select Status</option>
                                <option value="single" {{ $employee && $employee->marital_status == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ $employee && $employee->marital_status == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ $employee && $employee->marital_status == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ $employee && $employee->marital_status == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <x-date-picker 
                                id="date-of-birth"
                                value="{{ $employee->date_of_birth ?? '' }}"
                                label="Date of Birth"
                            />
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Gender</label>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="male" {{ $employee && $employee->gender == 'male' ? 'checked' : '' }} class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Male</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="female" {{ $employee && $employee->gender == 'female' ? 'checked' : '' }} class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Female</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="other" {{ $employee && $employee->gender == 'other' ? 'checked' : '' }} class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Other</span>
                                </label>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end pt-3">
                            <button class="hr-btn-primary px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Custom Fields Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Custom Fields</h2>

                    <div class="space-y-3">
                        <!-- Blood Type -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Blood Type</label>
                            <select class="hr-select">
                                <option value="">Select Blood Type</option>
                                <option value="A+" {{ $personalDetails && $personalDetails->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $personalDetails && $personalDetails->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $personalDetails && $personalDetails->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $personalDetails && $personalDetails->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ $personalDetails && $personalDetails->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $personalDetails && $personalDetails->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ $personalDetails && $personalDetails->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $personalDetails && $personalDetails->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end pt-4">
                            <button class="hr-btn-primary bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Attachments</h2>
                        <button class="hr-btn-primary px-3 py-1.5 text-xs">
                            + Add
                        </button>
                    </div>

                    <x-records-found :count="count($attachments)" />

                    <!-- Table Header -->
                    <div class="bg-purple-50/50 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">File Name</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Description</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Size</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Type</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Date Added</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @foreach($attachments as $attachment)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1">
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->file_name }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->description ?: '-' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->size }}</div>
                                    </div>
                                    <div class="text-xs text-slate-700 break-words" style="flex: 1; min-width: 0;">
                                        {{ $attachment->type }}
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->date_added }}</div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                        <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                            <button class="hr-action-edit flex-shrink-0" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <button class="hr-action-delete flex-shrink-0" title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                            <button class="hr-action-download flex-shrink-0" title="Download">
                                                <i class="fas fa-download text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </x-main-layout>
@endsection

