@extends('layouts.app')

@section('title', 'My Info - Qualifications')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Work Experience Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Work Experience</h2>
                        <button type="button" onclick="prepareWorkExpAdd()"
                            class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100"
                            style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Work Experience Form (Modal) -->
                    <div id="work-exp-modal" class="qual-modal" style="display: none;">
                        <div class="qual-modal-backdrop" onclick="closeWorkExpForm()"></div>
                        <div class="qual-modal-content">
                            <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Work Experience</h2>
                            <form id="work-exp-form" action="{{ route('myinfo.qualifications.work-experience.store') }}"
                                method="POST">
                                @csrf
                                <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Company<span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="company" required
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Job Title<span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="job_title" required
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                </div>
                                <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">From</label>
                                        <x-date-picker id="work-exp-from" name="from" value="" placeholder="yyyy-dd-mm"
                                            variant="split" wrapperClass="qual-form-date-wrap" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">To</label>
                                        <x-date-picker id="work-exp-to" name="to" value="" placeholder="yyyy-dd-mm"
                                            variant="split" wrapperClass="qual-form-date-wrap" />
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium mb-1.5"
                                        style="color: var(--text-primary);">Comment</label>
                                    <textarea name="comment" rows="3"
                                        class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y"
                                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                                </div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="text-xs" style="color: var(--text-muted);"><span
                                            class="text-red-500">*</span> Required</div>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeWorkExpForm()"
                                            class="px-4 py-2 text-sm font-medium border rounded-lg"
                                            style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                                            style="background-color: var(--color-hr-primary);">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @php
                        $workExperience = $workExperience ?? collect([]);
                        $workExpCount = $workExperience->count();
                    @endphp
                    @if($workExpCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $workExpCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header - equal width columns -->
                    <div
                        class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox"
                                    class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Company</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Job
                                    Title</span></div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">From</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">To</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Comment</span>
                            </div>
                            <div class="qual-actions-cell"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($workExperience as $exp)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row"
                                style="background-color: var(--bg-card); border-color: var(--border-default);"
                                onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox"
                                            class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $exp->company ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $exp->job_title ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $exp->from_date ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $exp->to_date ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $exp->comment ?? '' }}</div>
                                    </div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('myinfo.qualifications.work-experience.delete', $exp->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this work experience?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="myinfo-action-btn hr-action-delete flex-shrink-0"
                                                    title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            </form>
                                            <button type="button" onclick="editWorkExp({{ json_encode($exp) }})"
                                                class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i
                                                    class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row"
                                style="background-color: var(--bg-card);">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-actions-cell"></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Education Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Education</h2>
                        <button type="button" onclick="prepareEducationAdd()"
                            class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100"
                            style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Education Form (Modal) -->
                    <div id="education-modal" class="qual-modal" style="display: none;">
                        <div class="qual-modal-backdrop" onclick="closeEducationForm()"></div>
                        <div class="qual-modal-content">
                            <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Education</h2>
                            <form id="education-form" action="{{ route('myinfo.qualifications.education.store') }}"
                                method="POST">
                                @csrf
                                <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Level<span
                                                class="text-red-500">*</span></label>
                                        <select name="level" required
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                            <option value="">-- Select --</option>
                                            <option value="High School">High School</option>
                                            <option value="Associate Degree">Associate Degree</option>
                                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                                            <option value="Master's Degree">Master's Degree</option>
                                            <option value="Doctorate">Doctorate</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Institute</label>
                                        <input type="text" name="institute"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Major/Specialization</label>
                                        <input type="text" name="major_specialization"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                </div>
                                <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Year</label>
                                        <input type="text" name="year"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">GPA/Score</label>
                                        <input type="text" name="gpa_score"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div></div>
                                </div>
                                <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Start Date</label>
                                        <x-date-picker id="education-start-date" name="start_date" value=""
                                            placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">End Date</label>
                                        <x-date-picker id="education-end-date" name="end_date" value=""
                                            placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                    </div>
                                    <div></div>
                                </div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="text-xs" style="color: var(--text-muted);"><span
                                            class="text-red-500">*</span> Required</div>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeEducationForm()"
                                            class="px-4 py-2 text-sm font-medium border rounded-lg"
                                            style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                                            style="background-color: var(--color-hr-primary);">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @php
                        $education = $education ?? collect([]);
                        $educationCount = $education->count();
                    @endphp
                    @if($educationCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $educationCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header - equal width columns -->
                    <div
                        class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox"
                                    class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Level</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Year</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">GPA/Score</span>
                            </div>
                            <div class="qual-actions-cell"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($education as $edu)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row"
                                style="background-color: var(--bg-card); border-color: var(--border-default);"
                                onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox"
                                            class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $edu->level ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $edu->year ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $edu->gpa_score ?? '' }}</div>
                                    </div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('myinfo.qualifications.education.delete', $edu->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this education record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="myinfo-action-btn hr-action-delete flex-shrink-0"
                                                    title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            </form>
                                            <button type="button" onclick="editEducation({{ json_encode($edu) }})"
                                                class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i
                                                    class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row"
                                style="background-color: var(--bg-card);">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-actions-cell"></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Skills</h2>
                        <button type="button" onclick="prepareSkillAdd()"
                            class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100"
                            style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Skill Form (Modal) -->
                    <div id="skill-modal" class="qual-modal" style="display: none;">
                        <div class="qual-modal-backdrop" onclick="closeSkillForm()"></div>
                        <div class="qual-modal-content">
                            <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Skill</h2>
                            <form id="skill-form" action="{{ route('myinfo.qualifications.skills.store') }}" method="POST">
                                @csrf
                                <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Skill<span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="skill" required
                                            placeholder="Enter skill"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Years of Experience</label>
                                        <input type="text" name="years_of_experience"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium mb-1.5"
                                        style="color: var(--text-primary);">Comments</label>
                                    <textarea name="comments" rows="3"
                                        class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y"
                                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                                </div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="text-xs" style="color: var(--text-muted);"><span
                                            class="text-red-500">*</span> Required</div>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeSkillForm()"
                                            class="px-4 py-2 text-sm font-medium border rounded-lg"
                                            style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                                            style="background-color: var(--color-hr-primary);">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @php
                        $skills = $skills ?? collect([]);
                        $skillsCount = $skills->count();
                    @endphp
                    @if($skillsCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $skillsCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <div
                        class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox"
                                    class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Skill</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Years
                                    of Experience</span></div>
                            <div class="qual-actions-cell"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($skills as $skill)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row"
                                style="background-color: var(--bg-card); border-color: var(--border-default);"
                                onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox"
                                            class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $skill->skill ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $skill->years_of_experience ?? '' }}
                                        </div>
                                    </div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('myinfo.qualifications.skills.delete', $skill->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this skill?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="myinfo-action-btn hr-action-delete flex-shrink-0"
                                                    title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            </form>
                                            <button type="button" onclick="editSkill({{ json_encode($skill) }})"
                                                class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i
                                                    class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row"
                                style="background-color: var(--bg-card);">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-actions-cell"></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Languages Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Languages</h2>
                        <button type="button" onclick="prepareLanguageAdd()"
                            class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100"
                            style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Language Form (Modal) -->
                    <div id="language-modal" class="qual-modal" style="display: none;">
                        <div class="qual-modal-backdrop" onclick="closeLanguageForm()"></div>
                        <div class="qual-modal-content">
                            <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Language</h2>
                            <form id="language-form" action="{{ route('myinfo.qualifications.languages.store') }}"
                                method="POST">
                                @csrf
                                <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Language<span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="language" required
                                            placeholder="Enter language"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Fluency<span
                                                class="text-red-500">*</span></label>
                                        <select name="fluency" required
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                            <option value="">-- Select --</option>
                                            <option value="Speaking">Speaking</option>
                                            <option value="Reading">Reading</option>
                                            <option value="Writing">Writing</option>
                                            <option value="Listening">Listening</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Competency<span
                                                class="text-red-500">*</span></label>
                                        <select name="competency" required
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                            <option value="">-- Select --</option>
                                            <option value="Poor">Poor</option>
                                            <option value="Basic">Basic</option>
                                            <option value="Good">Good</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Mother Tongue">Mother Tongue</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium mb-1.5"
                                        style="color: var(--text-primary);">Comments</label>
                                    <textarea name="comments" rows="3"
                                        class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y"
                                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                                </div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="text-xs" style="color: var(--text-muted);"><span
                                            class="text-red-500">*</span> Required</div>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeLanguageForm()"
                                            class="px-4 py-2 text-sm font-medium border rounded-lg"
                                            style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                                            style="background-color: var(--color-hr-primary);">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @php
                        $languages = $languages ?? collect([]);
                        $languagesCount = $languages->count();
                    @endphp
                    @if($languagesCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $languagesCount }}) Record Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <div
                        class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox"
                                    class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Language</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Fluency</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Competency</span>
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Comments</span>
                            </div>
                            <div class="qual-actions-cell"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($languages as $lang)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row"
                                style="background-color: var(--bg-card); border-color: var(--border-default);"
                                onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox"
                                            class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $lang->language ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $lang->fluency ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $lang->competency ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $lang->comments ?? '' }}</div>
                                    </div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('myinfo.qualifications.languages.delete', $lang->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this language?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="myinfo-action-btn hr-action-delete flex-shrink-0"
                                                    title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            </form>
                                            <button type="button" onclick="editLanguage({{ json_encode($lang) }})"
                                                class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i
                                                    class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row"
                                style="background-color: var(--bg-card);">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-actions-cell"></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- License Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">License</h2>
                        <button type="button" onclick="prepareLicenseAdd()"
                            class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100"
                            style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add License Form (Modal) -->
                    <div id="license-modal" class="qual-modal" style="display: none;">
                        <div class="qual-modal-backdrop" onclick="closeLicenseForm()"></div>
                        <div class="qual-modal-content">
                            <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add License</h2>
                            <form id="license-form" action="{{ route('myinfo.qualifications.licenses.store') }}"
                                method="POST">
                                @csrf
                                <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">License Type<span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="license_type" required
                                            placeholder="Enter license type"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">License Number</label>
                                        <input type="text" name="license_number"
                                            class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg"
                                            style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                    </div>
                                </div>
                                <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Issued Date</label>
                                        <x-date-picker id="license-issued-date" name="issued_date" value=""
                                            placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1.5"
                                            style="color: var(--text-primary);">Expiry Date</label>
                                        <x-date-picker id="license-expiry-date" name="expiry_date" value=""
                                            placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                    </div>
                                </div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="text-xs" style="color: var(--text-muted);"><span
                                            class="text-red-500">*</span> Required</div>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeLicenseForm()"
                                            class="px-4 py-2 text-sm font-medium border rounded-lg"
                                            style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                                            style="background-color: var(--color-hr-primary);">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @php
                        $licenses = $licenses ?? collect([]);
                        $licensesCount = $licenses->count();
                    @endphp
                    @if($licensesCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $licensesCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <div
                        class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox"
                                    class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">License
                                    Type</span></div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">License
                                    Number</span></div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Issued
                                    Date</span></div>
                            <div class="qual-equal-col"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Expiry
                                    Date</span></div>
                            <div class="qual-actions-cell"><span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($licenses as $license)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row"
                                style="background-color: var(--bg-card); border-color: var(--border-default);"
                                onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox"
                                            class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $license->license_type ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $license->license_number ?? '' }}
                                        </div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $license->issued_date ?? '' }}</div>
                                    </div>
                                    <div class="qual-equal-col">
                                        <div class="text-xs text-slate-700 break-words">{{ $license->expiry_date ?? '' }}</div>
                                    </div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('myinfo.qualifications.licenses.delete', $license->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this license?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="myinfo-action-btn hr-action-delete flex-shrink-0"
                                                    title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            </form>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0"
                                                title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row"
                                style="background-color: var(--bg-card);">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-equal-col"></div>
                                    <div class="qual-actions-cell"></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </x-main-layout>

    <style>
        /* Table container for horizontal scroll on smaller screens */
        .qual-table-container {
            width: 100%;
            overflow-x: auto;
        }

        /* Equal-size columns: checkbox and actions fixed, data columns share space equally */
        .qual-table-row {
            display: flex;
            align-items: stretch;
            min-height: 2.5rem;
            width: 100%;
        }

        .qual-checkbox-cell {
            width: 40px;
            min-width: 40px;
            max-width: 40px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0;
        }

        .qual-equal-col {
            flex: 1 1 0;
            min-width: 100px;
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .qual-equal-col>div,
        .qual-equal-col>span {
            width: 100%;
        }

        .qual-actions-cell {
            width: 90px;
            min-width: 90px;
            max-width: 90px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0;
        }

        /* Table header styling */
        .qual-table-header {
            padding: 0 !important;
        }

        .qual-table-header .qual-table-row {
            gap: 0 !important;
        }

        /* Data rows styling - override inline gap class */
        .qual-table-row.flex,
        .qual-table-row .qual-table-row {
            gap: 0 !important;
        }

        /* Ensure proper styling for nested table row structure */
        div[class*="border-b"]>.qual-table-row {
            padding-left: 0;
            padding-right: 0;
        }

        /* Remove extra padding from outer data row containers */
        .border.border-purple-100>div.border-b,
        .border.border-purple-100>div:first-child {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Fix outer data row container that has both qual-table-row and px-2 classes */
        div.border-b.qual-table-row,
        div.last\:border-b-0.qual-table-row {
            display: block !important;
            padding: 0 !important;
        }

        /* Ensure the inner row with actual data uses flex layout */
        div.border-b.qual-table-row>.qual-table-row,
        div.last\:border-b-0.qual-table-row>.qual-table-row {
            display: flex !important;
            align-items: stretch;
        }

        .myinfo-add-btn {
            min-width: 4rem;
            min-height: 1.75rem;
            font-size: 0.75rem;
        }

        .myinfo-checkbox {
            width: 1rem;
            height: 1rem;
        }

        .myinfo-action-btn {
            width: 1.75rem;
            height: 1.75rem;
            padding: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .myinfo-action-btn i {
            font-size: 0.875rem;
        }

        /* Equal-size form components */
        .qual-form-grid {
            display: grid;
        }

        .qual-form-grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .qual-form-grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .qual-form-grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .qual-form-input {
            min-height: 2.25rem;
            box-sizing: border-box;
        }

        .qual-form-date-wrap {
            min-height: 2.25rem;
        }

        .qual-form-date-wrap input {
            width: 100%;
            min-height: 2.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .qual-form-grid-2 {
                grid-template-columns: 1fr;
            }

            .qual-form-grid-4 {
                grid-template-columns: 1fr;
            }

            .qual-form-grid-3 {
                grid-template-columns: 1fr;
            }

            /* Responsive table - enable horizontal scroll */
            .qual-table-header,
            .border.border-purple-100 {
                min-width: 600px;
            }

            .qual-equal-col {
                min-width: 80px;
            }
        }

        /* Modal popup */
        .qual-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .qual-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }

        .qual-modal-content {
            position: relative;
            z-index: 51;
            background: var(--bg-card);
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-default);
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
    <script>
        // Modal & Form Helpers
        function setFormToEdit(formId, modalId, title, actionUrl) {
            const form = document.getElementById(formId);
            if (!form) return;
            form.action = actionUrl;
            const modal = document.getElementById(modalId);
            const titleEl = modal.querySelector('h2');
            if (titleEl) titleEl.innerText = title;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            } else {
                methodInput.value = 'PUT';
            }
            modal.style.display = 'flex';
        }

        function resetFormToAdd(formId, modalId, title, actionUrl) {
            const form = document.getElementById(formId);
            if (!form) return;
            form.reset();
            // Clear date picker displays
            form.querySelectorAll('[id$="-display"]').forEach(el => el.value = '');
            form.action = actionUrl;
            const modal = document.getElementById(modalId);
            const titleEl = modal.querySelector('h2');
            if (titleEl) titleEl.innerText = title;
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
            modal.style.display = 'flex';
        }

        // Work Experience
        function prepareWorkExpAdd() {
            resetFormToAdd('work-exp-form', 'work-exp-modal', 'Add Work Experience', '{{ route('myinfo.qualifications.work-experience.store') }}');
        }
        function editWorkExp(data) {
            setFormToEdit('work-exp-form', 'work-exp-modal', 'Edit Work Experience', '{{ url('my-info/qualifications/work-experience') }}/' + data.id);
            const form = document.getElementById('work-exp-form');
            form.company.value = data.company || '';
            form.job_title.value = data.job_title || '';
            if (document.getElementById('work-exp-from-display')) document.getElementById('work-exp-from-display').value = data.from_date || '';
            if (document.getElementById('work-exp-to-display')) document.getElementById('work-exp-to-display').value = data.to_date || '';
            form.comment.value = data.comment || '';
        }
        function closeWorkExpForm() {
            document.getElementById('work-exp-modal').style.display = 'none';
        }

        // Education
        function prepareEducationAdd() {
            resetFormToAdd('education-form', 'education-modal', 'Add Education', '{{ route('myinfo.qualifications.education.store') }}');
        }
        function editEducation(data) {
            setFormToEdit('education-form', 'education-modal', 'Edit Education', '{{ url('my-info/qualifications/education') }}/' + data.id);
            const form = document.getElementById('education-form');
            form.level.value = data.level || '';
            form.institute.value = data.institute || '';
            form.major_specialization.value = data.major_specialization || '';
            form.year.value = data.year || '';
            form.gpa_score.value = data.gpa_score || '';
            if (document.getElementById('education-start-date-display')) document.getElementById('education-start-date-display').value = data.start_date || '';
            if (document.getElementById('education-end-date-display')) document.getElementById('education-end-date-display').value = data.end_date || '';
        }
        function closeEducationForm() {
            document.getElementById('education-modal').style.display = 'none';
        }

        // Skills
        function prepareSkillAdd() {
            resetFormToAdd('skill-form', 'skill-modal', 'Add Skill', '{{ route('myinfo.qualifications.skills.store') }}');
        }
        function editSkill(data) {
            setFormToEdit('skill-form', 'skill-modal', 'Edit Skill', '{{ url('my-info/qualifications/skills') }}/' + data.id);
            const form = document.getElementById('skill-form');
            form.skill.value = data.skill || '';
            form.years_of_experience.value = data.years_of_experience || '';
            form.comments.value = data.comments || '';
        }
        function closeSkillForm() {
            document.getElementById('skill-modal').style.display = 'none';
        }

        // Languages
        function prepareLanguageAdd() {
            resetFormToAdd('language-form', 'language-modal', 'Add Language', '{{ route('myinfo.qualifications.languages.store') }}');
        }
        function editLanguage(data) {
            setFormToEdit('language-form', 'language-modal', 'Edit Language', '{{ url('my-info/qualifications/languages') }}/' + data.id);
            const form = document.getElementById('language-form');
            form.language.value = data.language || '';
            form.fluency.value = data.fluency || '';
            form.competency.value = data.competency || '';
            form.comments.value = data.comments || '';
        }
        function closeLanguageForm() {
            document.getElementById('language-modal').style.display = 'none';
        }

        // Licenses
        function prepareLicenseAdd() {
            resetFormToAdd('license-form', 'license-modal', 'Add License', '{{ route('myinfo.qualifications.licenses.store') }}');
        }
        function editLicense(data) {
            setFormToEdit('license-form', 'license-modal', 'Edit License', '{{ url('my-info/qualifications/licenses') }}/' + data.id);
            const form = document.getElementById('license-form');
            form.license_type.value = data.license_type || '';
            form.license_number.value = data.license_number || '';
            if (document.getElementById('license-issued-date-display')) document.getElementById('license-issued-date-display').value = data.issued_date || '';
            if (document.getElementById('license-expiry-date-display')) document.getElementById('license-expiry-date-display').value = data.expiry_date || '';
        }
        function closeLicenseForm() {
            document.getElementById('license-modal').style.display = 'none';
        }

        // Global submit preventers (handled by standard form submission now, but kept for consistency)
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (e) {
                // standard submission
            });
        });
    </script>
@endsection