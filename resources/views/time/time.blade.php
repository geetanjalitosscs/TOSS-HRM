@extends('layouts.app')

@section('title', 'Time')

@section('body')
    <x-main-layout title="Time">
        <div class="space-y-6">
            <!-- Intro -->
            <section class="hr-card p-4">
                <h2 class="text-sm font-bold mb-1" style="color: var(--text-primary);">
                    Time & Attendance
                </h2>
                <p class="text-xs" style="color: var(--text-muted);">
                    Manage your worksheets, attendance records, time reports, and project information from a single place.
                </p>
            </section>

            <!-- Quick Navigation Cards -->
            <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                <!-- My Worksheets -->
                <a href="{{ route('time.my-timesheets') }}" class="hr-card p-4 flex flex-col justify-between hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-semibold mb-1" style="color: var(--text-primary);">My Worksheets</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">
                                View and submit your daily work summaries.
                            </p>
                        </div>
                        <div class="h-9 w-9 rounded-lg flex items-center justify-center bg-[var(--color-primary-soft)]">
                            <i class="fas fa-clock text-sm" style="color: var(--color-primary-dark);"></i>
                        </div>
                    </div>
                    <span class="inline-flex items-center text-[11px] font-medium" style="color: var(--color-primary);">
                        Go to My Worksheets
                        <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                    </span>
                </a>

                <!-- Attendance -->
                <a href="{{ route('time.attendance.my-records') }}" class="hr-card p-4 flex flex-col justify-between hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-semibold mb-1" style="color: var(--text-primary);">Attendance</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">
                                Punch in/out and review attendance records.
                            </p>
                        </div>
                        <div class="h-9 w-9 rounded-lg flex items-center justify-center bg-[var(--color-primary-soft)]">
                            <i class="fas fa-user-check text-sm" style="color: var(--color-primary-dark);"></i>
                        </div>
                    </div>
                    <span class="inline-flex items-center text-[11px] font-medium" style="color: var(--color-primary);">
                        Go to Attendance
                        <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                    </span>
                </a>

                <!-- Reports -->
                <a href="{{ route('time.reports.project-reports') }}" class="hr-card p-4 flex flex-col justify-between hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-semibold mb-1" style="color: var(--text-primary);">Reports</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">
                                Project, employee, and attendance summary reports.
                            </p>
                        </div>
                        <div class="h-9 w-9 rounded-lg flex items-center justify-center bg-[var(--color-primary-soft)]">
                            <i class="fas fa-chart-line text-sm" style="color: var(--color-primary-dark);"></i>
                        </div>
                    </div>
                    <span class="inline-flex items-center text-[11px] font-medium" style="color: var(--color-primary);">
                        Go to Reports
                        <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                    </span>
                </a>

                <!-- Project Info -->
                <a href="{{ route('time.project-info.projects') }}" class="hr-card p-4 flex flex-col justify-between hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-semibold mb-1" style="color: var(--text-primary);">Project Info</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">
                                Manage time projects and customers used in timesheets.
                            </p>
                        </div>
                        <div class="h-9 w-9 rounded-lg flex items-center justify-center bg-[var(--color-primary-soft)]">
                            <i class="fas fa-project-diagram text-sm" style="color: var(--color-primary-dark);"></i>
                        </div>
                    </div>
                    <span class="inline-flex items-center text-[11px] font-medium" style="color: var(--color-primary);">
                        Go to Project Info
                        <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                    </span>
                </a>
            </section>
        </div>
    </x-main-layout>
@endsection


