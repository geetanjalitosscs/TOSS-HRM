@extends('layouts.app')

@section('title', 'Time - Edit Timesheet')

@section('body')
    <x-main-layout title="Time">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b overflow-x-auto overflow-y-visible" style="border-color: var(--border-default);">
                @php
                    $projectInfoHasActive = request()->routeIs('time.project-info.customers') || request()->routeIs('time.project-info.projects');
                @endphp
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
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Timesheets</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
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
                            'active' => request()->routeIs('time.attendance.configuration'),
                            'hidden' => true
                        ],
                    ]"
                    position="left"
                    width="w-56">
                    <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center">
                        <span class="text-sm font-medium" style="color: var(--text-primary);">Attendance</span>
                        <x-dropdown-arrow color="var(--color-hr-primary)" class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
            </div>
        </div>

        <!-- Edit Timesheet Card -->
        <section class="hr-card p-6 border-t-0 rounded-t-none">
            <!-- Header Row -->
            <div class="flex items-center justify-between gap-6 mb-6">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-edit" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Edit Timesheet</span>
                </h2>
            </div>

            <!-- Add New Work Entry Form -->
            <div class="mb-6 p-4 rounded-lg border" style="background-color: var(--bg-card); border-color: var(--border-default);">
                <h3 class="text-xs font-semibold mb-4" style="color: var(--text-primary);">Add Work Entry</h3>
                <form id="add-entry-form" method="POST" action="{{ route('time.timesheets.entries.store') }}">
                    @csrf
                    <input type="hidden" name="timesheet_id" value="{{ $timesheet->id }}">
                    <input type="hidden" name="hours" value="0">
                    <input type="hidden" name="project_id" value="">
                    <input type="hidden" name="activity_name" value="">
                    <input type="hidden" name="work_date" value="{{ date('Y-m-d') }}">
                    
                    <div class="space-y-4">
                        <!-- Date (Read-only, Today's Date) -->
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                Date <span class="text-red-500">*</span>
                            </label>
                                <input 
                                    type="text" 
                                value="{{ \Carbon\Carbon::now()->format('d M Y') }}"
                                class="hr-input w-full"
                                readonly
                                style="background-color: var(--bg-hover); cursor: not-allowed;"
                                >
                            </div>

                        <!-- Work Description -->
                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                Work Description <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="notes" 
                                rows="4"
                                class="hr-input w-full"
                                placeholder="Describe what work you did..."
                                required
                            >{{ old('notes', $todayEntry->notes ?? 'Today\'s work') }}</textarea>
                        </div>
            </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('time.my-timesheets') }}" class="hr-btn-secondary inline-flex items-center justify-center">
                    Cancel
                </a>
                        <button type="submit" class="hr-btn-primary">
                    Save
                </button>
                    </div>
                </form>
            </div>
        </section>
    </x-main-layout>
@endsection
