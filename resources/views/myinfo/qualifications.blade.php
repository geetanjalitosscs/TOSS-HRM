@extends('layouts.app')

@section('title', 'My Info - Qualifications')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1 space-y-6">
                <!-- Work Experience Section -->
                <section id="work-experience-section" class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-briefcase text-purple-500"></i> Work Experience
                        </h2>
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="work-exp-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openWorkExpBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button onClick="prepareWorkExpAdd()" />
                        </div>
                    </div>

                    @php
                        $workExperience = $workExperience ?? collect([]);
                        $workExpCount = $workExperience->count();
                    @endphp
                    @if($workExpCount > 0)
                        <x-records-found :count="$workExpCount" />
                    @endif

                    <!-- Table -->
                    <div id="work-exp-table">
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <!-- Table Header -->
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b"
                                style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                        id="work-exp-master-checkbox"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Company</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Job Title</span></div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">From</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">To</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Comment</span>
                                </div>
                                <div class="qual-actions-cell"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                        style="color: var(--text-primary);">Actions</span>
                                </div>
                            </div>

                            <!-- Table Rows -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                                @forelse($workExperience as $exp)
                                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row"
                                        style="background-color: var(--bg-card); border-color: var(--border-default);">
                                        <div class="flex items-center gap-1 qual-table-row" style="width: 100%;">
                                            <div class="flex-shrink-0" style="width: 24px;">
                                                <input type="checkbox"
                                                    class="work-exp-row-checkbox rounded w-3.5 h-3.5"
                                                    data-exp-id="{{ $exp->id }}"
                                                    style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $exp->company ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $exp->job_title ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $exp->from_date ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $exp->to_date ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $exp->comment ?? '' }}</div>
                                            </div>
                                            <div class="qual-actions-cell">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="editWorkExp({{ json_encode($exp) }})"
                                                        class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                            class="fas fa-edit text-sm"></i></button>
                                                    <button type="button" onclick="openWorkExpDeleteModal({{ $exp->id }})"
                                                        class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                            class="fas fa-trash-alt text-sm"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                        <div class="text-xs text-slate-500 text-center py-4">No work experience found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Education Section -->
                <section id="education-section" class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-graduation-cap text-purple-500"></i> Education
                        </h2>
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="education-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openEducationBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button onClick="prepareEducationAdd()" />
                        </div>
                    </div>

                    @php
                        $education = $education ?? collect([]);
                        $educationCount = $education->count();
                    @endphp
                    @if($educationCount > 0)
                        <x-records-found :count="$educationCount" />
                    @endif

                    <!-- Table -->
                    <div id="education-table">
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <!-- Table Header -->
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b"
                                style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                        id="education-master-checkbox"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Level</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Institute</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Major/Specialization</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Year</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">GPA/Score</span>
                                </div>
                                <div class="qual-actions-cell"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                        style="color: var(--text-primary);">Actions</span>
                                </div>
                            </div>

                            <!-- Table Rows -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                                @forelse($education as $edu)
                                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row"
                                        style="background-color: var(--bg-card); border-color: var(--border-default);">
                                        <div class="flex items-center gap-1 qual-table-row" style="width: 100%;">
                                            <div class="flex-shrink-0" style="width: 24px;">
                                                <input type="checkbox"
                                                    class="education-row-checkbox rounded w-3.5 h-3.5"
                                                    data-edu-id="{{ $edu->id }}"
                                                    style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $edu->level ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $edu->institute ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $edu->major_specialization ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $edu->year ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $edu->gpa_score ?? '' }}</div>
                                            </div>
                                            <div class="qual-actions-cell">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="viewEducation({{ json_encode($edu) }})"
                                                        class="hr-action-view flex-shrink-0" title="View"><i
                                                            class="fas fa-eye text-sm"></i></button>
                                                    <button type="button" onclick="editEducation({{ json_encode($edu) }})"
                                                        class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                            class="fas fa-edit text-sm"></i></button>
                                                    <button type="button" onclick="openEducationDeleteModal({{ $edu->id }})"
                                                        class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                            class="fas fa-trash-alt text-sm"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                        <div class="text-xs text-slate-500 text-center py-4">No education records found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Skills Section -->
                <section id="skills-section" class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-tools text-purple-500"></i> Skills
                        </h2>
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="skills-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openSkillsBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button onClick="prepareSkillAdd()" />
                        </div>
                    </div>

                    @php
                        $skills = $skills ?? collect([]);
                        $skillsCount = $skills->count();
                    @endphp
                    @if($skillsCount > 0)
                        <x-records-found :count="$skillsCount" />
                    @endif

                    <!-- Table -->
                    <div id="skills-table">
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <!-- Table Header -->
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b"
                                style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                        id="skills-master-checkbox"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Skill</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Years of Experience</span></div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Comments</span></div>
                                <div class="qual-actions-cell"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                        style="color: var(--text-primary);">Actions</span>
                                </div>
                            </div>

                            <!-- Table Rows -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                                @forelse($skills as $skill)
                                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row"
                                        style="background-color: var(--bg-card); border-color: var(--border-default);">
                                        <div class="flex items-center gap-1 qual-table-row" style="width: 100%;">
                                            <div class="flex-shrink-0" style="width: 24px;">
                                                <input type="checkbox"
                                                    class="skills-row-checkbox rounded w-3.5 h-3.5"
                                                    data-skill-id="{{ $skill->id }}"
                                                    style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $skill->skill ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $skill->years_of_experience ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $skill->comments ?? '' }}</div>
                                            </div>
                                            <div class="qual-actions-cell">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="editSkill({{ json_encode($skill) }})"
                                                        class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                            class="fas fa-edit text-sm"></i></button>
                                                    <button type="button" onclick="openSkillsDeleteModal({{ $skill->id }})"
                                                        class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                            class="fas fa-trash-alt text-sm"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                        <div class="text-xs text-slate-500 text-center py-4">No skills found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Languages Section -->
                <section id="languages-section" class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-language text-purple-500"></i> Languages
                        </h2>
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="languages-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openLanguagesBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button onClick="prepareLanguageAdd()" />
                        </div>
                    </div>

                    @php
                        $languages = $languages ?? collect([]);
                        $languagesCount = $languages->count();
                    @endphp
                    @if($languagesCount > 0)
                        <x-records-found :count="$languagesCount" />
                    @endif

                    <!-- Table -->
                    <div id="languages-table">
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <!-- Table Header -->
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b"
                                style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                        id="languages-master-checkbox"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Language</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Fluency</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Competency</span>
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Comments</span>
                                </div>
                                <div class="qual-actions-cell"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                        style="color: var(--text-primary);">Actions</span>
                                </div>
                            </div>

                            <!-- Table Rows -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                                @forelse($languages as $lang)
                                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row"
                                        style="background-color: var(--bg-card); border-color: var(--border-default);">
                                        <div class="flex items-center gap-1 qual-table-row" style="width: 100%;">
                                            <div class="flex-shrink-0" style="width: 24px;">
                                                <input type="checkbox"
                                                    class="languages-row-checkbox rounded w-3.5 h-3.5"
                                                    data-lang-id="{{ $lang->id }}"
                                                    style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $lang->language ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $lang->fluency ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $lang->competency ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $lang->comments ?? '' }}</div>
                                            </div>
                                            <div class="qual-actions-cell">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="editLanguage({{ json_encode($lang) }})"
                                                        class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                            class="fas fa-edit text-sm"></i></button>
                                                    <button type="button" onclick="openLanguagesDeleteModal({{ $lang->id }})"
                                                        class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                            class="fas fa-trash-alt text-sm"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                        <div class="text-xs text-slate-500 text-center py-4">No languages found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <!-- License Section -->
                <section id="licenses-section" class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-id-card text-purple-500"></i> License
                        </h2>
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="licenses-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openLicensesBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button onClick="prepareLicenseAdd()" />
                        </div>
                    </div>

                    @php
                        $licenses = $licenses ?? collect([]);
                        $licensesCount = $licenses->count();
                    @endphp
                    @if($licensesCount > 0)
                        <x-records-found :count="$licensesCount" />
                    @endif

                    <!-- Table -->
                    <div id="licenses-table">
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <!-- Table Header -->
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b"
                                style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                        id="licenses-master-checkbox"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">License Type</span></div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">License Number</span></div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Issued Date</span></div>
                                <div class="qual-equal-col"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Expiry Date</span></div>
                                <div class="qual-actions-cell"><span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                        style="color: var(--text-primary);">Actions</span>
                                </div>
                            </div>

                            <!-- Table Rows -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                                @forelse($licenses as $license)
                                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row"
                                        style="background-color: var(--bg-card); border-color: var(--border-default);">
                                        <div class="flex items-center gap-1 qual-table-row" style="width: 100%;">
                                            <div class="flex-shrink-0" style="width: 24px;">
                                                <input type="checkbox"
                                                    class="licenses-row-checkbox rounded w-3.5 h-3.5"
                                                    data-license-id="{{ $license->id }}"
                                                    style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $license->license_type ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $license->license_number ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $license->issued_date ?? '' }}</div>
                                            </div>
                                            <div class="qual-equal-col">
                                                <div class="text-xs break-words" style="color: var(--text-primary);">{{ $license->expiry_date ?? '' }}</div>
                                            </div>
                                            <div class="qual-actions-cell">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="editLicense({{ json_encode($license) }})"
                                                        class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                            class="fas fa-edit text-sm"></i></button>
                                                    <button type="button" onclick="openLicensesDeleteModal({{ $license->id }})"
                                                        class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                            class="fas fa-trash-alt text-sm"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                        <div class="text-xs text-slate-500 text-center py-4">No licenses found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </x-main-layout>

    <!-- Work Experience Modal -->
    <x-admin.modal id="work-exp-modal" title="Add Work Experience" maxWidth="lg" backdropOnClick="closeWorkExpForm()">
        <form id="work-exp-form" action="{{ route('myinfo.qualifications.work-experience.store') }}" method="POST">
            @csrf
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
                <x-date-picker 
                    id="work-exp-from" 
                    name="from" 
                    value="" 
                    label="From"
                />
                <x-date-picker 
                    id="work-exp-to" 
                    name="to" 
                    value="" 
                    label="To"
                />
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Comment</label>
                <textarea name="comment" rows="3" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
            </div>
            <div class="flex items-center justify-between gap-3 mb-4">
                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeWorkExpForm()" class="hr-btn-secondary px-4 py-2 text-sm font-medium rounded-lg">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium text-white rounded-lg">Save</button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <!-- Education Modal -->
    <x-admin.modal id="education-modal" title="Add Education" maxWidth="lg" backdropOnClick="closeEducationForm()">
        <form id="education-form" action="{{ route('myinfo.qualifications.education.store') }}" method="POST">
            @csrf
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
            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                <x-date-picker 
                    id="education-start-date" 
                    name="start_date" 
                    value="" 
                    label="Start Date"
                />
                <x-date-picker 
                    id="education-end-date" 
                    name="end_date" 
                    value="" 
                    label="End Date"
                />
            </div>
            <div class="flex items-center justify-between gap-3 mb-4">
                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEducationForm()" class="hr-btn-secondary px-4 py-2 text-sm font-medium rounded-lg">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium text-white rounded-lg">Save</button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <!-- Skills Modal -->
    <x-admin.modal id="skill-modal" title="Add Skill" maxWidth="lg" backdropOnClick="closeSkillForm()">
        <form id="skill-form" action="{{ route('myinfo.qualifications.skills.store') }}" method="POST">
            @csrf
            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Skill<span class="text-red-500">*</span></label>
                    <input type="text" name="skill" required placeholder="Enter skill" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
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
                    <button type="button" onclick="closeSkillForm()" class="hr-btn-secondary px-4 py-2 text-sm font-medium rounded-lg">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium text-white rounded-lg">Save</button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <!-- Languages Modal -->
    <x-admin.modal id="language-modal" title="Add Language" maxWidth="lg" backdropOnClick="closeLanguageForm()">
        <form id="language-form" action="{{ route('myinfo.qualifications.languages.store') }}" method="POST">
            @csrf
            <div class="qual-form-grid qual-form-grid-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Language<span class="text-red-500">*</span></label>
                    <input type="text" name="language" required placeholder="Enter language" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Fluency<span class="text-red-500">*</span></label>
                    <select name="fluency" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                        <option value="">-- Select --</option>
                        <option value="Speaking">Speaking</option>
                        <option value="Reading">Reading</option>
                        <option value="Writing">Writing</option>
                        <option value="Listening">Listening</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Competency<span class="text-red-500">*</span></label>
                    <select name="competency" required class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
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
                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">Comments</label>
                <textarea name="comments" rows="3" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
            </div>
            <div class="flex items-center justify-between gap-3 mb-4">
                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeLanguageForm()" class="hr-btn-secondary px-4 py-2 text-sm font-medium rounded-lg">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium text-white rounded-lg">Save</button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <!-- License Modal -->
    <x-admin.modal id="license-modal" title="Add License" maxWidth="lg" backdropOnClick="closeLicenseForm()">
        <form id="license-form" action="{{ route('myinfo.qualifications.licenses.store') }}" method="POST">
            @csrf
            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">License Type<span class="text-red-500">*</span></label>
                    <input type="text" name="license_type" required placeholder="Enter license type" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">License Number</label>
                    <input type="text" name="license_number" class="qual-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                </div>
            </div>
            <div class="qual-form-grid qual-form-grid-2 gap-4 mb-4">
                <x-date-picker 
                    id="license-issued-date" 
                    name="issued_date" 
                    value="" 
                    label="Issued Date"
                />
                <x-date-picker 
                    id="license-expiry-date" 
                    name="expiry_date" 
                    value="" 
                    label="Expiry Date"
                />
            </div>
            <div class="flex items-center justify-between gap-3 mb-4">
                <div class="text-xs" style="color: var(--text-muted);"><span class="text-red-500">*</span> Required</div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeLicenseForm()" class="hr-btn-secondary px-4 py-2 text-sm font-medium rounded-lg">Cancel</button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium text-white rounded-lg">Save</button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <!-- Delete Modals for each section -->
    <x-admin.modal id="work-exp-delete-modal" title="Delete Work Experience" maxWidth="xs" backdropOnClick="closeWorkExpDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete this work experience?</p>
            <form id="work-exp-delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeWorkExpDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmWorkExpDelete()">Delete</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="work-exp-bulk-delete-modal" title="Delete Selected Work Experience" maxWidth="xs" backdropOnClick="closeWorkExpBulkDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete all selected work experience records?</p>
            <form id="work-exp-bulk-delete-form" method="POST" action="{{ route('myinfo.qualifications.work-experience.bulk-delete') }}" style="display: none;">@csrf <input type="hidden" name="ids" id="work-exp-bulk-delete-ids"></form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeWorkExpBulkDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmWorkExpBulkDelete()">Delete Selected</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="education-delete-modal" title="Delete Education" maxWidth="xs" backdropOnClick="closeEducationDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete this education record?</p>
            <form id="education-delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeEducationDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmEducationDelete()">Delete</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="education-bulk-delete-modal" title="Delete Selected Education" maxWidth="xs" backdropOnClick="closeEducationBulkDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete all selected education records?</p>
            <form id="education-bulk-delete-form" method="POST" action="{{ route('myinfo.qualifications.education.bulk-delete') }}" style="display: none;">@csrf <input type="hidden" name="ids" id="education-bulk-delete-ids"></form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeEducationBulkDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmEducationBulkDelete()">Delete Selected</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="skills-delete-modal" title="Delete Skill" maxWidth="xs" backdropOnClick="closeSkillsDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete this skill?</p>
            <form id="skills-delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeSkillsDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmSkillsDelete()">Delete</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="skills-bulk-delete-modal" title="Delete Selected Skills" maxWidth="xs" backdropOnClick="closeSkillsBulkDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete all selected skills?</p>
            <form id="skills-bulk-delete-form" method="POST" action="{{ route('myinfo.qualifications.skills.bulk-delete') }}" style="display: none;">@csrf <input type="hidden" name="ids" id="skills-bulk-delete-ids"></form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeSkillsBulkDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmSkillsBulkDelete()">Delete Selected</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="languages-delete-modal" title="Delete Language" maxWidth="xs" backdropOnClick="closeLanguagesDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete this language?</p>
            <form id="languages-delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeLanguagesDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmLanguagesDelete()">Delete</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="languages-bulk-delete-modal" title="Delete Selected Languages" maxWidth="xs" backdropOnClick="closeLanguagesBulkDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete all selected languages?</p>
            <form id="languages-bulk-delete-form" method="POST" action="{{ route('myinfo.qualifications.languages.bulk-delete') }}" style="display: none;">@csrf <input type="hidden" name="ids" id="languages-bulk-delete-ids"></form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeLanguagesBulkDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmLanguagesBulkDelete()">Delete Selected</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="licenses-delete-modal" title="Delete License" maxWidth="xs" backdropOnClick="closeLicensesDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete this license?</p>
            <form id="licenses-delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeLicensesDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmLicensesDelete()">Delete</button>
            </div>
        </div>
    </x-admin.modal>

    <x-admin.modal id="licenses-bulk-delete-modal" title="Delete Selected Licenses" maxWidth="xs" backdropOnClick="closeLicensesBulkDeleteModal()">
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete all selected licenses?</p>
            <form id="licenses-bulk-delete-form" method="POST" action="{{ route('myinfo.qualifications.licenses.bulk-delete') }}" style="display: none;">@csrf <input type="hidden" name="ids" id="licenses-bulk-delete-ids"></form>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeLicensesBulkDeleteModal()">Cancel</button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" onclick="confirmLicensesBulkDelete()">Delete Selected</button>
            </div>
        </div>
    </x-admin.modal>

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

        .qual-form-date-wrap {
            min-height: 2.25rem;
        }

        .qual-form-date-wrap input[type="text"] {
            width: 100%;
            min-height: 2.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            box-sizing: border-box;
            background-color: var(--bg-input);
            border-color: var(--border-default);
            color: var(--text-primary);
        }

        .qual-form-date-wrap button {
            min-height: 2.25rem;
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
            const titleEl = modal.querySelector('h3');
            if (titleEl) titleEl.textContent = title;
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
            modal.classList.remove('hidden');
        }

        function resetFormToAdd(formId, modalId, title, actionUrl) {
            const form = document.getElementById(formId);
            if (!form) return;
            form.reset();
            // Clear date picker display and hidden inputs
            form.querySelectorAll('[id$="-display"]').forEach(el => el.value = '');
            form.querySelectorAll('[id$="-hidden"]').forEach(el => el.value = '');
            form.action = actionUrl;
            const modal = document.getElementById(modalId);
            const titleEl = modal.querySelector('h3');
            if (titleEl) titleEl.textContent = title;
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
            modal.classList.remove('hidden');
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
            
            // Set date picker values for simple variant
            const fromDateInput = document.getElementById('work-exp-from');
            if (fromDateInput && data.from_date) {
                fromDateInput.value = data.from_date;
            }
            const toDateInput = document.getElementById('work-exp-to');
            if (toDateInput && data.to_date) {
                toDateInput.value = data.to_date;
            }
            
            form.comment.value = data.comment || '';
        }
        function closeWorkExpForm() {
            document.getElementById('work-exp-modal').classList.add('hidden');
        }
        function openWorkExpDeleteModal(id) {
            deleteWorkExpId = id;
            document.getElementById('work-exp-delete-modal').classList.remove('hidden');
        }
        function closeWorkExpDeleteModal() {
            document.getElementById('work-exp-delete-modal').classList.add('hidden');
            deleteWorkExpId = null;
        }
        function confirmWorkExpDelete() {
            if (deleteWorkExpId) {
                document.getElementById('work-exp-delete-form').action = '{{ url('my-info/qualifications/work-experience') }}/' + deleteWorkExpId;
                document.getElementById('work-exp-delete-form').submit();
            }
        }
        function openWorkExpBulkDeleteModal() {
            document.getElementById('work-exp-bulk-delete-modal').classList.remove('hidden');
        }
        function closeWorkExpBulkDeleteModal() {
            document.getElementById('work-exp-bulk-delete-modal').classList.add('hidden');
        }
        function confirmWorkExpBulkDelete() {
            const checked = document.querySelectorAll('.work-exp-row-checkbox:checked');
            const ids = [];
            checked.forEach(cb => ids.push(cb.getAttribute('data-exp-id')));
            if (ids.length) {
                document.getElementById('work-exp-bulk-delete-ids').value = ids.join(',');
                document.getElementById('work-exp-bulk-delete-form').submit();
            }
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
            
            // Set date picker values for simple variant
            const startDateInput = document.getElementById('education-start-date');
            if (startDateInput && data.start_date) {
                startDateInput.value = data.start_date;
            }
            const endDateInput = document.getElementById('education-end-date');
            if (endDateInput && data.end_date) {
                endDateInput.value = data.end_date;
            }
        }
        function closeEducationForm() {
            document.getElementById('education-modal').classList.add('hidden');
        }
        function openEducationDeleteModal(id) {
            deleteEducationId = id;
            document.getElementById('education-delete-modal').classList.remove('hidden');
        }
        function closeEducationDeleteModal() {
            document.getElementById('education-delete-modal').classList.add('hidden');
            deleteEducationId = null;
        }
        function confirmEducationDelete() {
            if (deleteEducationId) {
                document.getElementById('education-delete-form').action = '{{ url('my-info/qualifications/education') }}/' + deleteEducationId;
                document.getElementById('education-delete-form').submit();
            }
        }
        function openEducationBulkDeleteModal() {
            document.getElementById('education-bulk-delete-modal').classList.remove('hidden');
        }
        function closeEducationBulkDeleteModal() {
            document.getElementById('education-bulk-delete-modal').classList.add('hidden');
        }
        function confirmEducationBulkDelete() {
            const checked = document.querySelectorAll('.education-row-checkbox:checked');
            const ids = [];
            checked.forEach(cb => ids.push(cb.getAttribute('data-edu-id')));
            if (ids.length) {
                document.getElementById('education-bulk-delete-ids').value = ids.join(',');
                document.getElementById('education-bulk-delete-form').submit();
            }
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
            document.getElementById('skill-modal').classList.add('hidden');
        }
        function openSkillsDeleteModal(id) {
            deleteSkillId = id;
            document.getElementById('skills-delete-modal').classList.remove('hidden');
        }
        function closeSkillsDeleteModal() {
            document.getElementById('skills-delete-modal').classList.add('hidden');
            deleteSkillId = null;
        }
        function confirmSkillsDelete() {
            if (deleteSkillId) {
                document.getElementById('skills-delete-form').action = '{{ url('my-info/qualifications/skills') }}/' + deleteSkillId;
                document.getElementById('skills-delete-form').submit();
            }
        }
        function openSkillsBulkDeleteModal() {
            document.getElementById('skills-bulk-delete-modal').classList.remove('hidden');
        }
        function closeSkillsBulkDeleteModal() {
            document.getElementById('skills-bulk-delete-modal').classList.add('hidden');
        }
        function confirmSkillsBulkDelete() {
            const checked = document.querySelectorAll('.skills-row-checkbox:checked');
            const ids = [];
            checked.forEach(cb => ids.push(cb.getAttribute('data-skill-id')));
            if (ids.length) {
                document.getElementById('skills-bulk-delete-ids').value = ids.join(',');
                document.getElementById('skills-bulk-delete-form').submit();
            }
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
            document.getElementById('language-modal').classList.add('hidden');
        }
        function openLanguagesDeleteModal(id) {
            deleteLanguageId = id;
            document.getElementById('languages-delete-modal').classList.remove('hidden');
        }
        function closeLanguagesDeleteModal() {
            document.getElementById('languages-delete-modal').classList.add('hidden');
            deleteLanguageId = null;
        }
        function confirmLanguagesDelete() {
            if (deleteLanguageId) {
                document.getElementById('languages-delete-form').action = '{{ url('my-info/qualifications/languages') }}/' + deleteLanguageId;
                document.getElementById('languages-delete-form').submit();
            }
        }
        function openLanguagesBulkDeleteModal() {
            document.getElementById('languages-bulk-delete-modal').classList.remove('hidden');
        }
        function closeLanguagesBulkDeleteModal() {
            document.getElementById('languages-bulk-delete-modal').classList.add('hidden');
        }
        function confirmLanguagesBulkDelete() {
            const checked = document.querySelectorAll('.languages-row-checkbox:checked');
            const ids = [];
            checked.forEach(cb => ids.push(cb.getAttribute('data-lang-id')));
            if (ids.length) {
                document.getElementById('languages-bulk-delete-ids').value = ids.join(',');
                document.getElementById('languages-bulk-delete-form').submit();
            }
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
            
            // Set date picker values for simple variant
            const issuedDateInput = document.getElementById('license-issued-date');
            if (issuedDateInput && data.issued_date) {
                issuedDateInput.value = data.issued_date;
            }
            const expiryDateInput = document.getElementById('license-expiry-date');
            if (expiryDateInput && data.expiry_date) {
                expiryDateInput.value = data.expiry_date;
            }
        }
        function closeLicenseForm() {
            document.getElementById('license-modal').classList.add('hidden');
        }
        function openLicensesDeleteModal(id) {
            deleteLicenseId = id;
            document.getElementById('licenses-delete-modal').classList.remove('hidden');
        }
        function closeLicensesDeleteModal() {
            document.getElementById('licenses-delete-modal').classList.add('hidden');
            deleteLicenseId = null;
        }
        function confirmLicensesDelete() {
            if (deleteLicenseId) {
                document.getElementById('licenses-delete-form').action = '{{ url('my-info/qualifications/licenses') }}/' + deleteLicenseId;
                document.getElementById('licenses-delete-form').submit();
            }
        }
        function openLicensesBulkDeleteModal() {
            document.getElementById('licenses-bulk-delete-modal').classList.remove('hidden');
        }
        function closeLicensesBulkDeleteModal() {
            document.getElementById('licenses-bulk-delete-modal').classList.add('hidden');
        }
        function confirmLicensesBulkDelete() {
            const checked = document.querySelectorAll('.licenses-row-checkbox:checked');
            const ids = [];
            checked.forEach(cb => ids.push(cb.getAttribute('data-license-id')));
            if (ids.length) {
                document.getElementById('licenses-bulk-delete-ids').value = ids.join(',');
                document.getElementById('licenses-bulk-delete-form').submit();
            }
        }

        // Checkbox functionality for all sections
        document.addEventListener('DOMContentLoaded', function() {
            // Work Experience checkboxes
            const workExpMaster = document.getElementById('work-exp-master-checkbox');
            const workExpCheckboxes = document.querySelectorAll('.work-exp-row-checkbox');
            if (workExpMaster) {
                workExpMaster.addEventListener('change', function() {
                    workExpCheckboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButtonVisibility('work-exp-delete-selected', workExpCheckboxes);
                });
            }
            workExpCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    updateMasterCheckboxState(workExpMaster, workExpCheckboxes);
                    updateDeleteButtonVisibility('work-exp-delete-selected', workExpCheckboxes);
                });
            });

            // Education checkboxes
            const educationMaster = document.getElementById('education-master-checkbox');
            const educationCheckboxes = document.querySelectorAll('.education-row-checkbox');
            if (educationMaster) {
                educationMaster.addEventListener('change', function() {
                    educationCheckboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButtonVisibility('education-delete-selected', educationCheckboxes);
                });
            }
            educationCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    updateMasterCheckboxState(educationMaster, educationCheckboxes);
                    updateDeleteButtonVisibility('education-delete-selected', educationCheckboxes);
                });
            });

            // Skills checkboxes
            const skillsMaster = document.getElementById('skills-master-checkbox');
            const skillsCheckboxes = document.querySelectorAll('.skills-row-checkbox');
            if (skillsMaster) {
                skillsMaster.addEventListener('change', function() {
                    skillsCheckboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButtonVisibility('skills-delete-selected', skillsCheckboxes);
                });
            }
            skillsCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    updateMasterCheckboxState(skillsMaster, skillsCheckboxes);
                    updateDeleteButtonVisibility('skills-delete-selected', skillsCheckboxes);
                });
            });

            // Languages checkboxes
            const languagesMaster = document.getElementById('languages-master-checkbox');
            const languagesCheckboxes = document.querySelectorAll('.languages-row-checkbox');
            if (languagesMaster) {
                languagesMaster.addEventListener('change', function() {
                    languagesCheckboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButtonVisibility('languages-delete-selected', languagesCheckboxes);
                });
            }
            languagesCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    updateMasterCheckboxState(languagesMaster, languagesCheckboxes);
                    updateDeleteButtonVisibility('languages-delete-selected', languagesCheckboxes);
                });
            });

            // Licenses checkboxes
            const licensesMaster = document.getElementById('licenses-master-checkbox');
            const licensesCheckboxes = document.querySelectorAll('.licenses-row-checkbox');
            if (licensesMaster) {
                licensesMaster.addEventListener('change', function() {
                    licensesCheckboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButtonVisibility('licenses-delete-selected', licensesCheckboxes);
                });
            }
            licensesCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    updateMasterCheckboxState(licensesMaster, licensesCheckboxes);
                    updateDeleteButtonVisibility('licenses-delete-selected', licensesCheckboxes);
                });
            });
        });

        function updateMasterCheckboxState(master, checkboxes) {
            const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length - (master && master.checked ? 1 : 0);
            const totalCount = checkboxes.length;
            if (master) {
                master.checked = checkedCount === totalCount && totalCount > 0;
                master.indeterminate = checkedCount > 0 && checkedCount < totalCount;
            }
        }

        function updateDeleteButtonVisibility(buttonId, checkboxes) {
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const button = document.getElementById(buttonId);
            if (button) {
                if (checkedCount > 0) {
                    button.classList.remove('hidden');
                } else {
                    button.classList.add('hidden');
                }
            }
        }

        // Delete ID variables
        var deleteWorkExpId = null;
        var deleteEducationId = null;
        var deleteSkillId = null;
        var deleteLanguageId = null;
        var deleteLicenseId = null;

        // Education View Functions
        function viewEducation(edu) {
            const content = document.getElementById('education-view-content');
            if (!content) return;

            content.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">Level</label>
                            <div class="text-sm" style="color: var(--text-primary);">${edu.level || '-'}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">Year</label>
                            <div class="text-sm" style="color: var(--text-primary);">${edu.year || '-'}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">Institute</label>
                            <div class="text-sm" style="color: var(--text-primary);">${edu.institute || '-'}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">Major/Specialization</label>
                            <div class="text-sm" style="color: var(--text-primary);">${edu.major_specialization || '-'}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">GPA/Score</label>
                            <div class="text-sm" style="color: var(--text-primary);">${edu.gpa_score || '-'}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">Start Date</label>
                            <div class="text-sm" style="color: var(--text-primary);">${edu.start_date || '-'}</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-muted);">End Date</label>
                        <div class="text-sm" style="color: var(--text-primary);">${edu.end_date || '-'}</div>
                    </div>
                </div>
            `;

            const modal = document.getElementById('education-view-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeEducationViewModal() {
            const modal = document.getElementById('education-view-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    </script>

    <!-- Education View Modal -->
    <x-admin.modal id="education-view-modal" title="View Education Details" maxWidth="md" backdropOnClick="closeEducationViewModal()">
        <div id="education-view-content">
            <!-- Content will be populated by JavaScript -->
        </div>
        <div class="flex justify-end gap-2 mt-4">
            <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeEducationViewModal()">Close</button>
        </div>
    </x-admin.modal>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('scroll_section'))
                const section = document.getElementById('{{ session('scroll_section') }}');
                if (section) {
                    setTimeout(() => {
                        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            @endif
        });
    </script>
@endsection