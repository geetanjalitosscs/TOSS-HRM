@extends('layouts.app')

@section('title', 'My Info - Job')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                @php $attachments = $attachments ?? []; @endphp

                <!-- Job Details Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Job Details</h2>

                    <div class="job-details-grid space-y-3">
                        <!-- Row 1: Joined Date, Job Title, Job Specification -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Joined Date</label>
                                <div class="job-date-wrap relative">
                                    <input type="date" class="hr-input job-input pr-9" value="{{ optional($employee)->join_date ?? '1990-11-10' }}">
                                    <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400"><i class="fas fa-calendar-days text-sm"></i></span>
                                </div>
                            </div>
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                <input type="text" class="hr-input job-input" value="{{ optional($employee)->job_title ?? 'HR Manager' }}" placeholder="Job Title">
                            </div>
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Job Specification</label>
                                <input type="text" class="hr-input job-input" value="{{ optional($employee)->job_specification ?? 'Not Defined' }}" placeholder="Job Specification" readonly>
                            </div>
                        </div>

                        <!-- Row 2: Job Category, Sub Unit, Location -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Job Category</label>
                                <input type="text" class="hr-input job-input" value="{{ optional($employee)->job_category ?? 'Officials and Managers' }}" readonly>
                            </div>
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Sub Unit</label>
                                <input type="text" class="hr-input job-input" value="{{ optional($employee)->sub_unit ?? 'Human Resources' }}" readonly>
                            </div>
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Location</label>
                                <input type="text" class="hr-input job-input" value="{{ optional($employee)->location ?? 'Texas R&D' }}" readonly>
                            </div>
                        </div>

                        <!-- Row 3: Employment Status (single column, same width as one field above) -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="job-field">
                                <label class="block text-xs font-medium text-slate-700 mb-1">Employment Status</label>
                                <input type="text" class="hr-input job-input" value="{{ optional($employee)->employment_status ?? 'Full-Time Permanent' }}" readonly>
                            </div>
                        </div>

                        <!-- Toggle: Include Employment Contract Details -->
                        <div class="flex items-center gap-2 pt-1">
                            <label class="text-xs font-medium text-slate-700">Include Employment Contract Details</label>
                            <button type="button" role="switch" aria-checked="false" class="job-toggle relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:ring-offset-2">
                                <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition translate-x-0.5" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Attachments</h2>

                    @if(count($attachments) == 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <x-records-found :count="count($attachments)" />
                    @endif

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
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Added By</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Body (empty when no records) -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                            @if(count($attachments) == 0)
                                <div class="text-xs text-slate-500 text-center py-4"></div>
                            @else
                                @foreach($attachments as $attachment)
                                    <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                        <div class="flex items-center gap-1">
                                            <div class="flex-1" style="min-width: 0;"><span class="text-xs text-slate-700 break-words">{{ $attachment->file_name ?? '' }}</span></div>
                                            <div class="flex-1" style="min-width: 0;"><span class="text-xs text-slate-700 break-words">{{ $attachment->description ?? '-' }}</span></div>
                                            <div class="flex-1" style="min-width: 0;"><span class="text-xs text-slate-700 break-words">{{ $attachment->size ?? '' }}</span></div>
                                            <div class="flex-1" style="min-width: 0;"><span class="text-xs text-slate-700 break-words">{{ $attachment->type ?? '' }}</span></div>
                                            <div class="flex-1" style="min-width: 0;"><span class="text-xs text-slate-700 break-words">{{ $attachment->date_added ?? '' }}</span></div>
                                            <div class="flex-1" style="min-width: 0;"><span class="text-xs text-slate-700 break-words">{{ $attachment->added_by ?? '' }}</span></div>
                                            <div class="flex-shrink-0" style="width: 90px;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>

    <style>
        .job-details-grid .job-field {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .job-details-grid .job-input {
            height: 2.5rem;
            min-height: 2.5rem;
            box-sizing: border-box;
        }
        .job-details-grid .job-date-wrap {
            height: 2.5rem;
            min-height: 2.5rem;
        }
        .job-details-grid .job-date-wrap .job-input {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
@endsection
