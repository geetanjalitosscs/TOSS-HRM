@extends('layouts.app')

@section('title', 'My Info - Qualifications')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Work Experience Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Work Experience</h2>
                        <button type="button" onclick="toggleWorkExpForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Work Experience Form (Inline) -->
                    <div id="work-exp-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Work Experience</h2>
                        <form id="work-exp-form">
                            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Company<span class="text-red-500">*</span></label>
                                    <input type="text" name="company" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Job Title<span class="text-red-500">*</span></label>
                                    <input type="text" name="job_title" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                            </div>
                            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">From</label>
                                    <x-date-picker id="work-exp-from" name="from" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">To</label>
                                    <x-date-picker id="work-exp-to" name="to" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Comment</label>
                                <textarea name="comment" rows="3" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeWorkExpForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
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
                    <div class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Company</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Job Title</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">From</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">To</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Comment</span></div>
                            <div class="qual-actions-cell"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span></div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($workExperience as $exp)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $exp->company ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $exp->job_title ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $exp->from ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $exp->to ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $exp->comment ?? '' }}</div></div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row" style="background-color: var(--bg-card);">
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
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Education</h2>
                        <button type="button" onclick="toggleEducationForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Education Form (Inline) -->
                    <div id="education-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Education</h2>
                        <form id="education-form">
                            <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Level<span class="text-red-500">*</span></label>
                                    <select name="level" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
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
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Institute</label>
                                    <input type="text" name="institute" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Major/Specialization</label>
                                    <input type="text" name="major_specialization" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                            </div>
                            <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Year</label>
                                    <input type="text" name="year" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">GPA/Score</label>
                                    <input type="text" name="gpa_score" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div></div>
                            </div>
                            <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Start Date</label>
                                    <x-date-picker id="education-start-date" name="start_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">End Date</label>
                                    <x-date-picker id="education-end-date" name="end_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                </div>
                                <div></div>
                            </div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeEducationForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
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
                    <div class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Level</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Year</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">GPA/Score</span></div>
                            <div class="qual-actions-cell"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span></div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($education as $edu)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $edu->level ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $edu->year ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $edu->gpa_score ?? '' }}</div></div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row" style="background-color: var(--bg-card);">
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
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Skills</h2>
                        <button type="button" onclick="toggleSkillForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Skill Form (Inline) -->
                    <div id="skill-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Skill</h2>
                        <form id="skill-form">
                            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Skill<span class="text-red-500">*</span></label>
                                    <select name="skill" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Years of Experience</label>
                                    <input type="text" name="years_of_experience" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Comments</label>
                                <textarea name="comments" rows="3" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeSkillForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
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

                    <div class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Skill</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Years of Experience</span></div>
                            <div class="qual-actions-cell"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span></div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($skills as $skill)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $skill->skill ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $skill->years_of_experience ?? '' }}</div></div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row" style="background-color: var(--bg-card);">
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
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Languages</h2>
                        <button type="button" onclick="toggleLanguageForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Language Form (Inline) -->
                    <div id="language-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Language</h2>
                        <form id="language-form">
                            <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Language<span class="text-red-500">*</span></label>
                                    <select name="language" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Fluency<span class="text-red-500">*</span></label>
                                    <select name="fluency" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Competency<span class="text-red-500">*</span></label>
                                    <select name="competency" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Comments</label>
                                <textarea name="comments" rows="3" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeLanguageForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
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

                    <div class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Language</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Fluency</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Competency</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Comments</span></div>
                            <div class="qual-actions-cell"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span></div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($languages as $lang)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $lang->language ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $lang->fluency ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $lang->competency ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $lang->comments ?? '' }}</div></div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row" style="background-color: var(--bg-card);">
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
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">License</h2>
                        <button type="button" onclick="toggleLicenseForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add License Form (Inline) -->
                    <div id="license-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add License</h2>
                        <form id="license-form">
                            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">License Type<span class="text-red-500">*</span></label>
                                    <select name="license_type" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">License Number</label>
                                    <input type="text" name="license_number" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                            </div>
                            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Issued Date</label>
                                    <x-date-picker id="license-issued-date" name="issued_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Expiry Date</label>
                                    <x-date-picker id="license-expiry-date" name="expiry_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="qual-form-date-wrap" />
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeLicenseForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
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

                    <div class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">License</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Issued Date</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Expiry Date</span></div>
                            <div class="qual-actions-cell"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span></div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($licenses as $license)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $license->license ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $license->issued_date ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $license->expiry_date ?? '' }}</div></div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row" style="background-color: var(--bg-card);">
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

                <!-- Attachments Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Attachments</h2>
                        <button type="button" onclick="toggleQualAttachmentForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Attachment Form (Inline) -->
                    <div id="qual-attachment-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Attachment</h2>
                        <form id="qual-attachment-form">
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Select File<span class="text-red-500">*</span></label>
                                <div class="qual-attachment-upload flex items-center gap-2 flex-wrap">
                                    <input type="file" id="qual-attachment-file-input" name="file" required class="hidden" accept="*">
                                    <button type="button" onclick="document.getElementById('qual-attachment-file-input').click()" class="qual-form-input px-3 py-2 text-sm border rounded-l-lg rounded-r-none" style="background-color: var(--bg-hover); border-color: var(--border-default); color: var(--text-primary); min-height: 2.25rem;">Browse</button>
                                    <span id="qual-attachment-file-name" class="qual-form-input flex-1 px-3 py-2 text-sm border border-l-0 rounded-r-lg rounded-l-none" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-muted); min-height: 2.25rem; display: inline-block;">No file selected</span>
                                    <button type="button" class="qual-form-input px-3 py-2 text-sm border rounded-lg flex items-center justify-center" style="background-color: var(--bg-hover); border-color: var(--border-default); color: var(--text-primary); min-height: 2.25rem; min-width: 2.25rem;" title="Upload"><i class="fas fa-arrow-up text-sm"></i></button>
                                </div>
                                <p class="text-xs mt-1" style="color: var(--text-muted);">Accepts up to 1MB</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Comment</label>
                                <textarea name="comment" rows="3" placeholder="Type comment here" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeQualAttachmentForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">Cancel</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">Save</button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
                    </div>

                    @php
                        $attachments = $attachments ?? collect([]);
                        $attachmentsCount = $attachments->count();
                    @endphp
                    @if($attachmentsCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $attachmentsCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <div class="qual-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 qual-table-row">
                            <div class="qual-checkbox-cell">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">File Name</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Description</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Size</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Type</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Date Added</span></div>
                            <div class="qual-equal-col"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Added By</span></div>
                            <div class="qual-actions-cell"><span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span></div>
                        </div>
                    </div>

                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($attachments as $attachment)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors qual-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $attachment->file_name ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $attachment->description ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $attachment->size ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $attachment->type ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $attachment->date_added ?? '' }}</div></div>
                                    <div class="qual-equal-col"><div class="text-xs text-slate-700 break-words">{{ $attachment->added_by ?? '' }}</div></div>
                                    <div class="qual-actions-cell">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete"><i class="fas fa-trash-alt text-sm"></i></button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit"><i class="fas fa-edit text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 qual-table-row" style="background-color: var(--bg-card);">
                                <div class="flex items-center gap-1 qual-table-row">
                                    <div class="qual-checkbox-cell"></div>
                                    <div class="qual-equal-col"></div>
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
            </div>
        </div>
    </x-main-layout>

    <style>
        /* Equal-size columns: checkbox and actions fixed, data columns share space equally */
        .qual-table-row {
            display: flex;
            align-items: center;
            min-height: 2.25rem;
        }
        .qual-checkbox-cell {
            width: 40px;
            min-width: 40px;
            flex-shrink: 0;
        }
        .qual-equal-col {
            flex: 1 1 0;
            min-width: 0;
        }
        .qual-actions-cell {
            width: 90px;
            min-width: 90px;
            flex-shrink: 0;
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
        .qual-form-grid { display: grid; }
        .qual-form-grid-2 { grid-template-columns: repeat(2, 1fr); }
        .qual-form-grid-4 { grid-template-columns: repeat(4, 1fr); }
        .qual-form-grid-3 { grid-template-columns: repeat(3, 1fr); }
        .qual-form-input { min-height: 2.25rem; box-sizing: border-box; }
        .qual-form-date-wrap { min-height: 2.25rem; }
        .qual-form-date-wrap input { width: 100%; min-height: 2.25rem; padding: 0.5rem 0.75rem; font-size: 0.875rem; border-radius: 0.5rem; box-sizing: border-box; }
        @media (max-width: 768px) {
            .qual-form-grid-2 { grid-template-columns: 1fr; }
            .qual-form-grid-4 { grid-template-columns: 1fr; }
            .qual-form-grid-3 { grid-template-columns: 1fr; }
        }
    </style>
    <script>
        function toggleWorkExpForm() {
            var el = document.getElementById('work-exp-form-container');
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function closeWorkExpForm() {
            var el = document.getElementById('work-exp-form-container');
            if (el) el.style.display = 'none';
            var form = document.getElementById('work-exp-form');
            if (form) form.reset();
        }
        document.getElementById('work-exp-form')?.addEventListener('submit', function(e) { e.preventDefault(); closeWorkExpForm(); });

        function toggleEducationForm() {
            var el = document.getElementById('education-form-container');
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function closeEducationForm() {
            var el = document.getElementById('education-form-container');
            if (el) el.style.display = 'none';
            var form = document.getElementById('education-form');
            if (form) form.reset();
        }
        document.getElementById('education-form')?.addEventListener('submit', function(e) { e.preventDefault(); closeEducationForm(); });

        function toggleSkillForm() {
            var el = document.getElementById('skill-form-container');
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function closeSkillForm() {
            var el = document.getElementById('skill-form-container');
            if (el) el.style.display = 'none';
            var form = document.getElementById('skill-form');
            if (form) form.reset();
        }
        document.getElementById('skill-form')?.addEventListener('submit', function(e) { e.preventDefault(); closeSkillForm(); });

        function toggleLanguageForm() {
            var el = document.getElementById('language-form-container');
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function closeLanguageForm() {
            var el = document.getElementById('language-form-container');
            if (el) el.style.display = 'none';
            var form = document.getElementById('language-form');
            if (form) form.reset();
        }
        document.getElementById('language-form')?.addEventListener('submit', function(e) { e.preventDefault(); closeLanguageForm(); });

        function toggleLicenseForm() {
            var el = document.getElementById('license-form-container');
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function closeLicenseForm() {
            var el = document.getElementById('license-form-container');
            if (el) el.style.display = 'none';
            var form = document.getElementById('license-form');
            if (form) form.reset();
        }
        document.getElementById('license-form')?.addEventListener('submit', function(e) { e.preventDefault(); closeLicenseForm(); });

        function toggleQualAttachmentForm() {
            var el = document.getElementById('qual-attachment-form-container');
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function closeQualAttachmentForm() {
            var el = document.getElementById('qual-attachment-form-container');
            if (el) el.style.display = 'none';
            var form = document.getElementById('qual-attachment-form');
            if (form) form.reset();
            var span = document.getElementById('qual-attachment-file-name');
            if (span) span.textContent = 'No file selected';
        }
        document.getElementById('qual-attachment-file-input')?.addEventListener('change', function() {
            var span = document.getElementById('qual-attachment-file-name');
            if (span) span.textContent = this.files && this.files[0] ? this.files[0].name : 'No file selected';
        });
        document.getElementById('qual-attachment-form')?.addEventListener('submit', function(e) { e.preventDefault(); closeQualAttachmentForm(); });
    </script>
@endsection
