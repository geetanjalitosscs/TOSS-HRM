@extends('layouts.app')

@section('title', 'Time - Project Info - Customers')

@section('body')
    <x-main-layout title="Time / Project Info / Customers">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible">
                @php
                    $timesheetsItems = [
                        [
                            'url' => route('time.my-timesheets'),
                            'label' => 'My Timesheets',
                            'active' => request()->routeIs('time.my-timesheets') || request()->routeIs('time.my-timesheets.edit')
                        ],
                        [
                            'url' => route('time'),
                            'label' => 'Employee Timesheets',
                            'active' => request()->routeIs('time')
                        ]
                    ];
                    $timesheetsHasActive = collect($timesheetsItems)->contains('active', true);
                    
                    $attendanceItems = [
                        [
                            'url' => route('time.attendance.my-records'),
                            'label' => 'My Records',
                            'active' => request()->routeIs('time.attendance.my-records')
                        ],
                        [
                            'url' => route('time.attendance.punch-in-out'),
                            'label' => 'Punch In/Out',
                            'active' => request()->routeIs('time.attendance.punch-in-out')
                        ],
                        [
                            'url' => route('time.attendance.employee-records'),
                            'label' => 'Employee Records',
                            'active' => request()->routeIs('time.attendance.employee-records')
                        ],
                        [
                            'url' => route('time.attendance.configuration'),
                            'label' => 'Configuration',
                            'active' => request()->routeIs('time.attendance.configuration')
                        ],
                    ];
                    $attendanceHasActive = collect($attendanceItems)->contains('active', true);
                    
                    $reportsItems = [
                        [
                            'url' => route('time.reports.project-reports'),
                            'label' => 'Project Reports',
                            'active' => request()->routeIs('time.reports.project-reports')
                        ],
                        [
                            'url' => route('time.reports.employee-reports'),
                            'label' => 'Employee Reports',
                            'active' => request()->routeIs('time.reports.employee-reports')
                        ],
                        [
                            'url' => route('time.reports.attendance-summary'),
                            'label' => 'Attendance Summary',
                            'active' => request()->routeIs('time.reports.attendance-summary')
                        ],
                    ];
                    $reportsHasActive = collect($reportsItems)->contains('active', true);
                    
                    $projectInfoItems = [
                        [
                            'url' => route('time.project-info.customers'),
                            'label' => 'Customers',
                            'active' => request()->routeIs('time.project-info.customers')
                        ],
                        [
                            'url' => route('time.project-info.projects'),
                            'label' => 'Projects',
                            'active' => request()->routeIs('time.project-info.projects')
                        ],
                    ];
                    $projectInfoHasActive = collect($projectInfoItems)->contains('active', true);
                @endphp
                <x-dropdown-menu 
                    :items="$timesheetsItems"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $timesheetsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $timesheetsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Timesheets</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$attendanceItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $attendanceHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $attendanceHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$reportsItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $reportsHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $reportsHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Reports</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="$projectInfoItems"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 cursor-pointer transition-all flex items-center tab-trigger {{ $projectInfoHasActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50' : 'hover:bg-purple-50/30' }}">
                        <span class="text-sm {{ $projectInfoHasActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }}">Project Info</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Customers List Section -->
        <div class="mt-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Header with Title and Add Button -->
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-800">Customers</h2>
                        <button 
                            type="button" 
                            class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors hover:opacity-90 flex items-center gap-1"
                            style="background-color: var(--color-hr-primary);"
                        >
                            <span>+</span>
                            <span>Add</span>
                        </button>
                    </div>
                    <h2 class="text-sm font-medium text-slate-700">(8) Records Found</h2>
                </div>

                <!-- Table -->
                <div class="px-6 pb-6">
                    <table class="w-full">
                        <!-- Table Header -->
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-2.5 text-left">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">
                                    <div class="flex items-center gap-1">
                                        <span>Name</span>
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-[10px] text-gray-400 leading-none">▲</span>
                                            <span class="text-[10px] text-gray-400 leading-none">▼</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Description</th>
                                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">ACME Ltd</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Leading apparel manufacturing chain.</td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Apache Software Foundation</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">non-profit corporation to support Apache software projects</td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">FreeWave Technologies, Inc.</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Its wireless data radios are utilized in industrial, government and defense, scientific, and commercial applications</td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Fresh Books Software Ltd</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Global Corp and Co</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Global Corp introduces itself as a leading manufacturer and exporter of a large number of products catering to high precision equipment, Scientific Laboratory Equipments & Institutional Health Care Products.</td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Additional rows to reach 8 total -->
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Customer 5</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Customer 6</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Customer 7</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2.5">
                                    <input type="checkbox" class="rounded w-4 h-4 border-gray-300" style="accent-color: var(--color-hr-primary);">
                                </td>
                                <td class="px-4 py-2.5 text-sm text-slate-700">Customer 8</td>
                                <td class="px-4 py-2.5 text-sm text-slate-700"></td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle tab hover and open states
                const tabTriggers = document.querySelectorAll('.tab-trigger');
                
                tabTriggers.forEach(trigger => {
                    const group = trigger.closest('.group');
                    const dropdown = group?.querySelector('.hr-dropdown-menu');
                    const isActive = trigger.classList.contains('border-b-2');
                    
                    if (isActive) {
                        trigger.dataset.hasActive = 'true';
                    }
                    
                    // Hover effect - add border on hover
                    trigger.addEventListener('mouseenter', function() {
                        if (!this.dataset.hasActive) {
                            this.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                            this.classList.remove('hover:bg-purple-50/30');
                            const span = this.querySelector('span:first-of-type');
                            if (span) {
                                span.classList.remove('font-medium', 'text-slate-700');
                                span.classList.add('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                            }
                        }
                    });
                    
                    // Remove border on mouse leave only if not active and not open
                    trigger.addEventListener('mouseleave', function() {
                        if (!this.dataset.hasActive) {
                            const isOpen = dropdown?.classList.contains('show');
                            if (!isOpen) {
                                this.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                this.classList.add('hover:bg-purple-50/30');
                                const span = this.querySelector('span:first-of-type');
                                if (span) {
                                    span.classList.remove('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                    span.classList.add('font-medium', 'text-slate-700');
                                }
                            }
                        }
                    });
                });
                
                // Keep border when dropdown is open
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            const dropdown = mutation.target;
                            if (dropdown.classList.contains('hr-dropdown-menu')) {
                                const trigger = dropdown.closest('.group')?.querySelector('.tab-trigger');
                                if (trigger) {
                                    if (dropdown.classList.contains('show')) {
                                        // Dropdown opened - add border
                                        trigger.classList.add('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.remove('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                            span.classList.remove('font-medium', 'text-slate-700');
                                            span.classList.add('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                        }
                                    } else if (!trigger.dataset.hasActive) {
                                        // Dropdown closed - remove border only if not active
                                        trigger.classList.remove('border-b-2', 'border-[var(--color-hr-primary)]', 'bg-purple-50/50');
                                        trigger.classList.add('hover:bg-purple-50/30');
                                        const span = trigger.querySelector('span:first-of-type');
                                        if (span) {
                                            span.classList.remove('font-semibold', 'text-[var(--color-hr-primary-dark)]');
                                            span.classList.add('font-medium', 'text-slate-700');
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
                
                document.querySelectorAll('.hr-dropdown-menu').forEach(menu => {
                    observer.observe(menu, { attributes: true, attributeFilter: ['class'] });
                });
            });
        </script>
    </x-main-layout>
@endsection
