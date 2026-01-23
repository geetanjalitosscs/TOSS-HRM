@extends('layouts.app')

@section('title', 'Time - Attendance - Configuration')

@section('body')
    <x-main-layout title="Time / Attendance / Configuration">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-x-auto overflow-y-visible">
                <x-dropdown-menu 
                    :items="[
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
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50 cursor-pointer transition-all flex items-center">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Timesheets</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
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
                    ]"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all flex items-center">
                        <span class="text-sm font-medium text-slate-700">Attendance</span>
                        <span class="text-purple-400 ml-1">▼</span>
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Reports</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
                <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Project Info</span>
                    <span class="text-purple-400 ml-1">▼</span>
                </div>
            </div>
        </div>

        <!-- Placeholder content for Attendance Configuration -->
        <section class="hr-card mt-4 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-2">Attendance Configuration</h2>
            <p class="text-sm text-slate-600">
                This is a placeholder for the Attendance Configuration page. We will build the full functionality here later.
            </p>
        </section>
    </x-main-layout>
@endsection

