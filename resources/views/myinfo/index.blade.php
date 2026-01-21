@extends('layouts.app')

@section('title', 'My Info - Personal Details')

@section('body')
    <x-main-layout title="PIM">
        <div class="flex gap-6">
            <!-- Left Sidebar - Sub Navigation -->
            <aside class="w-64 flex-shrink-0">
                <!-- User Profile Section -->
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-3">
                    <h2 class="text-sm font-bold text-slate-800 mb-2">manda user</h2>
                    <div class="flex justify-center mb-3">
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            M
                        </div>
                    </div>
                </div>

                <!-- Sub Navigation Tabs -->
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 overflow-hidden">
                    <a href="#" class="block px-4 py-3 bg-purple-50 border-l-4 border-[var(--color-hr-primary)] text-sm font-semibold text-[var(--color-hr-primary-dark)]">
                        Personal Details
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Contact Details
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Emergency Contacts
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Dependents
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Immigration
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Job
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Salary
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Report-to
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Qualifications
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-purple-50/30 text-sm font-medium text-slate-700 transition-colors">
                        Memberships
                    </a>
                </div>
            </aside>

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Personal Details Form -->
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-3">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Personal Details</h2>

                    <div class="space-y-3">
                        <!-- Employee Full Name -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Full Name*</label>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" class="hr-input" value="manda" placeholder="First Name">
                                <input type="text" class="hr-input" value="akhil" placeholder="Middle Name">
                                <input type="text" class="hr-input" value="user" placeholder="Last Name">
                            </div>
                        </div>

                        <!-- Employee Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                            <input type="text" class="hr-input" value="muser">
                        </div>

                        <!-- Other Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Other Id</label>
                            <input type="text" class="hr-input" value="4957589">
                        </div>

                        <!-- Driver's License Number -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Driver's License Number</label>
                            <input type="text" class="hr-input" value="56788">
                        </div>

                        <!-- License Expiry Date -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">License Expiry Date</label>
                            <div class="relative">
                                <input type="date" id="license-expiry-date" class="hr-input pr-12 w-full" value="2023-10-18">
                                <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-purple-500 text-sm cursor-pointer hover:text-purple-700 transition-colors z-10" onclick="document.getElementById('license-expiry-date').showPicker()">📅</span>
                            </div>
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Nationality</label>
                            <select class="hr-select">
                                <option>American</option>
                                <option>Indian</option>
                                <option>British</option>
                                <option>Canadian</option>
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Marital Status</label>
                            <select class="hr-select">
                                <option>Single</option>
                                <option>Married</option>
                                <option>Divorced</option>
                                <option>Widowed</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Date of Birth</label>
                            <div class="relative">
                                <input type="date" id="date-of-birth" class="hr-input pr-12 w-full" value="2023-10-21">
                                <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-purple-500 text-sm cursor-pointer hover:text-purple-700 transition-colors z-10" onclick="document.getElementById('date-of-birth').showPicker()">📅</span>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Gender</label>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="male" checked class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Male</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="female" class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Female</span>
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
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-3">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Custom Fields</h2>

                    <div class="space-y-3">
                        <!-- Blood Type -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Blood Type</label>
                            <select class="hr-select">
                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>
                            </select>
                        </div>

                        <!-- Test_Field -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Test_Field</label>
                            <input type="text" class="hr-input" value="445">
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

                    <p class="text-xs text-slate-600 mb-3">({{ count($attachments) }}) Records Found</p>

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
                            <div class="flex-shrink-0" style="width: 70px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg overflow-hidden">
                        @foreach($attachments as $attachment)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 hover:bg-purple-50/30 transition-colors">
                                <div class="flex items-center gap-1">
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment['file_name'] }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment['description'] ?: '-' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment['size'] }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment['type'] }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment['date_added'] }}</div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 70px;">
                                        <div class="flex items-center justify-center gap-1">
                                            <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button class="p-0.5 rounded text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all flex-shrink-0" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            <button class="p-0.5 rounded text-gray-600 hover:text-purple-600 hover:bg-purple-50 transition-all flex-shrink-0" title="Download">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
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

