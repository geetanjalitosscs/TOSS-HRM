@extends('layouts.app')

@section('title', 'My Info - Personal Details')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Personal Details Form -->
                <form id="personal-details-section" method="POST" action="{{ route('myinfo.personal.update') }}" class="rounded-lg shadow-sm border border-[var(--border-default)] p-4 mb-3" style="background-color: var(--bg-card);">
                    @csrf
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Personal Details</h2>

                    <div class="space-y-3">
                        <!-- Employee Full Name -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Full Name</label>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" name="first_name" class="hr-input" value="{{ $employee ? $employee->first_name : '' }}" placeholder="First Name">
                                <input type="text" name="middle_name" class="hr-input" value="{{ $employee ? ($employee->middle_name ?? '') : '' }}" placeholder="Middle Name">
                                <input type="text" name="last_name" class="hr-input" value="{{ $employee ? $employee->last_name : '' }}" placeholder="Last Name">
                            </div>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Username</label>
                            <input type="text" name="username" class="hr-input" value="{{ $user ? $user->username : '' }}" placeholder="Username">
                        </div>

                        <!-- Employee Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                            <input type="text" name="employee_number" class="hr-input" value="{{ $employee ? $employee->employee_number : '' }}">
                        </div>

                        <!-- Other Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Other Id</label>
                            <input type="text" name="other_id" class="hr-input" value="{{ $personalDetails->other_id ?? '' }}">
                        </div>

                        <!-- Driver's License Number -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Driver's License Number</label>
                            <input type="text" name="drivers_license" class="hr-input" value="{{ $personalDetails->drivers_license ?? '' }}">
                        </div>

                        <!-- License Expiry Date -->
                        <div>
                            <x-date-picker 
                                id="license-expiry-date"
                                name="license_expiry"
                                value="{{ $personalDetails->license_expiry ?? '' }}"
                                label="License Expiry Date"
                            />
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Nationality</label>
                            <select name="nationality_id" class="hr-select">
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
                            <select name="marital_status" class="hr-select">
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
                                name="date_of_birth"
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
                            <button type="submit" class="hr-btn-primary px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Custom Fields Section -->
                <form id="custom-fields-section" method="POST" action="{{ route('myinfo.custom.update') }}" class="rounded-lg shadow-sm border border-[var(--border-default)] p-4 mb-3" style="background-color: var(--bg-card);">
                    @csrf
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Custom Fields</h2>

                    <div class="space-y-3">
                        <!-- Blood Type -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Blood Type</label>
                            <select name="blood_group" class="hr-select">
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
                            <button type="submit" class="hr-btn-primary bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>

            </div>
    </x-main-layout>

@endsection
